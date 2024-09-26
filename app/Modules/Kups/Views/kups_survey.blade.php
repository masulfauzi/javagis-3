@extends('layouts.app')

@section('page-css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <style>
        #tracking {
            display: flex;
            align-items: center;
            position: absolute;
            top: 500px;
            right: 11px;
            width: 32px;
            height: 32px;
            background-color: white;
            border-radius: 3px;
            border-color: gray;
            border-style: solid;
            border-width: 1px 1px 1px 1px;
            opacity: 0.6;
            text-align: center;
            z-index: 500;
        }

        #tracking:hover {
            opacity: 0.8;
            cursor: pointer;
        }
    </style>
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
                            <li class="breadcrumb-item active" aria-current="page">{{ $kups->nama }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <h6 class="card-header">
                    Detail Data {{ $title }}: {{ $kups->nama }}
                </h6>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-2">
                            <div class="row">
                                <div class='col-lg-2'>
                                    <p>Nama Kups</p>
                                </div>
                                <div class='col-lg-10'>
                                    <p class='fw-bold'>{{ $kups->nama_kups }}</p>
                                </div>
                                <div class='col-lg-2'>
                                    <p>Kps</p>
                                </div>
                                <div class='col-lg-10'>
                                    <p class='fw-bold'>{{ $kups->kps->nama_kps }}</p>
                                </div>

                                <div class='col-lg-2'>
                                    <p>Wilayah</p>
                                </div>
                                <div class='col-lg-10'>
                                    <p class='fw-bold'>{{ $kups->desa->nama_desa }} -
                                        {{ $kups->desa->kecamatan->nama_kecamatan }} -
                                        {{ $kups->desa->kecamatan->kabupaten->nama_kabupaten }} -
                                        {{ $kups->desa->kecamatan->kabupaten->provinsi->nama_provinsi }} -
                                        {{ $kups->desa->kecamatan->kabupaten->provinsi->seksiWilayah->nama_seksi_wilayah }}
                                        -
                                        {{ $kups->desa->kecamatan->kabupaten->provinsi->seksiWilayah->balaiPskl->nama_balai_pskl }}
                                    </p>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <section class="section">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-body">
                            <div id="map" style="width: 100%; height: 600px;">
                                <button id="tracking" class="d-flex justify-content-center">
                                    <i class='fa fa-paper-plane'></i>
                                </button>
                            </div>
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

    <script>
        // OSM layers
        var osmUrl = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png';
        var osmAttrib = 'Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
        var osm = new L.TileLayer(osmUrl, {
            attribution: osmAttrib
        });

        var map = L.map('map', {
            doubleClickZoom: false,
            layers: [osm],
            cursor: true
        }).setView([{{ $kups->koord_y }}, {{ $kups->koord_x }}], 13);;

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

        <?php
        
        if ($kups->geojson) {
            echo "var layerKups = $kups->geojson;";
            echo "L.geoJSON(layerKups).addTo(map).bindPopup('Area KUPS $kups->nama_kups');";
        }
        
        ?>

        <?php 
        if($marker)
        {
            foreach($marker as $item_marker)
            {
        ?>
        var marker = L.marker([{{ $item_marker->koord_y }}, {{ $item_marker->koord_x }}]).addTo(map);
        <?php
            }
        }
        ?>


        L.DomEvent.on(document.getElementById('tracking'), 'click', function() {
            map.locate({
                setView: true,
                maxZoom: 20
            });

            $.ajax({
                url: "{{ route('survey.form_survey.create', $kups->id) }}",
                type: "GET",
                dataType: "html",
                success: function(html) {
                    $("#modal-body").html(html);
                    // $("#geojson").val(shape_for_db);
                    // document.getElementById('koordinat').value = shape_for_db;
                    document.getElementById('id_kups').value = "{{ $kups->id }}";
                    document.getElementById('type').value = "polygon";

                    $('#exampleModal').modal('show');
                }
            });

            $('#exampleModal').modal('show');

            // navigator.geolocation.getCurrentPosition(position => {
            //     const {
            //         coords: {
            //             latitude,
            //             longitude
            //         }
            //     } = position;
            //     // var marker = new L.marker([latitude, longitude], {
            //     //     draggable: true,
            //     //     autoPan: true
            //     // }).addTo(map);
            //     // marker.bounce();

            //     map.setView([latitude, longitude], 13)
            //     // console.log(latitude);

            // })
        })






        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);
        var drawControl = new L.Control.Draw({
            position: 'bottomright',
            draw: {
                polygon: false,
                marker: true,
                polyline: false,
                rectangle: false,
                circle: false
            }
        });
        map.addControl(drawControl);

        map.on('draw:created', function(e) {
            // var type = e.layerType;
            var layer = e.layer;
            var type = e.layerType;

            var shape = layer.toGeoJSON()
            var shape_for_db = JSON.stringify(shape);
            // const myObj = JSON.parse(shape_for_db);
            // var x = myObj["geometry"]["coordinates"];



            if (type === 'marker') {

                $.ajax({
                    url: "{{ route('survey.form_marker.create', $kups->id) }}",
                    type: "GET",
                    dataType: "html",
                    success: function(html) {
                        $("#modal-body").html(html);
                        // $("#geojson").val(shape_for_db);
                        document.getElementById('koordinat').value = shape_for_db;
                        document.getElementById('id_kups').value = "{{ $kups->id }}";
                        document.getElementById('type').value = "marker";

                        $('#exampleModal').modal('show');
                    }
                });

                $('#exampleModal').modal('show');

                // $.ajax({
                //     url: "{{ route('kups.simpan_batas.store') }}",
                //     type: "POST",
                //     data: {
                //         id_kups: "{{ $kups->id }}",
                //         _token: "{{ csrf_token() }}",
                //         koordinat: shape_for_db
                //     },
                //     success: function() {
                //         location.reload();
                //     }
                // });

            } else {
                alertCustom();
            }

            // if (type === 'polyline') {
            //     var coords = layer.getLatLngs();
            //     var seeArea = 0;
            //     for (var i = 0; i < coords.length - 1; i++) {
            //         seeArea += coords[i].distanceTo(coords[i + 1]);
            //     }
            // } else if (type === 'rectangle') {
            //     var seeArea = L.GeometryUtil.geodesicArea(layer.getLatLngs()[0]);
            //     // console.log(seeArea);
            // } else if (type === 'polygon') {
            //     var seeArea = L.GeometryUtil.geodesicArea(layer.getLatLngs()[0]);
            //     // console.log(seeArea);
            // }

            // // // console.log(layer.getLatLngs());  
            // // polygon.addLayer(layer);
            // // var seeArea = L.GeometryUtil.geodesicArea(layer.getLatLngs()[0]);
            // // console.log(seeArea);              
            // // // console.log(type); 

            // var modal = document.getElementById("exampleModal");


            // document.getElementById('koordinat').value = shape_for_db;
            // document.getElementById('modal-body').innerHTML = shape_for_db;


        });
    </script>
@endsection

@section('inline-js')
@endsection
