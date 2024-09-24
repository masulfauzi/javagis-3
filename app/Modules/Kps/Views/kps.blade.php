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
                Tabel Data {{ $title }}
            </h6>
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <form action="{{ route('kps.index') }}" method="get">
                            <div class="form-group col-md-3 has-icon-left position-relative">
                                <input type="text" class="form-control" value="{{ request()->get('search') }}" name="search" placeholder="Search">
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
									<td>{{ $item->desa->nama_desa }} - {{ $item->desa->kecamatan->nama_kecamatan }} - {{ $item->desa->kecamatan->kabupaten->nama_kabupaten }} - {{ $item->desa->kecamatan->kabupaten->provinsi->nama_provinsi }}</td>
									<td>{{ $item->no_sk }}</td>
									<td>{{ $item->tgl_sk }}</td>
									<td>{{ $item->luas }} Ha</td>
									{{-- <td>{{ $item->koord_x }}</td> --}}
									{{-- <td>{{ $item->koord_y }}</td> --}}
									
                                    <td>
										{!! button('kps.show','', $item->id) !!}
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
@endsection

@section('inline-js')
@endsection