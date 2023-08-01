// This is the "Offline page" service worker

importScripts('https://storage.googleapis.com/workbox-cdn/releases/5.1.2/workbox-sw.js');

const VERSION = '1.0.0';
const CACHE_NAME = "wct-cache-v" + VERSION;
const QUEUE_NAME = "wct-SyncQ-v" + VERSION;

// // TODO: replace the following with the correct offline fallback page i.e.: const offlineFallbackPage = "offline.html";
const offlineFallbackPage = "offline.html";


self.addEventListener("message", (event) => {
  if (event.data && event.data.type === "SKIP_WAITING") {
    self.skipWaiting();
  }
});

// self.addEventListener('fetch', (e) => {
//   e.respondWith((async () => {
//     const r = await caches.match(e.request);
//     console.log(`[Service Worker] Fetching resource: ${e.request.url}`);
//     if (r) { return r; }
//     const response = await fetch(e.request);
//     const cache = await caches.open(cacheName);
//     console.log(`[Service Worker] Caching new resource: ${e.request.url}`);
//     cache.put(e.request, response.clone());
//     return response;
//   })());
// });

self.addEventListener('install', async (e) => {
  console.log('[Service Worker] Install');

  e.waitUntil((async () => {

    const cache = await caches.open(CACHE_NAME);
    console.log('[Service Worker] Caching all: app shell and content');

    await cache.add(offlineFallbackPage);
  })());
});

// if (workbox.navigationPreload.isSupported()) {
//   workbox.navigationPreload.enable();

// const bgSyncPlugin = new workbox.backgroundSync.BackgroundSyncPlugin(QUEUE_NAME, {
//   maxRetentionTime: 3 // Retry for max of 24 Hours (specified in minutes)
// });

// workbox.routing.registerRoute(
//   new RegExp('/*'),
//   new workbox.strategies.StaleWhileRevalidate({
//     cacheName: CACHE_NAME,
//     plugins: [
//       bgSyncPlugin
//     ]
//   })
// );
// }

self.addEventListener('fetch', (event) => {
  if (event.request.mode === 'navigate') {
    event.respondWith((async () => {
      try {
        const preloadResp = await event.preloadResponse;

        if (preloadResp) {
          return preloadResp;
        }

        const networkResp = await fetch(event.request);
        return networkResp;
      } catch (error) {

        const cache = await caches.open(CACHE_NAME);
        const cachedResp = await cache.match(offlineFallbackPage);
        return cachedResp;
      }
    })());
  }
});
