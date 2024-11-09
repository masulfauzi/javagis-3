@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
    <div class="page-heading">
        <div class="page-title">
            <div class="row mb-2">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Manajemen Data {{ $title }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <h6 class="card-header">
                    Filter Data
                </h6>
                <div class="card-body">
                    @include('include.flash')
                    <form class="form form-horizontal" action="" method="GET">
                        <div class="form-body">
                            {{-- @csrf --}}
                            {{-- @foreach ($forms as $key => $value) --}}
                            {{-- <div class="row">
                                <div class="col-md-3 text-sm-start text-md-end pt-2">
                                    <label>Pilih Balai</label>
                                </div>
                                <div class="col-md-9 form-group">
                                    {!! Form::select('id_balai', $balai, $selected['id_balai'], [
                                        'class' => 'form-control select2',
                                        'id' => 'id_balai',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 text-sm-start text-md-end pt-2">
                                    <label>Seksi Wilayah</label>
                                </div>
                                <div class="col-md-9 form-group">
                                    <select class="form-control" id="id_seksi_wilayah" name="id_seksi_wilayah"
                                        @if (!isset($seksi_wilayah)) disabled="disabled" @endif>
                                        @if (isset($seksi_wilayah))
                                            <option value="">-SEMUA SEKSI WILAYAH-</option>
                                            @foreach ($seksi_wilayah as $key => $value)
                                                <option @if ($key == $selected['id_seksi_wilayah']) selected @endif
                                                    value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div> --}}
                            <div class="row">
                                <div class="col-md-3 text-sm-start text-md-end pt-2">
                                    <label>Provinsi</label>
                                </div>
                                <div class="col-md-9 form-group">
                                    {!! Form::select('id_provinsi', $provinsi, $selected['id_provinsi'], [
                                        'class' => 'form-control select2',
                                        'id' => 'id_provinsi',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 text-sm-start text-md-end pt-2">
                                    <label>Kabupaten</label>
                                </div>
                                <div class="col-md-9 form-group">
                                    <select class="form-control" id="id_kabupaten" name="id_kabupaten"
                                    @if (!isset($kabupaten)) disabled="disabled" @endif>
                                    @if (isset($kabupaten))
                                    <option value="">-SEMUA KABUPATEN-</option>
                                    @foreach ($kabupaten as $key => $value)
                                        <option @if ($key == $selected['id_kabupaten']) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                @endif
                                </select>
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

        <section class="section">
            <div class="card">
                <h6 class="card-header">
                    Tabel Data {{ $title }}
                </h6>
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <form action="{{ route('kps.index') }}" method="get">
                                <div class="form-group col-md-3 has-icon-left position-relative">
                                    <input type="text" class="form-control" value="{{ request()->get('search') }}"
                                        name="search" placeholder="Search">
                                    <div class="form-control-icon"><i class="fa fa-search"></i></div>
                                </div>
                            </form>
                        </div>
                        <div class="col-3">
                            {!! button('kps.create', $title) !!}
                        </div>
                    </div>
                    @include('include.flash')
                    <div class="table-responsive-md col-12">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th width="15">No</th>
                                    <td>Nama Kps</td>
                                    <td>Wilayah</td>
                                    <td>No Sk</td>
                                    <td>Tgl Sk</td>
                                    <td>Luas</td>
                                    {{-- <td>Koord X</td>
								<td>Koord Y</td> --}}

                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = $data->firstItem(); @endphp
                                @forelse ($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->nama_kps }}</td>
                                        <td>{{ $item->desa->nama_desa }} - {{ $item->desa->kecamatan->nama_kecamatan }} -
                                            {{ $item->desa->kecamatan->kabupaten->nama_kabupaten }} -
                                            {{ $item->desa->kecamatan->kabupaten->provinsi->nama_provinsi }}</td>
                                        <td>{{ $item->no_sk }}</td>
                                        <td>{{ $item->tgl_sk }}</td>
                                        <td>{{ $item->luas }} Ha</td>
                                        {{-- <td>{{ $item->koord_x }}</td> --}}
                                        {{-- <td>{{ $item->koord_y }}</td> --}}

                                        <td>
                                            {!! button('kps.show', '', $item->id) !!}
                                            {!! button('kps.edit', $title, $item->id) !!}
                                            {!! button('kps.destroy', $title, $item->id) !!}
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
                    {{ $data->links() }}
                </div>
            </div>

        </section>
    </div>
@endsection

@section('page-js')
    <script>
        $(document).ready(function() {

            $("#id_balai").on("change", function() {
                var id_balai = this.value;
                var id_seksi_wilayah = document.getElementById("id_seksi_wilayah");

                $.ajax({
                    url: "{{ route('seksiwilayah.get_seksi_wilayah.index') }}",
                    type: "GET",
                    data: {
                        'id_balai': id_balai
                    },
                    success: function(response) {
                        id_seksi_wilayah.removeAttribute("disabled");
                        // console.log(response);
                        // $("#breeds").attr('disabled', false);
                        $('#id_seksi_wilayah').empty();
                        $("#id_seksi_wilayah").prepend(
                            '<option value="">-SEMUA SEKSI WILAYAH-</option>');
                        $.each(response, function(key, value) {
                            // console.log(value.nama_seksi_wilayah);
                            $("#id_seksi_wilayah").append('<option value=' + value.id +
                                '>' + value.nama_seksi_wilayah + '</option>');
                        });
                    }
                });
            });

        });
    </script>

    <script>
        $(document).ready(function() {

            $("#id_seksi_wilayah").on("change", function() {
                var id_seksi_wilayah = this.value;
                var id_provinsi = document.getElementById("id_provinsi");

                $.ajax({
                    url: "{{ route('provinsi.get_provinsi.index') }}",
                    type: "GET",
                    data: {
                        'id_seksi_wilayah': id_seksi_wilayah
                    },
                    success: function(response) {
                        id_provinsi.removeAttribute("disabled");
                        // console.log(response);
                        // $("#breeds").attr('disabled', false);
                        $('#id_provinsi').empty();
                        $("#id_provinsi").prepend('<option value="">-SEMUA PROVINSI-</option>');
                        $.each(response, function(key, value) {
                            // console.log(value.nama_seksi_wilayah);
                            $("#id_provinsi").append('<option value=' + value.id + '>' +
                                value.nama_provinsi + '</option>');
                        });
                    }
                });
            });

        });
    </script>

    <script>
        $(document).ready(function() {

            $("#id_provinsi").on("change", function() {
                var id_provinsi = this.value;
                var id_kabupaten = document.getElementById("id_kabupaten");

                $.ajax({
                    url: "{{ route('kabupaten.get_kabupaten_tematik.index') }}",
                    type: "GET",
                    data: {
                        'id_provinsi': id_provinsi
                    },
                    success: function(response) {
                        id_kabupaten.removeAttribute("disabled");
                        // console.log(response);
                        // $("#breeds").attr('disabled', false);
                        $('#id_kabupaten').empty();
                        $("#id_kabupaten").prepend(
                            '<option value="">-SEMUA KABUPATEN-</option>');
                        $.each(response, function(key, value) {
                            // console.log(value.nama_seksi_wilayah);
                            $("#id_kabupaten").append('<option value=' + value.id +
                                '>' + value.nama_kabupaten + '</option>');
                        });
                    }
                });
            });

        });
    </script>
@endsection

@section('inline-js')
@endsection
