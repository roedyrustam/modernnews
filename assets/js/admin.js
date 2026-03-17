jQuery(document).ready(function ($) {
    // Initialize Color Picker
    if ($.isFunction($.fn.wpColorPicker)) {
        $('.modernnews-color-picker').wpColorPicker();
    }

    // Tab Switching Logic with Persistence
    const activeTab = localStorage.getItem('modernnews_active_tab');
    if (activeTab) {
        $('.modernnews-tab-link').removeClass('active');
        $('.modernnews-tab-content').removeClass('active');
        $(`.modernnews-tab-link[data-tab="${activeTab}"]`).addClass('active');
        $('#' + activeTab).addClass('active');
    }

    $('.modernnews-tab-link').on('click', function (e) {
        e.preventDefault();

        const tabID = $(this).data('tab');

        // Remove active class from all tabs and content
        $('.modernnews-tab-link').removeClass('active');
        $('.modernnews-tab-content').removeClass('active');

        // Add active class to clicked tab
        $(this).addClass('active');

        // Show corresponding content
        $('#' + tabID).addClass('active');

        // Persist tab selection
        localStorage.setItem('modernnews_active_tab', tabID);

        // Smooth scroll to top on mobile
        if ($(window).width() <= 1024) {
            $('html, body').animate({
                scrollTop: $(".modernnews-admin-content").offset().top - 100
            }, 500);
        }
    });

    // Save Bar Feedback
    $('form').on('change', 'input, select, textarea', function() {
        $('.modernnews-admin-save-bar').addClass('unsaved-changes');
    });
});
