<div class="row">
    
    <div class='col-lg-2'>
        <p>Koord X</p>
    </div>
    <div class='col-lg-10'>
        <p class='fw-bold'>{{ $koordsurvey->koord_x }}</p>
    </div>
    <div class='col-lg-2'>
        <p>Koord Y</p>
    </div>
    <div class='col-lg-10'>
        <p class='fw-bold'>{{ $koordsurvey->koord_y }}</p>
    </div>
    <div class='col-lg-2'>
        <p>Index</p>
    </div>
    <div class='col-lg-10'>
        <p class='fw-bold'>{{ $koordsurvey->index }}</p>
    </div>
    <div class='col-lg-2'>
        <p>Foto</p>
    </div>
    <div class='col-lg-10'>
        <p class='fw-bold'>{{ $koordsurvey->foto }}</p>
    </div>
    <div class='col-lg-2'>
        <p>Ket Lokasi</p>
    </div>
    <div class='col-lg-10'>
        <p class='fw-bold'>{{ $koordsurvey->ket_lokasi }}</p>
    </div>
    <div class='col-lg-2'>
        <p>Ket Objek</p>
    </div>
    <div class='col-lg-10'>
        <p class='fw-bold'>{{ $koordsurvey->ket_objek }}</p>
    </div>
    <div class="col-lg-12">
        <button class="btn btn-danger" onclick="deleteConfirm('{{ route('koordsurvey.destroy', $koordsurvey->id) }}')">Delete</button>
    </div>

</div>
