<?php

namespace Database\Seeders;

use App\Modules\Kabupaten\Models\Kabupaten;
use App\Modules\Kecamatan\Models\Kecamatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $import = DB::table('import_kecamatan')->get();

        foreach ($import as $kecamatan) {
            $kabupaten = Kabupaten::whereKodeKabupaten($kecamatan->regency_id)->first();

            if ($kabupaten) {
                Kecamatan::create([
                    'id_kabupaten'   => $kabupaten->id,
                    'nama_kecamatan'    => $kecamatan->name,
                    'kode_kecamatan'    => $kecamatan->id
                ]);
            }
        }
    }
}
