<?php

namespace Database\Seeders;

use App\Modules\Provinsi\Models\Provinsi;
use App\Modules\SeksiWilayah\Models\SeksiWilayah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $import = DB::table('import_provinsi')->get();

        foreach($import as $provinsi)
        {
            $seksi_wilayah = SeksiWilayah::join('balai_pskl','seksi_wilayah.id_balai_pskl', '=', 'balai_pskl.id')
                                            ->select('seksi_wilayah.*')
                                            ->where('balai_pskl.nama_balai_pskl', $provinsi->nama_balai_bpskl)
                                            ->where('seksi_wilayah.nama_seksi_wilayah', $provinsi->seksi_wilayah)
                                            ->first();

            Provinsi::create([
                'id_seksi_wilayah'  => $seksi_wilayah->id,
                'nama_provinsi'     => $provinsi->provinsi,
                'kode_provinsi'     => $provinsi->kode_provinsi
            ]);
        }
    }
}
