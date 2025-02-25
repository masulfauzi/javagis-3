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
                    <a href="{{ route('survey.index') }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i
                            class="fa fa-arrow-left"></i> Kembali </a>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('survey.index') }}">{{ $title }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $survey->nama }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>


        <section class="section">
            <div class="card">
                <h6 class="card-header">
                    Detail Data {{ $title }}: {{ $survey->nama_survey }}
                </h6>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-2">
                            <div class="row">
                                <div class='col-lg-2'>
                                    <p>Kps</p>
                                </div>
                                <div class='col-lg-10'>
                                    <p class='fw-bold'>{{ $survey->kps->nama_kps }}</p>
                                </div>
                                <div class='col-lg-2'>
                                    <p>Type</p>
                                </div>
                                <div class='col-lg-10'>
                                    <p class='fw-bold'>{{ $survey->type }}</p>
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
                            <div class="row">
                                <div class="col-10">
                                    <button id="tambahkoord" class="btn btn-primary">Tambah Koordinat</button>
                                    <button id="stop" onclick="selesaiTracking('{{ route('survey.marker.show', $survey->id) }}')" class="btn btn-danger">Stop Survey</button>
        
                                </div>
                                <div class="col-3">
                                </div>
                            </div>
                            <div id="map" class="mt-3" style="width: 100%; height: 600px;">

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
                    
                    @include('include.flash')
                    <div class="table-responsive-md col-12">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th width="15">No</th>
                                    {{-- <td>Survey</td> --}}
                                    <td>Koord X</td>
                                    <td>Koord Y</td>
                                    {{-- <td>Index</td> --}}
                                    <td>Foto</td>
                                    <td>Ket Lokasi</td>
                                    <td>Ket Objek</td>

                                    {{-- <th width="20%">Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse ($koord_survey as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        {{-- <td>{{ $item->id_survey }}</td> --}}
                                        <td>{{ $item->koord_x }}</td>
                                        <td>{{ $item->koord_y }}</td>
                                        {{-- <td>{{ $item->index }}</td> --}}
                                        <td>{{ $item->foto }}</td>
                                        <td>{{ $item->ket_lokasi }}</td>
                                        <td>{{ $item->ket_objek }}</td>

                                        {{-- <td>
                                            {!! button('koordsurvey.show', '', $item->id) !!}
                                            {!! button('koordsurvey.edit', $title, $item->id) !!}
                                            {!! button('koordsurvey.destroy', $title, $item->id) !!}
                                        </td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center"><i>No data.</i></td>
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
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Keterangan Objek</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body">
                    <form action="{{ route('koordsurvey.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {!! Form::hidden('koord_x', null, ['id' => 'koord_x']) !!}
                        {!! Form::hidden('koord_y', null, ['id' => 'koord_y']) !!}
                        {!! Form::hidden('id_survey', $survey->id, ['id' => 'id_survey']) !!}

                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="">Keterangan Lokasi</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <textarea name="ket_lokasi" id="ket_lokasi" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="">Keterangan Objek</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <textarea name="ket_objek" id="ket_objek" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="">Foto</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="file" name="foto" class="form-control" id="foto" placeholder=""
                                    accept="capture=camera,image/*">
                            </div>
                        </div>


                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </form>

                </div>

            </div>
        </div>

    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="exampleModal2" aria-labelledby="exampleModalLabel" aria-hidden="true"
        style="overflow:hidden;">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Keterangan Objek</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body2">
                    

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
        $(document).ready(function() {

            $("#tambahkoord").on("click", function() {
                
                $('#exampleModal').modal('show');
            });

        });
    </script>

    <script>
        // Map initialization 
        var map = L.map('map').setView([{{ $kps->koord_y }}, {{ $kps->koord_x }}], 13);

        //osm layer
        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });
        osm.addTo(map);

        <?php
        
        if ($kps->geojson) {
            echo "var layerKps = $kps->geojson;";
        
            echo 'var myStyle = {"color": "#ff7800","weight": 5,"opacity": 0.65};';
        
            echo "L.geoJSON(layerKps, {style: myStyle}).addTo(map).bindPopup('Area KPS $kps->nama_kps');";
        }
        
        ?>


        <?php 
        if($koord_survey)
        {
            // dd($koord_survey);
            foreach($koord_survey as $item_koord)
            {
        ?>
            var hasil_survey = L.marker([{{ $item_koord->koord_x }}, {{ $item_koord->koord_y }}], {customId:"{{ $item_koord->id }}"}).addTo(map);
        <?php
            }
        ?>
            
        <?php
        }
        ?>

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
            const myObj = JSON.parse(shape_for_db);
            var x = myObj["geometry"]["coordinates"];
            



            if (type === 'marker') {

                $.ajax({
                    url: "{{ route('koordsurvey.create') }}",
                    type: "GET",
                    dataType: "html",
                    success: function(html) {
                        $("#modal-body2").html(html);
                        // $("#geojson").val(shape_for_db);
                        document.getElementById('koord_x2').value = x[1];
                        document.getElementById('koord_y2').value = x[0];
                        document.getElementById('id_survey2').value = "{{ $survey->id }}";
                        // document.getElementById('type').value = "marker";

                        $('#exampleModal2').modal('show');
                    }
                });

                // $('#exampleModal').modal('show');

                // $.ajax({
                //     url: "{{ route('kups.simpan_batas.store') }}",
                //     type: "POST",
                //     data: {
                //         id_kups: "{{ $kps->id }}",
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
            //     map.setView([latitude, longitude], 13)
            //     // console.log(latitude);

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
            // })
        });

    
    </script>
@endsection

@section('inline-js')
@endsection
