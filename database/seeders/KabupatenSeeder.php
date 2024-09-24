<?php

namespace Database\Seeders;

use App\Modules\Kabupaten\Models\Kabupaten;
use App\Modules\Provinsi\Models\Provinsi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KabupatenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $import = DB::table('import_kabupaten')->get();

        foreach ($import as $kabupaten) {
            $provinsi = Provinsi::whereKodeProvinsi($kabupaten->province_id)->first();

            if ($provinsi) {
                Kabupaten::create([
                    'id_provinsi'   => $provinsi->id,
                    'nama_kabupaten'    => $kabupaten->name,
                    'kode_kabupaten'    => $kabupaten->id
                ]);
            }
        }
    }
}
