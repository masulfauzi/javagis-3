<form class="form form-horizontal" action="{{ route('survey.update', $survey->id) }}" method="POST">
    <div class="form-body">
        @csrf @method('patch')
        @foreach ($forms as $key => $value)
            <div class="row">
                @if ($value[0] == '')
                    {{ $value[1] }}
                @else
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
                @endif
            </div>
        @endforeach
        <div class="offset-md-3 ps-2">
            <button class="btn btn-primary" type="submit">Simpan</button> &nbsp;
            <a href="{{ route('survey.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </div>
</form>
