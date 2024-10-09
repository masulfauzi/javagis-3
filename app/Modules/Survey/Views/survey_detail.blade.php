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

        </div>
    </div>
</div>