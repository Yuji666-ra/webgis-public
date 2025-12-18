<!-- resources/views/accidents/index.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Accident Clusters</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 600px;
        }
    </style>
</head>
<body>
    <div id="map"></div>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([-7.250445, 112.768845], 12); // Set to your desired location

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        @foreach ($clusters as $point)
            L.circleMarker([{{ $point['latitude'] }}, {{ $point['longitude'] }}], {
                color: '{{ $point['color'] }}',
                radius: 8
            }).addTo(map);
        @endforeach
    </script>
</body>
</html>
