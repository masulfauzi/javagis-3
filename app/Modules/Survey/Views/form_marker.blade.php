<form action="{{ route('survey.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    {{-- {!! Form::hidden('koordinat', null, ["id" => "koordinat"]) !!} --}}
    {!! Form::hidden('id_kps', null, ["id" => "id_kps"]) !!}
    {!! Form::hidden('type', 'marker', ["id" => "type"]) !!}
    <div class="row">
        <div class="col-md-3 form-group">
            <label for="">Nama Survey</label>
        </div>
        <div class="col-md-9 form-group">
            <input type="text" name="nama" class="form-control" id="nama" placeholder="" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 form-group">
            <label for="">Metode Survey</label>
        </div>
        <div class="col-md-9 form-group">
            <select name="metode" id="" class="form-control select2">
                <option value="aktual">Aktual by GPS</option>
                <option value="manual">Manual</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 form-group">
            <label for="">Keterangan</label>
        </div>
        <div class="col-md-9 form-group">
            <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control"></textarea>
        </div>
    </div>
    
    
    <button class="btn btn-primary" type="submit">Simpan</button>
</form>
