jQuery(document).ready(function ($) {
    const weatherWidget = $('#weather-widget');
    const localNewsContainer = $('#local-news-container'); // Need to add this container in front-page

    // --- Dark Mode Logic ---
    const html = document.documentElement;
    const themeToggles = document.querySelectorAll('#theme-toggle, #drawer-theme-toggle');

    function updateTheme(isDark) {
        if (isDark) {
            html.classList.add('dark');
            localStorage.theme = 'dark';
        } else {
            html.classList.remove('dark');
            localStorage.theme = 'light';
        }
    }

    themeToggles.forEach(toggle => {
        toggle.addEventListener('click', (e) => {
            e.preventDefault();
            const currentIsDark = html.classList.contains('dark');
            updateTheme(!currentIsDark);
        });
    });


    // --- Service Worker Registration ---
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register(modernnews_ajax.theme_url + '/assets/js/service-worker.js')
                .then(registration => {
                    console.log('Modern News SW registered:', registration.scope);
                })
                .catch(err => {
                    console.warn('Modern News SW registration failed:', err);
                });
        });
    }

    // --- Weather Logic with Caching ---
    function getUserLocation() {
        // Check cache first
        const cachedLocation = localStorage.getItem('modernnews_location');
        const cacheTime = localStorage.getItem('modernnews_location_time');
        const now = new Date().getTime();

        if (cachedLocation && cacheTime && (now - cacheTime < 3600000)) { // 1 hour cache for location
            const loc = JSON.parse(cachedLocation);
            getWeather(loc.city);
            getLocalNews(loc.city);
            return;
        }

        fetch('https://ipapi.co/json/')
            .then(response => response.json())
            .then(data => {
                const city = data.city;
                localStorage.setItem('modernnews_location', JSON.stringify({ city: city }));
                localStorage.setItem('modernnews_location_time', now);
                
                getWeather(city);
                getLocalNews(city);
            })
            .catch(error => {
                console.error('Error fetching location:', error);
                weatherWidget.html('<span class="weather-error">Weather unavailable</span>');
                getLocalNews('Jakarta');
            });
    }

    function getWeather(city) {
        const apiKey = modernnews_ajax.weather_api_key;
        const now = new Date().getTime();
        const cachedWeather = localStorage.getItem('modernnews_weather_' + city);
        const cacheTime = localStorage.getItem('modernnews_weather_time_' + city);

        if (cachedWeather && cacheTime && (now - cacheTime < 1800000)) { // 30 mins cache
            const data = JSON.parse(cachedWeather);
            renderWeatherWidget(city, data.temp, data.icon);
            return;
        }

        if (apiKey) {
            const weatherUrl = `https://api.openweathermap.org/data/2.5/weather?q=${encodeURIComponent(city)}&units=metric&appid=${apiKey}`;

            fetch(weatherUrl)
                .then(res => {
                    if (!res.ok) throw new Error('OWM Error');
                    return res.json();
                })
                .then(data => {
                    const temp = Math.round(data.main.temp);
                    const weatherMain = data.weather[0].main.toLowerCase();
                    const icon = getRemixIcon(weatherMain);

                    localStorage.setItem('modernnews_weather_' + city, JSON.stringify({ temp: temp, icon: icon }));
                    localStorage.setItem('modernnews_weather_time_' + city, now);

                    renderWeatherWidget(city, temp, icon);
                })
                .catch(err => {
                    console.warn('OWM failed, falling back to Open-Meteo', err);
                    getWeatherOpenMeteo(city);
                });

        } else {
            getWeatherOpenMeteo(city);
        }
    }

    function getRemixIcon(condition) {
        if (condition.includes('cloud')) return '<i class="ri-cloudy-line"></i>';
        if (condition.includes('rain')) return '<i class="ri-rainy-line"></i>';
        if (condition.includes('drizzle')) return '<i class="ri-drizzle-line"></i>';
        if (condition.includes('thunder')) return '<i class="ri-thunderstorms-line"></i>';
        if (condition.includes('snow')) return '<i class="ri-snowy-line"></i>';
        if (condition.includes('clear')) return '<i class="ri-sun-line"></i>';
        if (condition.includes('mist') || condition.includes('fog')) return '<i class="ri-mist-line"></i>';
        return '<i class="ri-temp-hot-line"></i>';
    }

    function renderWeatherWidget(city, temp, iconHtml) {
        const accuLink = `https://www.accuweather.com/id/search-locations?query=${encodeURIComponent(city)}`;

        const html = `
            <a href="${accuLink}" target="_blank" rel="noopener" class="weather-link" style="text-decoration:none; display:flex; align-items:center; color:inherit;">
                <div class="weather-info flex items-center bg-gray-50 dark:bg-zinc-800 px-3 py-1 rounded-full border border-gray-100 dark:border-zinc-700 h-9">
                    <span class="weather-icon text-primary mr-2 flex items-center text-lg">${iconHtml}</span>
                    <div class="flex flex-col leading-none">
                        <span class="weather-city text-[10px] font-bold uppercase tracking-wider opacity-60">${city}</span>
                        <span class="weather-temp text-xs font-black">${temp}°C</span>
                    </div>
                </div>
            </a>
        `;
        weatherWidget.html(html);
    }

    function getWeatherOpenMeteo(city) {
        // Reuse location logic or skip for brevity in open meteo fallback
        fetch('https://ipapi.co/json/')
            .then(res => res.json())
            .then(locData => {
                const lat = locData.latitude;
                const lon = locData.longitude;
                const weatherUrl = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current_weather=true`;

                fetch(weatherUrl)
                    .then(res => res.json())
                    .then(weatherData => {
                        const temp = Math.round(weatherData.current_weather.temperature);
                        const wcode = weatherData.current_weather.weathercode;
                        const icon = getRemixIconFromWMO(wcode);
                        
                        localStorage.setItem('modernnews_weather_' + city, JSON.stringify({ temp: temp, icon: icon }));
                        localStorage.setItem('modernnews_weather_time_' + city, new Date().getTime());

                        renderWeatherWidget(city, temp, icon);
                    });
            });
    }

    function getRemixIconFromWMO(code) {
        if (code === 0) return '<i class="ri-sun-line"></i>';
        if (code >= 1 && code <= 3) return '<i class="ri-cloudy-2-line"></i>';
        if (code >= 45 && code <= 48) return '<i class="ri-mist-line"></i>';
        if (code >= 51 && code <= 67) return '<i class="ri-rainy-line"></i>';
        if (code >= 71 && code <= 77) return '<i class="ri-snowy-line"></i>';
        if (code >= 80 && code <= 82) return '<i class="ri-showers-line"></i>';
        if (code >= 95 && code <= 99) return '<i class="ri-thunderstorms-line"></i>';
        return '<i class="ri-temp-hot-line"></i>';
    }

    // Init
    getUserLocation();

    // 3. Fetch Local News via AJAX
    function getLocalNews(city) {
        // If we are on homepage, look for the local news container
        if ($('body').hasClass('home')) {
            const newsGrid = $('#local-news-grid');

            // Show Skeleton Loading
            let skeletonHtml = '';
            for (let i = 0; i < 4; i++) {
                skeletonHtml += `
                    <div class="skeleton-card">
                        <div class="skeleton-image"></div>
                        <div class="skeleton-content">
                            <div class="skeleton-line"></div>
                            <div class="skeleton-line short"></div>
                        </div>
                    </div>
                `;
            }
            newsGrid.html(skeletonHtml);

            $.ajax({
                url: modernnews_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'get_local_news',
                    nonce: modernnews_ajax.nonce,
                    city: city
                },
                success: function (response) {
                    newsGrid.html(response);
                    $('.local-news-title span').text(city); // Update title
                }
            });
        }
    }

    // 4. Scroll to Top
    const scrollToTopBtn = $('#scroll-to-top');

    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            scrollToTopBtn.removeClass('opacity-0 invisible translate-y-10').addClass('opacity-100 visible translate-y-0');
        } else {
            scrollToTopBtn.addClass('opacity-0 invisible translate-y-10').removeClass('opacity-100 visible translate-y-0');
        }
    });

    scrollToTopBtn.click(function (e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, 600);
        return false;
    });


    // 3. Archive Page Filtering
    $('.filter-chip').on('click', function (e) {
        e.preventDefault();

        const button = $(this);
        const tagId = button.data('tag-id');
        const catId = $('#current-archive-cat').val();

        // UI updates
        $('.filter-chip').removeClass('active bg-primary text-white').addClass('bg-soft-gray text-text-dark dark:bg-zinc-800 dark:text-white');
        button.removeClass('bg-soft-gray text-text-dark dark:bg-zinc-800 dark:text-white').addClass('active bg-primary text-white');

        const container = $('#modernnews-archive-posts-container');
        container.css('opacity', '0.5');

        $.ajax({
            url: modernnews_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'modernnews_filter_archive',
                category_id: catId,
                tag_id: tagId,
                nonce: modernnews_ajax.nonce
            },
            success: function (response) {
                container.html(response);
                container.css('opacity', '1');
            },
            error: function () {
                container.css('opacity', '1');
                alert('Gagal memuat berita. Silakan coba lagi.');
            }
        });
    });


    // 4. Load More Button
    $('#modernnews-load-more').on('click', function () {
        const button = $(this);
        const spinner = $('#load-more-spinner');
        const catId = $('#current-archive-cat').val();
        const activeTag = $('.filter-chip.active').data('tag-id') || 'all';

        let currentPage = parseInt(button.data('page'));
        const maxPage = parseInt(button.data('max-page'));

        if (currentPage >= maxPage) {
            button.hide();
            return;
        }

        button.attr('disabled', true);
        spinner.removeClass('hidden');

        const nextPage = currentPage + 1;

        $.ajax({
            url: modernnews_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'modernnews_filter_archive',
                category_id: catId,
                tag_id: activeTag,
                paged: nextPage,
                nonce: modernnews_ajax.nonce
            },
            success: function (response) {
                if (response.trim() !== '') {
                    $('#modernnews-post-list').append(response); // Append specifically to the list container
                    button.data('page', nextPage);

                    if (nextPage >= maxPage) {
                        button.hide();
                    }
                } else {
                    button.hide();
                }

                button.attr('disabled', false);
                spinner.addClass('hidden');
            },
            error: function () {
                button.attr('disabled', false);
                spinner.addClass('hidden');
                alert('Gagal memuat berita.');
            }
        });
    });

    // 5. Reading Progress Bar
    const progressBar = $('#reading-progress-bar');
    if (progressBar.length) {
        $(window).scroll(function () {
            const scrollTop = $(window).scrollTop();
            const docHeight = $(document).height() - $(window).height();
            const scrollPercent = (scrollTop / docHeight) * 100;
            progressBar.css('width', scrollPercent + '%');
        });
    }

    // 6. Modern Search Overlay
    const searchOverlay = $('#modernnews-search-overlay');
    const searchInput = $('#modernnews-search-input');
    const searchClose = $('#modernnews-search-close');

    function openSearch() {
        searchOverlay.removeClass('hidden').addClass('flex');
        setTimeout(() => {
            searchOverlay.removeClass('opacity-0');
            searchInput.focus();
        }, 10);
        $('body').addClass('overflow-hidden');
    }

    function closeSearch() {
        searchOverlay.addClass('opacity-0');
        setTimeout(() => {
            searchOverlay.addClass('hidden').removeClass('flex');
            $('body').removeClass('overflow-hidden');
        }, 300);
    }

    // Trigger Logic
    $(document).on('click', '.modernnews-search-trigger, .search-toggle-btn', function (e) {
        e.preventDefault();
        openSearch();
    });

    // Optional: Hijack the header search input click to open full overlay?
    // $('header input[type="search"]').on('click focus', function(e) {
    //    e.preventDefault();
    //    openSearch(); 
    //    $(this).blur();
    // });

    searchClose.on('click', closeSearch);

    $(document).on('keydown', function (e) {
        if (e.key === "Escape") closeSearch();
    });

    // 7. Mobile Menu & Drawer Toggle
    const mobileMenuBtn = $('#mobile-menu-toggle');
    const mobileMenuCloseBtn = $('#mobile-menu-close');
    const mobileMenuBottomBtn = $('#mobile-menu-trigger-bottom');
    const mobileMenuOverlay = $('#mobile-menu-overlay');
    const mobileMenu = $('#mobile-menu-container');

    function openMobileMenu() {
        // Overlay
        mobileMenuOverlay.removeClass('hidden pointer-events-none opacity-0').addClass('opacity-100 pointer-events-auto');
        
        // Menu
        mobileMenu.removeClass('hidden');
        setTimeout(() => {
            mobileMenu.removeClass('-translate-x-full').addClass('translate-x-0');
        }, 10);
        
        $('body').addClass('overflow-hidden');
    }

    function closeMobileMenu() {
        // Overlay
        mobileMenuOverlay.removeClass('opacity-100 pointer-events-auto').addClass('opacity-0 pointer-events-none');
        // Menu
        mobileMenu.removeClass('translate-x-0').addClass('-translate-x-full');
        
        $('body').removeClass('overflow-hidden');
        
        setTimeout(() => {
            mobileMenuOverlay.addClass('hidden');
            mobileMenu.addClass('hidden');
        }, 300); // match transition duration
    }

    mobileMenuBtn.on('click', function (e) {
        e.preventDefault();
        openMobileMenu();
    });

    mobileMenuCloseBtn.on('click', closeMobileMenu);
    mobileMenuOverlay.on('click', closeMobileMenu);
    mobileMenuBottomBtn.on('click', function (e) {
        e.preventDefault();
        openMobileMenu();
    });

    // Close menu when link is clicked (if it's not a submenu toggle)
    mobileMenu.find('a').on('click', function () {
        closeMobileMenu();
    });

    // Mobile Submenu Toggle
    $(document).on('click', '.mobile-menu-toggle', function (e) {
        e.preventDefault();
        e.stopPropagation();
        
        const btn = $(this);
        const submenu = btn.parent().next('ul');
        const parentLi = btn.closest('li');

        if (submenu.length) {
            // Accordion: Close other open submenus at the same level
            parentLi.siblings().find('> div > .mobile-menu-toggle.text-primary').each(function() {
                const otherBtn = $(this);
                const otherSubmenu = otherBtn.parent().next('ul');
                otherSubmenu.slideUp(300);
                otherBtn.find('span').removeClass('rotate-180');
                otherBtn.removeClass('text-primary');
            });

            // Toggle current
            submenu.slideToggle(300);
            btn.find('span').toggleClass('rotate-180');
            btn.toggleClass('text-primary');
        }
    });

    // Mobile Search Input inside Drawer
    const mobileDrawerSearch = $('#mobile-menu-container input[type="search"]');
    mobileDrawerSearch.on('focus', function() {
        // Optional: Pre-fill or animation
    });

    // 7b. Native Touch Gestures (Swipe to Close)
    let touchStartX = 0;
    let touchCurrentX = 0;
    const drawerThreshold = 100; // Minimum swipe distance to close

    // Only apply if drawer is open
    mobileMenu.on('touchstart', function (e) {
        touchStartX = e.originalEvent.touches[0].clientX;
        touchCurrentX = touchStartX;
        // Don't prevent default, allow scrolling inside drawer
    });

    mobileMenu.on('touchmove', function (e) {
        touchCurrentX = e.originalEvent.touches[0].clientX;

        // Calculate delta (only care about left swipe)
        const deltaX = touchCurrentX - touchStartX;

        // If swiping left (negative delta) and drawer is open
        if (deltaX < 0 && !mobileMenu.hasClass('-translate-x-full')) {
            // Optional: Add visual feedback (transform)
            // Clamping: Max move is drawer width or limit
            // mobileMenu.css('transform', `translateX(${deltaX}px)`); 
            // Note: Direct CSS manipulation might conflict with transition classes, 
            // better to just detect intent on touchend or use a library like Hammer.js but we want vanilla/jquery lite.
        }
    });

    mobileMenu.on('touchend', function (e) {
        const deltaX = touchCurrentX - touchStartX;

        // If swiped left significantly
        if (deltaX < -drawerThreshold && mobileMenu.hasClass('open')) {
            closeMobileMenu();
        }

        // Reset
        touchStartX = 0;
        touchCurrentX = 0;
    });

    // 8. Auto-Hide Bottom Nav on Scroll (Optional but makes it feel native-lite)
    let lastScrollTop = 0;
    const bottomNav = $('#mobile-bottom-nav');

    $(window).scroll(function (event) {
        let st = $(this).scrollTop();
        if (st > lastScrollTop && st > 100) {
            // Scroll Down
            bottomNav.css('transform', 'translateY(100%)');
        } else {
            // Scroll Up
            bottomNav.css('transform', 'translateY(0)');
        }
        lastScrollTop = st;
    });

    // Init
    getUserLocation();
});
