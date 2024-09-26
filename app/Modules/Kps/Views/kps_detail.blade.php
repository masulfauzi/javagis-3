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
                    <a href="{{ route('kps.index') }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i
                            class="fa fa-arrow-left"></i> Kembali </a>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('kps.index') }}">{{ $title }}</a></li>
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
                        @include('include.flash')
                        <div class="col-lg-10 offset-lg-2">
                            <div class="row">
                                <div class='col-lg-2'>
                                    <p>Nama Kps</p>
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
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="detail_kps-tab" data-bs-toggle="tab" href="#detail_kps"
                                        role="tab" aria-controls="detail_kps" aria-selected="true">Detail KPS</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="daftar_kups-tab" data-bs-toggle="tab" href="#daftar_kups"
                                        role="tab" aria-controls="daftar_kups" aria-selected="false">Daftar KUPS</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="detail_kps" role="tabpanel"
                                    aria-labelledby="detail_kps-tab">

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
                                                                        <div class="form-control">{{ $kps->no_sk }}</div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label for="email-horizontal">Tanggal SK</label>
                                                                    </div>
                                                                    <div class="col-md-10 form-group">
                                                                        <div class="form-control">
                                                                            {{ \App\Helpers\Format::tanggal($kps->tgl_sk) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label for="contact-info-horizontal">Luas</label>
                                                                    </div>
                                                                    <div class="col-md-10 form-group">
                                                                        <div class="form-control">{{ $kps->luas }} Ha
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label for="password-horizontal">Maps</label>
                                                                    </div>
                                                                    <div class="col-md-10">
                                                                        <div id="map"
                                                                            style="width: 100%; height: 400px;"></div>
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
                                <div class="tab-pane fade" id="daftar_kups" role="tabpanel"
                                    aria-labelledby="daftar_kups-tab">
                                    <div class="row">
                                        <div class="col-9">

                                        </div>
                                        <div class="col-3">
                                            <a href="{{ route('kups.create', ['id_kps' => $kps->id]) }}"
                                                class="btn btn-primary">Tambah Data KUPS</a>
                                        </div>
                                    </div>
                                    <div class="table-responsive-md col-12">
                                        <table class="table" id="table1">
                                            <thead>
                                                <tr>
                                                    <th width="15">No</th>
                                                    <td>Nama Kups</td>
                                                    {{-- <td>Kps</td> --}}
                                                    <td>Bentuk Kups</td>
                                                    <td>Kelas Kups</td>
                                                    <td>No Sk</td>
                                                    <td>Tgl Sk</td>
                                                    <td>Skema Ps</td>
                                                    <td>Wilayah</td>

                                                    <th width="20%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $no = 1; @endphp
                                                @forelse ($kups as $item)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $item->nama_kups }}</td>
                                                        {{-- <td>{{ $item->id_kps }}</td> --}}
                                                        <td>{{ $item->bentukKups->bentuk_kups }}</td>
                                                        <td>{{ $item->kelasKups->nama_kelas_kups }}</td>
                                                        <td>{{ $item->no_sk }}</td>
                                                        <td>{{ \App\Helpers\Format::tanggal($item->tgl_sk) }}</td>
                                                        <td>{{ $item->SkemaPs->nama_skema }}</td>
                                                        <td>{{ $item->desa->nama_desa }} -
                                                            {{ $item->desa->kecamatan->nama_kecamatan }} -
                                                            {{ $item->desa->kecamatan->kabupaten->nama_kabupaten }}</td>

                                                        <td>
                                                            {!! button('kups.show', '', $item->id) !!}
                                                            {!! button('kups.edit', $title, $item->id) !!}
                                                            {!! button('kups.destroy', $title, $item->id) !!}
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="10" class="text-center"><i>No data.</i></td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
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
        }).setView([{{ $kps->koord_y }}, {{ $kps->koord_x }}], 13);;

        map.addLayer(osm);

        <?php

        if($kps->geojson)
        {
            echo "var geojsonFeature = $kps->geojson;";
            echo "L.geoJSON(geojsonFeature).addTo(map).bindPopup('Area KPS $kps->nama_kps');";
        }

        ?>

        var marker = L.marker([{{ $kps->koord_y }}, {{ $kps->koord_x }}]).addTo(map).bindPopup('Lokasi KPS {{ $kps->nama_kps }}');

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
                    url: "{{ route('kps.simpan_batas.store') }}",
                    type: "POST",
                    data: {
                        id_kps: "{{ $kps->id }}",
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
