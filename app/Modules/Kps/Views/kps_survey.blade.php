@extends('layouts.app')

@section('page-css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <style>
        #tracking {
            display: flex;
            align-items: center;
            position: absolute;
            top: 429px;
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
        
        #line {
            display: flex;
            align-items: center;
            position: absolute;
            top: 386px;
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

        #line:hover {
            opacity: 0.8;
            cursor: pointer;
        }

        #titik {
            display: flex;
            align-items: center;
            position: absolute;
            top:470px;
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

        #titik:hover {
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
                    <a href="{{ route('kps.show', $kps->id) }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i
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
                                    <p class='fw-bold'>{{ $kps->desa->nama_desa }} -
                                        {{ $kps->desa->kecamatan->nama_kecamatan }} -
                                        {{ $kps->desa->kecamatan->kabupaten->nama_kabupaten }} -
                                        {{ $kps->desa->kecamatan->kabupaten->provinsi->nama_provinsi }} -
                                        {{ $kps->desa->kecamatan->kabupaten->provinsi->seksiWilayah->nama_seksi_wilayah }}
                                        -
                                        {{ $kps->desa->kecamatan->kabupaten->provinsi->seksiWilayah->balaiPskl->nama_balai_pskl }}
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
                                <button id="titik" class="d-flex justify-content-center">
                                    <i class='fa fa-map-marker'></i>
                                </button>
                                <button id="line" class="d-flex justify-content-center">
                                    <i class="fas fa-bezier-curve"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section class="section">
            <div class="card">
                <h6 class="card-header">
                    Tabel Data {{ $title }}
                </h6>
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <form action="{{ route('survey.index') }}" method="get">
                                <div class="form-group col-md-3 has-icon-left position-relative">
                                    <input type="text" class="form-control" value="{{ request()->get('search') }}"
                                        name="search" placeholder="Search">
                                    <div class="form-control-icon"><i class="fa fa-search"></i></div>
                                </div>
                            </form>
                        </div>
                        <div class="col-3">
                            {!! button('survey.create', $title) !!}
                        </div>
                    </div>
                    @include('include.flash')
                    <div class="table-responsive-md col-12">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th width="15">No</th>
                                    <td>Kups</td>
                                    <td>Type</td>

                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse ($survey as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->nama_survey }}</td>
                                        <td>{{ $item->type }}</td>

                                        <td>
                                            @if ($item->type == 'marker')
                                                {!! button('survey.marker.show', '', $item->id) !!}
                                            @endif
                                            @if ($item->type == 'polyline')
                                                {!! button('survey.polyline.show', '', $item->id) !!}
                                            @endif
                                            @if ($item->type == 'polygon')
                                                {!! button('survey.polygon.show', '', $item->id) !!}
                                            @endif
                                            <a href="{{ route('survey.export.show', $item->id) }}"
                                                class="btn btn-outline-primary">Export</a>
                                            {{-- {!! button('survey.edit', $title, $item->id) !!} --}}
                                            {{-- {!! button('survey.destroy', $title, $item->id) !!} --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center"><i>No data.</i></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Survey</h5>
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



        <?php 
        if($marker)
        {
            foreach($marker as $item_marker)
            {
        ?>
        var marker = L.marker([{{ $item_marker->koord_y }}, {{ $item_marker->koord_x }}]).addTo(map).bindPopup(
            '{{ $item_marker->nama_survey }}');
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
                url: "{{ route('survey.form_survey.create', $kps->id) }}",
                type: "GET",
                dataType: "html",
                success: function(html) {
                    $("#modal-body").html(html);
                    // $("#geojson").val(shape_for_db);
                    // document.getElementById('koordinat').value = shape_for_db;
                    document.getElementById('id_kps').value = "{{ $kps->id }}";
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
        });

        L.DomEvent.on(document.getElementById('titik'), 'click', function() {
            map.locate({
                setView: true,
                maxZoom: 20
            });

            $.ajax({
                url: "{{ route('survey.form_marker.create', $kps->id) }}",
                type: "GET",
                dataType: "html",
                success: function(html) {
                    $("#modal-body").html(html);
                    // $("#geojson").val(shape_for_db);
                    // document.getElementById('koordinat').value = shape_for_db;
                    document.getElementById('id_kps').value = "{{ $kps->id }}";
                    document.getElementById('type').value = "marker";

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
        });
        
        L.DomEvent.on(document.getElementById('line'), 'click', function() {
            // map.locate({
            //     setView: true,
            //     maxZoom: 20
            // });

            $.ajax({
                url: "{{ route('survey.form_line.create', $kps->id) }}",
                type: "GET",
                dataType: "html",
                success: function(html) {
                    $("#modal-body").html(html);
                    // $("#geojson").val(shape_for_db);
                    // document.getElementById('koordinat').value = shape_for_db;
                    document.getElementById('id_kps').value = "{{ $kps->id }}";
                    document.getElementById('type').value = "polyline";

                    $('#exampleModal').modal('show');
                }
            });

            $('#exampleModal').modal('show');

            
        });

        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);
        var drawControl = new L.Control.Draw({
            position: 'bottomright',
            draw: {
                polygon: true,
                marker: false,
                polyline: true,
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
            const myObj = JSON.parse(shape_for_db);
            var x = myObj["geometry"]["coordinates"];



            if (type === 'polygon') {

                var seeArea = L.GeometryUtil.geodesicArea(layer.getLatLngs()[0]);
                // console.log(seeArea);   

                $.ajax({
                    url: "{{ route('survey.form_polygon_manual.create') }}",
                    type: "GET",
                    dataType: "html",
                    success: function(html) {
                        $("#modal-body").html(html);
                        // $("#geojson").val(shape_for_db);
                        document.getElementById('geojson').value = shape_for_db;
                        document.getElementById('id_kps').value = "{{ $kps->id }}";
                        document.getElementById('luas').value = seeArea;

                        $('#exampleModal').modal('show');
                    }
                });
            } else if (type === 'polyline') {
                var coords = layer.getLatLngs();
                var seeArea = 0;
                for (var i = 0; i < coords.length - 1; i++) {
                    seeArea += coords[i].distanceTo(coords[i + 1]);
                }

                $.ajax({
                    url: "{{ route('survey.form_polyline_manual.create') }}",
                    type: "GET",
                    dataType: "html",
                    success: function(html) {
                        $("#modal-body").html(html);
                        // $("#geojson").val(shape_for_db);
                        document.getElementById('geojson').value = shape_for_db;
                        document.getElementById('id_kps').value = "{{ $kps->id }}";
                        document.getElementById('luas').value = seeArea;

                        $('#exampleModal').modal('show');
                    }
                });
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

            // $.ajax({
            //     url: "{{ url('/survey/create/') }}/" + type,
            //     type: "GET",
            //     dataType: "html",
            //     success: function(html) {
            //         $("#modal-body").html(html);
            //         // $("#geojson").val(shape_for_db);
            //         document.getElementById('koordinat').value = shape_for_db;
            //         if (type != 'marker') {
            //             document.getElementById('luas').value = seeArea;
            //         }
            //         if (type == 'marker') {
            //             document.getElementById('luas').value = shape.geometry.coordinates[0] + ',' +
            //                 shape.geometry.coordinates[1];
            //             // console.log(shape.geometry.coordinates[0]);
            //         }
            //         $('#exampleModal').modal('show');
            //     }
            // });
            // document.getElementById('koordinat').value = shape_for_db;
            // document.getElementById('modal-body').innerHTML = shape_for_db;


        });
    </script>
@endsection

@section('inline-js')
@endsection
