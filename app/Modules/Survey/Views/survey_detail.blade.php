@extends('layouts.app')

@section('page-css')
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
                                    <p>Kups</p>
                                </div>
                                <div class='col-lg-10'>
                                    <p class='fw-bold'>{{ $survey->kups->nama_kups }}</p>
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
            <div class="card">
                <h6 class="card-header">
                    Tabel Data {{ $title }}
                </h6>
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">

                        </div>
                        <div class="col-3">
                            <button id="tambahkoord">Tambah Koordinat</button>
                        </div>
                    </div>
                    @include('include.flash')
                    <div class="table-responsive-md col-12">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th width="15">No</th>
                                    <td>Survey</td>
                                    <td>Koord X</td>
                                    <td>Koord Y</td>
                                    <td>Index</td>
                                    <td>Foto</td>
                                    <td>Ket Lokasi</td>
                                    <td>Ket Objek</td>

                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse ($koord_survey as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->id_survey }}</td>
                                        <td>{{ $item->koord_x }}</td>
                                        <td>{{ $item->koord_y }}</td>
                                        <td>{{ $item->index }}</td>
                                        <td>{{ $item->foto }}</td>
                                        <td>{{ $item->ket_lokasi }}</td>
                                        <td>{{ $item->ket_objek }}</td>

                                        <td>
                                            {!! button('koordsurvey.show', '', $item->id) !!}
                                            {!! button('koordsurvey.edit', $title, $item->id) !!}
                                            {!! button('koordsurvey.destroy', $title, $item->id) !!}
                                        </td>
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
@endsection

@section('page-js')
    <script>
        $(document).ready(function() {

            $("#tambahkoord").on("click", function() {
                navigator.geolocation.getCurrentPosition(position => {
                const {
                    coords: {
                        latitude,
                        longitude
                    }
                } = position;
                
                console.log(latitude, longitude);

            })
            });

        });
    </script>
@endsection

@section('inline-js')
@endsection
