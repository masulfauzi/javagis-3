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
                                    {{ Form::text('nama_kps', old('nama_kps'), ['class' => 'form-control', 'placeholder' => '', 'required' => 'required']) }}
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
                                    <select class="form-control" id="id_desa" "
                                                name="id_desa"></select>
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
                                            {{ Form::text('no_sk', old('no_sk'), ['class' => 'form-control', 'placeholder' => '', 'required' => 'required']) }}
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
                                            {{ Form::text('tgl_sk', old('tgl_sk'), ['class' => 'form-control datepicker', 'placeholder' => '', 'required' => 'required']) }}
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
                                            {{ Form::text('luas', old('luas'), ['class' => 'form-control', 'placeholder' => 'Dalam satuan hektar', 'required' => 'required']) }}
                                            @error('luas')
        <div class="text-danger">
                                                            {{ $message }}
                                                        </div>
    @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 text-sm-start text-md-end pt-2">
                                            <label>Koordinat</label>
                                        </div>
                                        <div class="col-md-9 form-group">
                                            <div id="map" style="width: 600px; height: 400px;"></div>
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

            <script type="text/javascript">
                var path = "{{ route('desa.search.index') }}";
                $('#id_desa').select2({
                    placeholder: 'Ketikan nama desa',
                    ajax: {
                        url: path,
                        dataType: 'json',
                        delay: 1000,
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
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
                const map = L.map('map').setView([0, 110], 5);

                const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);
            </script>
@endsection
