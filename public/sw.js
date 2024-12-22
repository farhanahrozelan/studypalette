const CACHE_NAME = 'study-palette-v1';
const FILES_TO_CACHE = [
    '/',
    '/offline.html',
    '/css/app.css',
    '/js/app.js',
    '/manifest.json',
];

// Preload essential files
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(FILES_TO_CACHE).catch((error) => {
                console.error('Failed to cache some files:', error);
            });
        })
    );
});


// Activate and clear old caches
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cache) => {
                    if (cache !== CACHE_NAME) {
                        console.log('Deleting old cache:', cache);
                        return caches.delete(cache);
                    }
                })
            );
        })
    );
});

// Fetch requests
self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            return (
                response ||
                fetch(event.request).catch(() => caches.match('/offline.html'))
            );
        })
    );
});
