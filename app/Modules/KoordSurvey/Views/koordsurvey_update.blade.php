<form class="form form-horizontal" action="{{ route('koordsurvey.update', $koordsurvey->id) }}" method="POST" enctype="multipart/form-data">
    <div class="form-body">
        @csrf @method('patch')
        @foreach ($forms as $key => $value)
            <div class="row">
                <div class="col-md-3 text-sm-start text-md-end pt-2">
                    <label>{{ $value[0] }}</label>
                </div>
                <div class="col-md-9 form-group">
                    {{ $value[1] }}
                    @error($key)
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        @endforeach
        <div class="offset-md-3 ps-2">
            <button class="btn btn-primary" type="submit">Simpan</button> &nbsp;
            {{-- <a href="{{ route('koordsurvey.index') }}" class="btn btn-secondary">Batal</a> --}}
        </div>
  </div>
</form>