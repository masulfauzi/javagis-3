<div class="row">
    <div class="col-lg-10 offset-lg-2">
        <div class="row">
            <div class='col-lg-2'>
                <p>Kps</p>
            </div>
            <div class='col-lg-10'>
                <p class='fw-bold'>{{ $survey->kps->nama_kps }}</p>
            </div>
            <div class='col-lg-2'>
                <p>Nama Survey</p>
            </div>
            <div class='col-lg-10'>
                <p class='fw-bold'>{{ $survey->nama_survey }}</p>
            </div>
            <div class='col-lg-2'>
                <p>Type</p>
            </div>
            <div class='col-lg-10'>
                <p class='fw-bold'>{{ $survey->type }}</p>
            </div>
            <div class='col-lg-2'>
                <p>Luas</p>
            </div>
            <div class='col-lg-10'>
                <p class='fw-bold'>{{ $survey->luas }} M Persegi</p>
            </div>
            <div class='col-lg-2'>
                <p>Keterangan</p>
            </div>
            <div class='col-lg-10'>
                <p class='fw-bold'>{{ $survey->keterangan }}</p>
            </div>
            <div class='col-lg-2'>
                <button class="btn btn-danger" onclick="deleteConfirm('{{ route('survey.destroy', $survey->id) }}')">Hapus</button>
            </div>
            <div class='col-lg-7'>
            </div>
            <div class='col-lg-2'>
                <button class="btn btn-primary" onclick="edit('{{ $survey->id }}')">Edit</button>
            </div>
        </div>
    </div>
</div>