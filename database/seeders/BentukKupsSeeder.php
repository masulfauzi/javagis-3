<?php

namespace Database\Seeders;

use App\Modules\BentukKups\Models\BentukKups;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BentukKupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BentukKups::create([
            'bentuk_kups'   => 'Gabungan Kelompok Tani'
        ]);
        BentukKups::create([
            'bentuk_kups'   => 'Kelompok Tani'
        ]);
        BentukKups::create([
            'bentuk_kups'   => 'Kelompok Tani Hutan'
        ]);
        BentukKups::create([
            'bentuk_kups'   => 'Kelompok Usaha'
        ]);
        BentukKups::create([
            'bentuk_kups'   => 'Koperasi'
        ]);
        BentukKups::create([
            'bentuk_kups'   => 'Lembaga Masyarakat Desa Hutan'
        ]);
        BentukKups::create([
            'bentuk_kups'   => 'Lembaga Pengelola Hutan Desa'
        ]);
        BentukKups::create([
            'bentuk_kups'   => 'Masyarakat Humum Adat'
        ]);
    }
}
