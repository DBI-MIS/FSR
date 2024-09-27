const OFFLINE_VERSION = 1;
const CACHE_NAME = 'v1.0.0';
const OFFLINE_URL = "https://fsr.dbiphils.com/offline.html";

const cacheAssets = [
    '/favicon.ico',
    OFFLINE_URL,
];

// Installation event: Cache essential assets
self.addEventListener('install', event => {
    event.waitUntil(
        (async () => {
            const cache = await caches.open(CACHE_NAME);
            // Add core assets and offline page
            await cache.addAll(cacheAssets);
        })()
    );
    // Force the waiting service worker to become the active one immediately
    self.skipWaiting();
});

// Activation event: Clean up old caches
self.addEventListener('activate', event => {
    event.waitUntil(
        (async () => {
            const keyList = await caches.keys();
            // Delete any cache not matching the current CACHE_NAME
            await Promise.all(
                keyList.map(key => {
                    if (key !== CACHE_NAME) {
                        return caches.delete(key);
                    }
                })
            );
            // Enable navigation preload if supported
            if ('navigationPreload' in self.registration) {
                await self.registration.navigationPreload.enable();
            }
        })()
    );
    // Take control of the page immediately
    self.clients.claim();
});

// Fetch event: Serve cached content or fallback to network
self.addEventListener('fetch', event => {
    if (event.request.mode === 'navigate') {
        event.respondWith(
            (async () => {
                try {
                    // Use navigation preload response if available
                    const preloadResponse = await event.preloadResponse;
                    if (preloadResponse) {
                        return preloadResponse;
                    }

                    // Try the network first
                    const networkResponse = await fetch(event.request);
                    return networkResponse;
                } catch (error) {
                    console.log("Fetch failed; returning offline page instead.", error);
                    // Serve the offline fallback from cache
                    const cache = await caches.open(CACHE_NAME);
                    return await cache.match(OFFLINE_URL);
                }
            })()
        );
    } else {
        // Serve cached assets if available, otherwise fallback to network
        event.respondWith(
            caches.match(event.request).then(response => {
                return response || fetch(event.request);
            })
        );
    }
});
