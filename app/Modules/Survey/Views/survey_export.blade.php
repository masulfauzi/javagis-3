@extends('layouts.app')

@section('page-css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

        

    
@endsection


@section('main')
    <div class="page-heading">
        <div class="page-title">
            <div class="row mb-2">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <a href="{{ route('kups.index') }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i
                            class="fa fa-arrow-left"></i> Kembali </a>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('kups.index') }}">{{ $title }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $kps->nama }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <h6 class="card-header">
                    Detail Data {{ $title }}: {{ $kps->nama }}
                </h6>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-2">
                            <div class="row">
                                <div class='col-lg-2'>
                                    <p>Nama Kups</p>
                                </div>
                                <div class='col-lg-10'>
                                    <p class='fw-bold'>{{ $kps->nama_kps }}</p>
                                </div>
                                <div class='col-lg-2'>
                                    <p>Kps</p>
                                </div>
                                <div class='col-lg-10'>
                                    <p class='fw-bold'>{{ $kps->nama_kps }}</p>
                                </div>

                                <div class='col-lg-2'>
                                    <p>Wilayah</p>
                                </div>
                                <div class='col-lg-10'>
                                    <p class='fw-bold'>{{ $kps->desa->nama_desa }} - {{ $kps->desa->kecamatan->nama_kecamatan }} - {{ $kps->desa->kecamatan->kabupaten->nama_kabupaten }} - {{ $kps->desa->kecamatan->kabupaten->provinsi->nama_provinsi }} - {{ $kps->desa->kecamatan->kabupaten->provinsi->seksiWilayah->nama_seksi_wilayah }} - {{ $kps->desa->kecamatan->kabupaten->provinsi->seksiWilayah->balaiPskl->nama_balai_pskl }}
                                    </p>
                                </div>
                                
                                <div class='col-lg-2'>
                                    <p>Survey</p>
                                </div>
                                <div class='col-lg-10'>
                                    <p class='fw-bold'>{{ $survey->nama_survey }}
                                    </p>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <section class="section">

            <div class="row" id="section-to-print">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-body">
                            <div id="map" style="width: 100%; height: 600px;">
                                
                            </div>
                            <button class="manualButton" onclick="manualPrint()">Manual print</button>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true"
        style="overflow:hidden;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body">
                    ...
                </div>

            </div>
        </div>

    </div>
@endsection

@section('page-js')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.js"></script>
    <script src="{{ asset('assets/js/extensions/easyprint/dist/bundle.js') }}"></script>

    <script>
        // OSM layers
        var osmUrl = 'https://{s}.tile.osm.org/{z}/{x}/{y}.png';
        var osmAttrib = 'Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
        var osm = new L.TileLayer(osmUrl, {
            attribution: osmAttrib
        });

        var map = L.map('map', {
            doubleClickZoom: false,
            layers: [osm],
            cursor: true
        }).setView([{{ $kps->koord_y }}, {{ $kps->koord_x }}], 13);;

        map.addLayer(osm);

        <?php
        
        if ($kps->geojson) {
            echo "var layerKps = $kps->geojson;";
        
            echo 'var myStyle = {
                                    "color": "#ff7800",
                                    "weight": 5,
                                    "opacity": 0.65
                                };';
        
            echo "L.geoJSON(layerKps, {
                                        style: myStyle
                                    }).addTo(map).bindPopup('Area KPS $kps->nama_kps');";
        }
        
        ?>

        var koord_survey = {"type":"Feature",
                                "properties":{},
                                "geometry":{
                                    "type":"Polygon",
                                    "coordinates":[
                                        [
                                            @foreach($koord_survey as $item)
                                            [{{ $item->koord_y }},{{ $item->koord_x }}],
                                            @endforeach
                                        ]
                                    ]
                                }
                            };

        L.geoJSON(koord_survey).addTo(map).bindPopup('{{ $survey->nama_survey }}');


        var printer = L.easyPrint({
      		tileLayer: osm,
      		sizeModes: ['Current'],
      		filename: 'myMap',
      		exportOnly: true,
      		hideControlContainer: true,
            tileWait: 1000,
            hidden: true
		}).addTo(map);

        function manualPrint () {
			printer.printMap('CurrentSize', 'MyManualPrint');

            // console.log('kdfgskdf');
		}

        const originalBlob = window.Blob;
        window.Blob = function(blobParts, options) {
            const blob = new originalBlob(blobParts, options);

            // If it's an image (or any specific condition you want), post it
            if (blob.type.startsWith('image/')) {
                console.log('Image Blob created:', blob);
                
                // 2. Post Blob to a URL
                postBlobToServer(blob);
            }

            return blob;
        };

        function postBlobToServer(blob) {
            // Prepare the form data
            const formData = new FormData();
            formData.append('image', blob, 'uploaded-image.jpg'); // Name the file and set its type
            formData.append('id_survey', '{{ $survey->id }}'); // Name the file and set its type
            formData.append('_token', '{{ csrf_token() }}'); // Name the file and set its type

            // Send it via fetch to the desired URL
            fetch('{{ route('survey.save_image.store') }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                window.location.replace("{{ route('survey.print.show', $survey->id) }}");
            });
        }
    </script>
@endsection

@section('inline-js')
@endsection
