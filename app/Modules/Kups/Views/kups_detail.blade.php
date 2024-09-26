@extends('layouts.app')

@section('page-css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #refreshButton {
            display: flex;
            align-items: center;
            position: absolute;
            top: 435px;
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

        #refreshButton:hover {
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
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="detail_kups-tab" data-bs-toggle="tab" href="#detail_kups"
                                        role="tab" aria-controls="detail_kups" aria-selected="true">Detail KUPS</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="detail_kups" role="tabpanel"
                                    aria-labelledby="detail_kups-tab">

                                    <div class="row match-height">
                                        <div class="col-md-12 col-12">
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <form class="form form-horizontal">
                                                            <div class="form-body">
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <label for="first-name-horizontal">No SK</label>
                                                                    </div>
                                                                    <div class="col-md-10 form-group">
                                                                        <div class="form-control">{{ $kups->no_sk }}</div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label for="email-horizontal">Tanggal SK</label>
                                                                    </div>
                                                                    <div class="col-md-10 form-group">
                                                                        <div class="form-control">
                                                                            {{ \App\Helpers\Format::tanggal($kups->tgl_sk) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label for="contact-info-horizontal">Bentuk</label>
                                                                    </div>
                                                                    <div class="col-md-10 form-group">
                                                                        <div class="form-control">
                                                                            {{ $kups->bentukKups->bentuk_kups }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label for="contact-info-horizontal">Kelas</label>
                                                                    </div>
                                                                    <div class="col-md-10 form-group">
                                                                        <div class="form-control">
                                                                            {{ $kups->kelasKups->nama_kelas_kups }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label for="contact-info-horizontal">Skema
                                                                            PS</label>
                                                                    </div>
                                                                    <div class="col-md-10 form-group">
                                                                        <div class="form-control">
                                                                            {{ $kups->skemaPs->nama_skema }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label for="contact-info-horizontal">Dibentuk
                                                                            Tahun</label>
                                                                    </div>
                                                                    <div class="col-md-10 form-group">
                                                                        <div class="form-control">
                                                                            {{ $kups->tahun_dibentuk }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label for="contact-info-horizontal">Luas</label>
                                                                    </div>
                                                                    <div class="col-md-10 form-group">
                                                                        <div class="form-control">{{ $kups->luas }} Ha
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">

                                                                        <div id="map"
                                                                            style="width: 100%; height: 400px;">

                                                                        </div>
                                                                    </div>


                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
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



        var marker = L.marker([{{ $kups->koord_y }}, {{ $kups->koord_x }}]).addTo(map).bindPopup('Lokasi KUPS {{ $kups->nama_kups }}');

        

        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);
        var drawControl = new L.Control.Draw({
            position: 'bottomright',
            draw: {
                polygon: true,
                marker: false,
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



            if (type === 'polygon') {
                // document.getElementById('koordinat').value = x;
                // var marker = L.marker([51.5, -0.09]).addTo(map);

                // console.log(shape_for_db);

                $.ajax({
                    url: "{{ route('kups.simpan_batas.store') }}",
                    type: "POST",
                    data: {
                        id_kups: "{{ $kups->id }}",
                        _token: "{{ csrf_token() }}",
                        koordinat: shape_for_db
                    },
                    success: function() {
                        location.reload();
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


            // document.getElementById('koordinat').value = shape_for_db;
            // document.getElementById('modal-body').innerHTML = shape_for_db;


        });
    </script>
@endsection

@section('inline-js')
@endsection
