<div>
    <div id="map-{{ $attributes->get('id') }}" style="height: 200px; width: 100%;"></div>
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil data latitude dan longitude dari atribut
        const latitude = parseFloat('{{ $attributes->get('latitude') ?? -6.3437692 }}');
        const longitude = parseFloat('{{ $attributes->get('longitude') ?? 106.6757172 }}');
        const mapId = "map-{{ $attributes->get('id') }}";

        // Validasi apakah data latitude dan longitude valid
        if (!isNaN(latitude) && !isNaN(longitude) && latitude !== 0 && longitude !== 0) {
            // Inisialisasi peta dengan Leaflet
            const map = L.map(mapId).setView([latitude, longitude], 13);

            // Tambahkan tile layer untuk peta
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
            }).addTo(map);

            // Tambahkan marker di lokasi latitude dan longitude
            L.marker([latitude, longitude]).addTo(map)
                .bindPopup(`Latitude: ${latitude}<br>Longitude: ${longitude}`);
        } else {
            // Jika data tidak valid, tampilkan pesan error
            document.getElementById(mapId).innerHTML = "Invalid latitude or longitude.";
        }
    });
</script>
