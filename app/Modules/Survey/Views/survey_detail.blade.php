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
                            <button id="tambahkoord" class="btn btn-primary">Tambah Koordinat</button>
                        </div>
                    </div>
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
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body">
                    <form action="{{ route('koordsurvey.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {!! Form::hidden('koord_x', null, ["id" => "koord_x"]) !!}
                        {!! Form::hidden('koord_y', null, ["id" => "koord_y"]) !!}
                        {!! Form::hidden('id_survey', $survey->id, ["id" => "id_survey"]) !!}
                        
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
                                <input type="file" name="foto" class="form-control" id="foto" placeholder="" accept="capture=camera,image/*">
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

                document.getElementById('koord_x').value = latitude;
                document.getElementById('koord_y').value = longitude;
                
                // console.log(latitude, longitude);
                $('#exampleModal').modal('show');

            })
            });

        });
    </script>
@endsection

@section('inline-js')
@endsection
