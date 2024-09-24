@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <a href="{{ route('kps.index') }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali </a>
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
                    <div class="col-lg-10 offset-lg-2">
                        <div class="row">
                            <div class='col-lg-2'><p>Nama Kps</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $kps->nama_kps }}</p></div>
									<div class='col-lg-2'><p>Desa</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $kps->desa->id }}</p></div>
									<div class='col-lg-2'><p>No Sk</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $kps->no_sk }}</p></div>
									<div class='col-lg-2'><p>Tgl Sk</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $kps->tgl_sk }}</p></div>
									<div class='col-lg-2'><p>Luas</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $kps->luas }}</p></div>
									<div class='col-lg-2'><p>Koord X</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $kps->koord_x }}</p></div>
									<div class='col-lg-2'><p>Koord Y</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $kps->koord_y }}</p></div>
									
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