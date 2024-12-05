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
                    <a href="{{ route('kps.survey.index', $survey->id_kps) }}"
                        class="btn btn-sm icon icon-left btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali </a>
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
                                <div class='col-lg-2'>
                                    <p>Luas</p>
                                </div>
                                <div class='col-lg-10'>
                                    <p class='fw-bold'>{{ $survey->luas }} M Persegi</p>
                                </div>
                                <div class='col-lg-2'>
                                    <p>Keterangan</p>
                                </div>
                                <div class='col-lg-10'>
                                    <p class='fw-bold'>{{ $survey->keterangan }}</p>
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
                                    {{-- <button id="tambahkoord" class="btn btn-primary">Tambah Koordinat</button> --}}
                                    {{-- <button id="stop"
                                        onclick="selesaiTracking('{{ route('survey.polygon.start.show', $survey->id) }}')"
                                        class="btn btn-primary">Lanjut Survey</button> --}}
                                    {{-- <button id="" onclick="getArea()" class="btn btn-primary">Hitung Luas</button> --}}

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
                    <h5 class="modal-title" id="exampleModalLabel">Informasi Objek</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body">


                </div>

            </div>
        </div>

    </div>

    <!-- Modal 2-->
    <div class="modal fade" id="exampleModal2" aria-labelledby="exampleModalLabel" aria-hidden="true"
        style="overflow:hidden;">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Informasi Objek</h5>
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
        ?>
        var hasil_survey = {
            "type": "FeatureCollection",
            "features": [{
                "type": "Feature",
                "properties": {},
                "geometry": {
                    "type": "LineString",
                    "coordinates": [
                        @foreach($koord_survey as $item)
                            [{{ $item->koord_y }},{{ $item->koord_x }}],
                        @endforeach
                    ]
                }
            }]
        };
        var hasil_geojson = L.geoJSON(hasil_survey);

        L.geoJSON(hasil_survey, {
            customId: "{{ $survey->id }}"
        }).on('click', polyOnClick).addTo(map);
        <?php
        }
        ?>

        function edit(id_survey) {
            var id_survey = id_survey;
            // console.log(id_koord);
            $.ajax({
                url: "{{ url('survey') }}/" + id_survey + "/edit",
                type: "GET",
                dataType: "html",
                success: function(html) {
                    $("#modal-body2").html(html);
                    // $("#geojson").val(shape_for_db);
                    // document.getElementById('koordinat').value = shape_for_db;
                    // document.getElementById('id_kps').value = "{{ $kps->id }}";
                    // document.getElementById('type').value = "marker";

                    $('#exampleModal').modal('hide');
                    $('#exampleModal2').modal('show');
                }
            });

            // $('#exampleModal').modal('show');
        }



        function polyOnClick(e) {
            var customId = this.options.customId;
            // alert("hi. you clicked the marker at " + customId);
            $.ajax({
                url: "{{ url('survey') }}/" + customId,
                type: "GET",
                dataType: "html",
                success: function(html) {
                    $("#modal-body").html(html);
                    // $("#geojson").val(shape_for_db);
                    // document.getElementById('koordinat').value = shape_for_db;
                    // document.getElementById('id_kps').value = "{{ $kps->id }}";
                    // document.getElementById('type').value = "marker";

                    $('#exampleModal').modal('show');
                }
            });

            $('#exampleModal').modal('show');
        }
    </script>
@endsection

@section('inline-js')
@endsection
