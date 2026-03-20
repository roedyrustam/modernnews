/*
 * Modern News Service Worker
 * Handles offline caching for core assets.
 */

const CACHE_NAME = 'modernnews-v1';
const ASSETS_TO_CACHE = [
    '/',
    '/wp-content/themes/modernnews/style.css',
    '/wp-content/themes/modernnews/assets/css/main.css',
    '/wp-content/themes/modernnews/assets/js/main.js',
    '/wp-content/themes/modernnews/manifest.json',
    'https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(ASSETS_TO_CACHE);
        })
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.filter((cacheName) => cacheName !== CACHE_NAME)
                          .map((cacheName) => caches.delete(cacheName))
            );
        })
    );
});

self.addEventListener('fetch', (event) => {
    // Only cache GET requests
    if (event.request.method !== 'GET') return;

    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request).then((fetchResponse) => {
                // Don't cache admin pages or preview
                const url = new URL(event.request.url);
                if (url.pathname.includes('/wp-admin/') || url.pathname.includes('/wp-login.php')) {
                    return fetchResponse;
                }

                // Cache successful responses from same origin or CDNs
                if (fetchResponse.status === 200 && (url.origin === self.location.origin || url.hostname.includes('cdn'))) {
                    const responseToCache = fetchResponse.clone();
                    caches.open(CACHE_NAME).then((cache) => {
                        cache.put(event.request, responseToCache);
                    });
                }
                return fetchResponse;
            });
        }).catch(() => {
            // Offline fallback for navigation
            if (event.request.mode === 'navigate') {
                return caches.match('/');
            }
        })
    );
});
