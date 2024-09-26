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
                        
                    </div>
                    <div class="col-3">  
						{!! button('koordsurvey.create', $title) !!}  
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
                            @php $no = $data->firstItem(); @endphp
                            @forelse ($data as $item)
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
										{!! button('koordsurvey.show','', $item->id) !!}
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