@extends('layouts.app')

@section('page-css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Manajemen Data {{ $title }}</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('kps.index') }}">{{ $title }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Form Tambah {{ $title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <h6 class="card-header">
                Form Tambah Data {{ $title }}
            </h6>
            <div class="card-body">
                @include('include.flash')
                <form class="form form-horizontal" action="{{ route('kps.store') }}" method="POST">
                    <div class="form-body">
                        @csrf
                        {{-- @foreach ($forms as $key => $value) --}}
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Nama KPS</label>
                            </div>
                            <div class="col-md-9 form-group">
                                {{ Form::text('nama_kps', old('nama_kps'), ['class' => 'form-control', 'placeholder' =>
                                '', 'required' => 'required']) }}
                                @error('nama_kps')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Desa</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <select class="form-control" id="id_desa" name="id_desa"></select>
                                @error('id_desa')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Nomor SK</label>
                            </div>
                            <div class="col-md-9 form-group">
                                {{ Form::text('no_sk', old('no_sk'), ['class' => 'form-control', 'placeholder' => '',
                                'required' => 'required']) }}
                                @error('no_sk')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Tanggal SK</label>
                            </div>
                            <div class="col-md-9 form-group">
                                {{ Form::text('tgl_sk', old('tgl_sk'), ['class' => 'form-control datepicker',
                                'placeholder' => '', 'required' => 'required']) }}
                                @error('tgl_sk')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Luas</label>
                            </div>
                            <div class="col-md-9 form-group">
                                {{ Form::number('luas', old('luas'), ['class' => 'form-control', 'placeholder' => 'Dalam satuan hektar', 'required' => 'required']) }}
                                @error('luas')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-sm-start text-md-end pt-2">
                                <label></label>
                            </div>
                            <div class="col-md-10 form-group">
                                <div id="map" style="width: 100%; height: 400px;"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Koordinat</label>
                            </div>
                            <div class="col-md-9 form-group">
                                {{ Form::text('koordinat', old('koordinat'), ['class' => 'form-control', 'placeholder' => '', 'required' => 'required', 'id' => 'koordinat']) }}
                                @error('koordinat')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        {{-- @endforeach --}}
                        <div class="offset-md-3 ps-2">
                            <button class="btn btn-primary" type="submit">Simpan</button> &nbsp;
                            <a href="{{ route('kps.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </section>
</div>
@endsection

@section('page-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.js"></script>

<script type="text/javascript">
    var path = "{{ route('desa.search.index') }}";
    $('#id_desa').select2({
        placeholder: 'Ketikan nama desa',
        ajax: {
            url: path,
            dataType: 'json',
            delay: 1000,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nama_desa + ' - ' + item.nama_kecamatan + ' - ' + item
                                .nama_kabupaten,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
</script>

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
        }).locate({
            setView: true,
            maxZoom: 7
        });

        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);
        var drawControl = new L.Control.Draw({
            position: 'bottomright'
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

            

            if (type === 'marker') {
                document.getElementById('koordinat').value = x; 
                // var marker = L.marker([51.5, -0.09]).addTo(map);
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

        map.addLayer(osm);
    </script>

    
</script>
@endsection