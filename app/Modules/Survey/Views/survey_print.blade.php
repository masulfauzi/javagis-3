<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Export Survey</title>
    
    
    <style>
        .box {
            float: left;
            height: 20px;
            width: 40px;
            margin-bottom: 15px;
            border: 1px solid black;
            clear: both;
        }

        .bordered {
            border-style: solid;
        }

        .red {
            background-color: #3388FF;
        }

        .content {
            width: 1000px;
            height: 1000px;
            /* background-color: red; */
            display: flex;
        }

        .kiri {
            width: 1000px;
            height: 100px;
            /* background-color: red; */
        }

        .kanan {
            width: 400px;
            height: 100px;
            /* background-color: red; */
        }
        .text-center {
            text-align: center;
        }
        .row {
            padding: 10px;
        }
        p, h3 {
            margin-top: 0;
            margin-bottom: 0;
        }
        .flex {
            display: blox;
            vertical-align: center;
        }
        img {
            margin: auto;
            }

    </style>
</head>

<body>

    <div class="content">
        <div class="kiri">
            
            <img width="950" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('export_image/'.$survey->image))) }}" alt="">
        </div>
        <div class="kanan">
            <div class="row text-center bordered">
                <h3>PETA {{ $survey->nama_survey }}</h3>
            </div>
            <div class="row bordered text-center">
                <img width="30%" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/images/arah_angin.jpg'))) }}" alt="">
                
            </div>
            <div class="row bordered">
                <p>LEGENDA:</p>
                <br>
                <div>
                    <div class='box red'></div>  &nbsp;&nbsp;= Hasil Survey
                </div>
            </div>
            <div class="row bordered">
                <P>PEMBUAT PETA: {{ Auth::user()->name }}</P>
            </div>
            <div class="row bordered">
                <P>TANGGAL PEMBUATAN: {{ \App\Helpers\Format::tanggal($survey->created_at, false, false) }}</P>
            </div>
            <div class="row bordered">
                <P>Sumber: Survey Lapangan {{ date('Y') }}</P>
            </div>
            <div class="row bordered">
                <div class="row mb-4">
                    <P>DIDUKUNG OLEH:</P>

                </div>
                <div class="row flex">
                    <img width="20%" height="20%" class="pr-3" src="{{ asset('assets/images/logo/logo_klhk.png') }}" alt="Logo">
                    &nbsp;&nbsp;
                    <img width="20%" height="20%" src="{{ asset('assets/images/logo/logo_kfw.png') }}" alt="Logo">
                    &nbsp;&nbsp;
                    <img width="20%" height="20%" src="{{ asset('assets/images/logo/logo_kerjasama_jerman.png') }}" alt="Logo">
                    &nbsp;&nbsp;
                    <img width="25%" height="25%"src="{{ asset('assets/images/logo/logo_forest_program.png') }}" alt="Logo">
                    
                </div>
            </div>
        </div>
    </div>



    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
