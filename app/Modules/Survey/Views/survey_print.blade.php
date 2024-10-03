<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hasil Survey</title>
    <style>
        p, h4 {
            text-align: center;
        }
        .mt-3 {
            margin-top: 100px;
        }
    </style>
</head>
<body>
    <p>

        <img width="200px" src="data:image/png;base64,{{ base64_encode(file_get_contents('https://upload.wikimedia.org/wikipedia/commons/thumb/0/06/Logo_of_the_Ministry_of_Environmental_Affairs_and_Forestry_of_the_Republic_of_Indonesia.svg/1200px-Logo_of_the_Ministry_of_Environmental_Affairs_and_Forestry_of_the_Republic_of_Indonesia.svg.png')) }}" alt="">
    </p>

    <h4>KEMENTERIAN LINGKUNGAN HIDUP DAN KEHUTANAN</h4>
    <h4>DIREKTORAT JENDRAL PERHUTANAN SOSIAL DAN KEMITRAAN LINGKUNGAN</h4>
    <h4>BALAI PERHUTANAN SOSIAL DAN KEMITRAAN LINGKUNGAN</h4>

    <p>
        {{-- <img src="{{ public_path('export_image/'.$survey->image) }}" alt=""> --}}
        <img width="100%" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('export_image/'.$survey->image))) }}" alt="">
    </p>

    <h3 class="mt-3">Keterangan Peta</h3>

    <h5>Di Proses Oleh: {{ Auth::user()->name }}</h5>

    <h5>Tangal Survei: {{ \App\Helpers\Format::tanggal($survey->created_at, false, false) }}</h5>

</body>
</html>