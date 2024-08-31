self.addEventListener('install', function(event) {
    // Perform install steps
    console.log('Service Worker installing.');
});

self.addEventListener('fetch', function(event) {
    // Perform fetch steps
    console.log('Service Worker fetching.');
});