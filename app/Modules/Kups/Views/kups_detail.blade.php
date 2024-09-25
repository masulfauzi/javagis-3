@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <a href="{{ route('kups.index') }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali </a>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('kups.index') }}">{{ $title }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $kups->nama }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <h6 class="card-header">
                Detail Data {{ $title }}: {{ $kups->nama }}
            </h6>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10 offset-lg-2">
                        <div class="row">
                            <div class='col-lg-2'><p>Nama Kups</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $kups->nama_kups }}</p></div>
									<div class='col-lg-2'><p>Kps</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $kups->kps->id }}</p></div>
									<div class='col-lg-2'><p>Bentuk Kups</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $kups->bentukKups->id }}</p></div>
									<div class='col-lg-2'><p>Kelas Kups</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $kups->kelasKups->id }}</p></div>
									<div class='col-lg-2'><p>No Sk</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $kups->no_sk }}</p></div>
									<div class='col-lg-2'><p>Tgl Sk</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $kups->tgl_sk }}</p></div>
									<div class='col-lg-2'><p>Skema Ps</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $kups->skemaPs->id }}</p></div>
									<div class='col-lg-2'><p>Desa</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $kups->desa->id }}</p></div>
									<div class='col-lg-2'><p>Koord X</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $kups->koord_x }}</p></div>
									<div class='col-lg-2'><p>Koord Y</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $kups->koord_y }}</p></div>
									<div class='col-lg-2'><p>Luas</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $kups->luas }}</p></div>
									<div class='col-lg-2'><p>Tahun Dibentuk</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $kups->tahun_dibentuk }}</p></div>
									
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
@endsection

@section('page-js')
@endsection

@section('inline-js')
@endsection