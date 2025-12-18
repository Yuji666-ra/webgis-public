@extends('layouts.app')

@section('title', 'Peta Risiko - SAFETRACK')

@push('styles')
    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    {{-- File CSS lokal --}}
    @vite(['resources/css/peta-cluster.css'])

    {{-- Geocoder --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
@endpush

@section('content')
    <section class="peta-section page-peta">
        <div class="container-fluid p-0">

            <h2 class="map-title text-center fw-bold">
                Peta Daerah Rawan Kecelakaan di Kabupaten Lumajang
            </h2>

            {{-- ========== CONTROL BAR ========== --}}
            <div class="map-controls container-fluid">
                <div class="controls-inner">

                    {{-- ========== CONTROLS: Filter + Dropdown ========== --}}
                    <div class="controls-wrapper">

                        <div class="filter-cluster-row d-flex align-items-center gap-3">
                            <label class="d-flex align-items-center gap-1">
                                <input type="checkbox" class="filter-check" value="2" checked>
                                <span class="dot dot-red"></span> Berat
                            </label>
                            <label class="d-flex align-items-center gap-1">
                                <input type="checkbox" class="filter-check" value="1" checked>
                                <span class="dot dot-yellow"></span> Sedang
                            </label>
                            <label class="d-flex align-items-center gap-1">
                                <input type="checkbox" class="filter-check" value="0" checked>
                                <span class="dot dot-green"></span> Ringan
                            </label>
                        </div>

                        <div class="dropdown-reset-row d-flex align-items-center gap-2 ms-3">
                            <select id="selectKecamatan" class="form-select form-select-sm w-auto">
                                <option value="" selected hidden>Pilih Kecamatan</option>
                            </select>

                            <button id="btn-reset" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-arrow-repeat"></i>
                            </button>
                        </div>

                    </div>



                </div>
            </div>
        </div>

        {{-- ========== MAP + SIDE PANEL ========== --}}
        <div class="map-flex-layout">
            <div id="map" class="map-container"></div>

            <div class="side-panel" id="sidePanel">
                <h5 class="side-title">Informasi Zona Risiko</h5>

                <div class="zone-item zone-red">
                    <strong>Cluster-2 / Zona Berat:</strong> <span id="panel-red">0</span>
                    <ul id="list-red" class="zone-list"></ul>
                </div>

                <div class="zone-item zone-yellow">
                    <strong>Cluster-1 / Zona Sedang:</strong> <span id="panel-yellow">0</span>
                    <ul id="list-yellow" class="zone-list"></ul>
                </div>

                <div class="zone-item zone-green">
                    <strong>Cluster-0 / Zona Ringan:</strong> <span id="panel-green">0</span>
                    <ul id="list-green" class="zone-list"></ul>
                </div>


                <div class="warning-box">
                    ⚠️ <strong>Catatan:</strong>
                    <p>Zona merah memerlukan perhatian ekstra terutama saat musim liburan dan arus mudik.</p>
                </div>
            </div>
        </div>

        {{-- ========== TABLE DESKRIPSI ========== --}}
        <div class="container-fluid mt-4">
            <h4 class="text-center fw-bold mb-3">Tabel Deskripsi Daerah Rawan Kecelakaan per Kecamatan</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="tabel-deskripsi">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Kecamatan</th>
                            <th>Meninggal Dunia</th>
                            <th>Luka Berat</th>
                            <th>Luka Ringan</th>
                            <th>Total Korban</th>
                            <th>Jumlah Kejadian</th>
                            <th>Tingkat Kecelakaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tabelData ?? [] as $index => $row)
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>
                                <td class="text-start">{{ $row['kecamatan'] }}</td>
                                <td>{{ $row['jumlah_meninggal_dunia'] ?? 0 }}</td>
                                <td>{{ $row['jumlah_luka_berat'] ?? 0 }}</td>
                                <td>{{ $row['jumlah_luka_ringan'] ?? 0 }}</td>
                                <td>{{ $row['total_korban'] ?? 0 }}</td>
                                <td>{{ $row['jumlah_kejadian'] ?? 0 }}</td>
                                <td>{{ $row['tingkat_kecelakaan'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{-- Dependencies --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    {{-- Turf.js (harus sebelum pemakaian turf.union) --}}
    <script src="https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {

            /* ===============================
               INIT MAP
            =============================== */
            const initialCenter = [-8.133, 113.226];

            const map = L.map('map', {
                    zoomControl: false
                })
                .setView(initialCenter, 10);

            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                minZoom: 10,
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            L.control.zoom({
                position: 'topright'
            }).addTo(map);
            L.control.scale({
                position: 'bottomleft',
                imperial: false
            }).addTo(map);

            /* ===============================
               GLOBAL STATE
            =============================== */
            const clusters = {
                0: L.layerGroup().addTo(map),
                1: L.layerGroup().addTo(map),
                2: L.layerGroup().addTo(map),
            };

            const labelLayer = L.layerGroup().addTo(map);
            const featuresIndex = [];
            const selectKec = document.getElementById('selectKecamatan');

            const colorByRank = r => ({
                2: '#ff3b30',
                1: '#ffcc00',
                0: '#34c759'
            } [r] || '#999');

            const popupTemplate = p => `
        <div class="popup-content">
            <strong>${p.kecamatan ?? p.KECAMATAN ?? '-'}</strong><br>
            Cluster: ${p.cluster_ranked ?? '-'}<br>
            Jumlah Kejadian: ${p.jumlah_kejadian ?? '-'}<br>
            Total Korban: ${p.total_korban ?? '-'}
        </div>
    `;

            /* ===============================
               FETCH GEOJSON (SATU KALI)
            =============================== */
            fetch('/data/hasil_klaster.geojson')
                .then(r => {
                    if (!r.ok) throw new Error(r.status);
                    return r.json();
                })
                .then(geo => {

                    const geoLayer = L.geoJSON(geo, {
                        style: f => ({
                            color: '#444',
                            weight: 1,
                            fillColor: colorByRank(
                                Number(f.properties?.cluster_ranked ?? 0)
                            ),
                            fillOpacity: 0.7
                        }),
                        onEachFeature: (feature, layer) => {

                            const p = feature.properties ?? {};
                            const rank = Number(p.cluster_ranked ?? 0);
                            const name = (p.kecamatan ?? p.KECAMATAN ?? 'Unknown').toString();

                            layer.bindPopup(popupTemplate(p));
                            clusters[rank]?.addLayer(layer);

                            let bounds = null;
                            try {
                                bounds = layer.getBounds();
                            } catch {}

                            featuresIndex.push({
                                name,
                                rank,
                                bounds,
                                layer
                            });

                            if (bounds) {
                                labelLayer.addLayer(
                                    L.marker(bounds.getCenter(), {
                                        interactive: false,
                                        icon: L.divIcon({
                                            className: 'kec-label',
                                            html: `<div>${name}</div>`
                                        })
                                    })
                                );
                            }
                        }
                    }).addTo(map);

                    try {
                        map.fitBounds(geoLayer.getBounds().pad(0.08));
                    } catch {}

                    /* ===============================
                       DROPDOWN KECAMATAN
                    =============================== */
                    if (selectKec) {
                        featuresIndex
                            .sort((a, b) => a.name.localeCompare(b.name, 'id'))
                            .forEach((f, i) => {
                                const opt = document.createElement('option');
                                opt.value = i;
                                opt.textContent = f.name;
                                selectKec.appendChild(opt);
                            });

                        selectKec.addEventListener('change', e => {
                            const item = featuresIndex[e.target.value];
                            if (item?.bounds) {
                                map.fitBounds(item.bounds.pad(0.8));
                                item.layer.openPopup();
                            }
                        });
                    }

                    /* ===============================
                       SIDE PANEL LIST
                    =============================== */
                    const zonaList = {
                        2: document.getElementById("list-red"),
                        1: document.getElementById("list-yellow"),
                        0: document.getElementById("list-green"),
                    };

                    featuresIndex.forEach(f => {
                        const li = document.createElement("li");
                        li.textContent = f.name;
                        zonaList[f.rank]?.appendChild(li);
                    });

                    /* ===============================
                       FILTER CLUSTER
                    =============================== */
                    document.querySelectorAll('.filter-check').forEach(cb => {
                        cb.addEventListener('change', e => {
                            const val = Number(e.target.value);
                            if (e.target.checked) clusters[val].addTo(map);
                            else map.removeLayer(clusters[val]);
                        });
                    });

                    /* ===============================
                       RESET BUTTON
                    =============================== */
                    const btnReset = document.getElementById('btn-reset');
                    if (btnReset) {
                        btnReset.addEventListener('click', () => {
                            if (selectKec) selectKec.value = '';
                            map.setView(initialCenter, 10);
                        });
                    }

                    /* ===============================
                       LEGEND
                    =============================== */
                    const legend = L.control({
                        position: "bottomright"
                    });
                    legend.onAdd = () => {
                        const div = L.DomUtil.create("div", "legend");
                        div.innerHTML = `
                    <div class="legend-title">Kategori Zona</div>
                    <div class="legend-row"><i class="i-red"></i> Zona Berat</div>
                    <div class="legend-row"><i class="i-yellow"></i> Zona Sedang</div>
                    <div class="legend-row"><i class="i-green"></i> Zona Ringan</div>
                `;
                        return div;
                    };
                    legend.addTo(map);

                    /* ===============================
                       KOMPAS UTARA
                    =============================== */
                    const north = L.control({
                        position: 'topright'
                    });
                    north.onAdd = () => {
                        const div = L.DomUtil.create('div', 'north-indicator');
                        div.innerHTML = '<span class="ni">N</span>';
                        return div;
                    };
                    north.addTo(map);

                    /* ===============================
                       PANEL COUNTER (DARI LARAVEL)
                    =============================== */
                    document.getElementById('panel-red').innerText = @json($zonaBerat ?? 0);
                    document.getElementById('panel-yellow').innerText = @json($zonaSedang ?? 0);
                    document.getElementById('panel-green').innerText = @json($zonaRingan ?? 0);

                    /* ===============================
                       DATATABLE
                    =============================== */
                    $('#tabel-deskripsi').DataTable({
                        paging: true,
                        pageLength: 10,
                        lengthChange: false,
                        searching: true,
                        ordering: true,
                        info: false,
                        autoWidth: false
                    });

                    setTimeout(() => map.invalidateSize(), 300);
                })
                .catch(err => console.error('GeoJSON error:', err));
        });
    </script>
@endpush
