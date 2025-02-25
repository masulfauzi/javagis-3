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
                    <a href="{{ route('kps.survey.index', $survey->id_kps) }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i
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
                                <div class='col-lg-2'>
                                    <p>Luas</p>
                                </div>
                                <div class='col-lg-10'>
                                    <p class='fw-bold'>{{ $survey->luas }} M persegi</p>
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
                                    <button id="skip" onclick="skip()" class="btn btn-success">Skip</button>
                                    <button id="stop" onclick="selesaiTracking('{{ route('survey.polyline.show', $survey->id) }}')" class="btn btn-danger">Stop Survey</button>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Informasi Objek</h5>
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
@endsection

@section('page-js')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script src="https://cdn.jsdelivr.net/npm/@turf/turf@7/turf.min.js"></script>
    <script>
        $(document).ready(function() {

            $("#tambahkoord").on("click", function() {
                
                $('#exampleModal').modal('show');
            });

        });
    </script>

    @if (count($koord_survey)>0)
        <script>
            var polygon = turf.polygon([
                [
                    @foreach($koord_survey as $item)
                        [{{ $item->koord_y }},{{ $item->koord_x }}],
                    @endforeach
                    [{{ $koord_survey_pertama->koord_y }},{{ $koord_survey_pertama->koord_x }}],
                ],
            ]);

            var area = turf.area(polygon);

            $.ajax({
                url: "{{ route('survey.simpan_luas.store') }}",
                type: "POST",
                data: {
                    id_survey: "{{ $survey->id }}",
                    _token: "{{ csrf_token() }}",
                    luas: area
                }
            });
        </script>
        
    @endif


    <script>
        // Map initialization 
        var map = L.map('map').setView([{{ $kps->koord_y }}, {{ $kps->koord_x }}], 6);

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
            var hasil_survey = {"type":"Feature",
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
            
            L.geoJSON(hasil_survey).addTo(map).bindPopup('Hasil Survey');
        <?php
        }
        ?>

        if (!navigator.geolocation) {
            console.log("Your browser doesn't support geolocation feature!")
        } else {
            setInterval(() => {
                navigator.geolocation.getCurrentPosition(getPosition)
            }, 5000);
        }

        var marker, circle;

        function getPosition(position) {
            // console.log(position)
            var lat = position.coords.latitude
            var long = position.coords.longitude
            var accuracy = position.coords.accuracy

            document.getElementById('koord_x').value = lat;
            document.getElementById('koord_y').value = long;

            if (marker) {
                map.removeLayer(marker)
            }

            if (circle) {
                map.removeLayer(circle)
            }

            marker = L.marker([lat, long])
            circle = L.circle([lat, long], {
                radius: accuracy
            })

            var featureGroup = L.featureGroup([marker, circle]).addTo(map)

            map.fitBounds(featureGroup.getBounds())

            // console.log("Your coordinate is: Lat: " + lat + " Long: " + long + " Accuracy: " + accuracy)
        }

        function getLocation(position)
        {
            var lat = position.coords.latitude;
            var long = position.coords.longitude;
            // console.log(lat);

            $.ajax({
                url: "{{ route('koordsurvey.store') }}",
                type: "POST",
                data: {
                    id_survey: "{{ $survey->id }}",
                    _token: "{{ csrf_token() }}",
                    koord_x: lat,
                    koord_y: long
                },
                success: function() {
                    location.reload();
                }
            });
        }

        function skip () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(getLocation);
            } else {
                alert('GeoLocation not supported or not allowed');
            }
        }

    </script>
@endsection

@section('inline-js')
@endsection
