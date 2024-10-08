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
        <p>Foto</p>
    </div>
    <div class='col-lg-10'>
        <p class='fw-bold'>
            @if ($koordsurvey->foto)
                <img width="300px" src="{{ url('uploads/markers/'.$koordsurvey->foto) }}" alt="">
            @else
                Gambar tidak tersedia
            @endif
        </p>
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
    <div class="col-lg-2">
        <button class="btn btn-danger" onclick="deleteConfirm('{{ route('koordsurvey.destroy', $koordsurvey->id) }}')">Delete</button>
    </div>
    <div class="col-lg-8">

    </div>
    <div class="col-lg-2">
        <button id="edit" onclick="edit('{{ $koordsurvey->id }}')" class="btn btn-primary">Edit</button>
    </div>

</div>
