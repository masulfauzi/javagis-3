<?php

namespace Database\Seeders;

use App\Modules\KelasKups\Models\KelasKups;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KelasKups::create([
            'nama_kelas_kups'   => 'Biru'
        ]);
        KelasKups::create([
            'nama_kelas_kups'   => 'Emas'
        ]);
        KelasKups::create([
            'nama_kelas_kups'   => 'Perak'
        ]);
        KelasKups::create([
            'nama_kelas_kups'   => 'Platinum'
        ]);
    }
}
