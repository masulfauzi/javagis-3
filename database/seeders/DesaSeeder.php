<?php

namespace Database\Seeders;

use App\Modules\Desa\Models\Desa;
use App\Modules\Kecamatan\Models\Kecamatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $import = DB::table('import_desa')->get();

        foreach ($import as $desa) {
            $kecamatan = Kecamatan::whereKodeKecamatan($desa->district_id)->first();

            if ($kecamatan) {
                Desa::create([
                    'id_kecamatan'   => $kecamatan->id,
                    'nama_desa'    => $desa->name,
                    'kode_desa'    => $desa->id
                ]);
            }
        }
    }
}
