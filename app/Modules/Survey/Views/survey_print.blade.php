<?php

    $panjang_judul = Str::length($survey->nama_survey);

    $baris = ceil($panjang_judul / 10);

    $y_foto = 31 + (10 * ($baris - 1));


    $pdf->AddPage('L', 'A3');
    $pdf->SetFont('Courier', 'B', 18);
    
    
    
    
    $pdf->cell(300, 200, '', 1);
    $pdf->image(public_path('export_image/'.$survey->image), 11, 11, 298);

    $pdf->cell(5,20,'',);
    $pdf->multiCell(100,20,'PETA '.Str::upper($survey->nama_survey), 1, 'C');


    $pdf->cell(305,30);
    $pdf->cell(100,30,'',1,1);
    $pdf->image(public_path('assets/images/arah_angin.jpg'), 350, $y_foto, 30, 30);
    
    
    $pdf->cell(305,20);
    $pdf->cell(100,20,'LEGENDA','LRT',1);
    $pdf->cell(305,20);
    $pdf->cell(100,20,'','LRB',1);
    
    $pdf->cell(305,20);
    $pdf->cell(100,20,'PEMBUAT PETA: '.$nama,1,1);
    
    $pdf->cell(305,20);
    $pdf->cell(100,20,'TANGGAL PEMBUATAN: '.$tgl_pembuatan,1,1);
    
    $pdf->cell(305,20);
    $pdf->cell(100,20,'SUMBER: SURVEY LAPANGAN',1,1);
    
    $pdf->cell(305,20);
    $pdf->cell(100,20,'DIDUKUNG OLEH:',1,1);
    













    $pdf->Output();
    exit;

?>