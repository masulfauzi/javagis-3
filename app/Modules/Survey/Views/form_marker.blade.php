<form action="{{ route('survey.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    {!! Form::hidden('koordinat', null, ["id" => "koordinat"]) !!}
    {!! Form::hidden('id_kups', null, ["id" => "id_kups"]) !!}
    {!! Form::hidden('type', null, ["id" => "type"]) !!}
    <div class="row">
        <div class="col-md-3 form-group">
            <label for="">Nama</label>
        </div>
        <div class="col-md-9 form-group">
            <input type="text" name="nama" class="form-control" id="nama" placeholder="" required>
        </div>
    </div>
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
