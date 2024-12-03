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
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="survey-tab" href="{{ route('kps.survey.index', $kps->id) }}"
                                        role="tab" aria-controls="survey" aria-selected="true">Survey</a>
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
                                                                    <div class="col-md-12">
                                                                        <div id="map"
                                                                            style="width: 100%; height: 600px;"></div>
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
@endsection

@section('page-js')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        var littleton = L.marker([39.61, -105.02]).bindPopup('This is Littleton, CO.'),
            denver = L.marker([39.74, -104.99]).bindPopup('This is Denver, CO.'),
            aurora = L.marker([39.73, -104.8]).bindPopup('This is Aurora, CO.'),
            golden = L.marker([39.77, -105.23]).bindPopup('This is Golden, CO.');

        var cities = L.layerGroup([littleton, denver, aurora, golden]);

        var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        });

        var osmHOT = L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors, Tiles style by Humanitarian OpenStreetMap Team hosted by OpenStreetMap France'
        });

        var map = L.map('map', {
            center: [{{ $kps->koord_y }}, {{ $kps->koord_x }}],
            zoom: 12,
            layers: [osm, cities]
        });



        <?php
        if ($kps->geojson) {
            echo "var map_kps = $kps->geojson;";
            echo "L.geoJSON(map_kps).addTo(map).bindPopup('Area KPS $kps->nama_kps');";
        }
        ?>



        var baseMaps = {
            "OpenStreetMap": osm,
            "OpenStreetMap.HOT": osmHOT
        };

        var overlayMaps = {
            "Cities": littleton
        };

        var layerControl = L.control.layers(baseMaps, overlayMaps).addTo(map);

        <?php
            $no = 1;

            if(count($survey) > 0)
            {
                foreach($survey as $item_survey)
                {
                    $koord_survey = \App\Modules\KoordSurvey\Models\KoordSurvey::whereIdSurvey($item_survey->id)->orderBy('index')->get();

        ?>
        var koord_{{ $no }} = {
            "type": "Feature",
            "properties": {},
            "geometry": {
                "type": "Polygon",
                "coordinates": [
                    [
                        @foreach ($koord_survey as $item)
                            [{{ $item->koord_y }}, {{ $item->koord_x }}],
                        @endforeach
                    ]
                ]
            }
        };

        var hasil_survey_{{ $no }} = L.geoJSON(koord_{{ $no }}).on('click', polyOnClick);

        layerControl.addOverlay(hasil_survey_{{ $no }}, "{{ $item_survey->nama_survey }}");

        <?php
                    $no ++;
                }
            }

        ?>

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
