<?php

namespace Database\Seeders;

use App\Modules\SkemaPs\Models\SkemaPs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SkemaPs::create([
            'nama_skema'    => 'Hutan Adat',
            'kode_skema' => 'HA'
        ]);
        SkemaPs::create([
            'nama_skema'    => 'Hutan Desa',
            'kode_skema' => 'HD'
        ]);
        SkemaPs::create([
            'nama_skema'    => 'Hutan Kemasyarakatan',
            'kode_skema' => 'HKm'
        ]);
        SkemaPs::create([
            'nama_skema'    => 'Hutan Tanaman Rakyat',
            'kode_skema' => 'HTr'
        ]);
        SkemaPs::create([
            'nama_skema'    => 'KEMITRAAN KEHUTANAN IZIN PENGELOLAAN HUTAN PERHUTANAN SOSIAL',
            'kode_skema' => 'KEMITRAAN'
        ]);
        SkemaPs::create([
            'nama_skema'    => 'KEMITRAAN KEHUTANAN KONSERVASI',
            'kode_skema' => 'KEMITRAAN'
        ]);
        SkemaPs::create([
            'nama_skema'    => 'KEMITRAAN KEHUTANAN PENGAKUAN & PERLINDUNGAN KEMITRAAN KEHUTANAN',
            'kode_skema' => 'KEMITRAAN'
        ]);
    }
}
