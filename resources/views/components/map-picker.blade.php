<div id="map" style="height: 300px; border-radius: 10px; margin-top: 10px;"></div>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // 1. Buat map, default di Jakarta
    const map = L.map('map').setView([-6.2, 106.8], 10);

    // 2. Load tile dari OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    let marker;

    // 3. Ambil input lokasi
    const input = document.getElementById('pickup-location');

    // 4. Klik map → set marker dan ambil alamat
    map.on('click', function(e) {
        const { lat, lng } = e.latlng;

        // Tambahkan marker
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng]).addTo(map);
        }

        // Ambil alamat dari koordinat menggunakan Nominatim (gratis)
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
            .then(res => res.json())
            .then(data => {
                if (data.display_name) {
                    input.value = data.display_name; // isi input
                }
            });
    });

});
</script>