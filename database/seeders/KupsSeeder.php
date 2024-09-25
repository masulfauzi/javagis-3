<?php

namespace Database\Seeders;

use App\Modules\BentukKups\Models\BentukKups;
use App\Modules\Desa\Models\Desa;
use App\Modules\KelasKups\Models\KelasKups;
use App\Modules\Kps\Models\Kps;
use App\Modules\Kups\Models\Kups;
use App\Modules\SkemaPs\Models\SkemaPs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // update id desa di tabel import_kups
        $data_desa = DB::table('import_kups')->get();

        foreach($data_desa as $item_desa)
        {
            $desa = Desa::join('kecamatan', 'desa.id_kecamatan', '=', 'kecamatan.id')
                        ->select('desa.*')
                        ->where('kecamatan.nama_kecamatan', 'like', '%' . $item_desa->KECAMATAN . '%')
                        ->first();
            if(!$desa)
            {
                dd($item_desa->KECAMATAN);
            }

            // dd($desa);

            DB::table('import_kups')
                ->where('id_kups', $item_desa->id_kups)
                ->update([
                    'DESA' => $desa->id
                ]);
        }



        // import KPS
        $import_kps = DB::table('import_kups')
            ->groupBy('KPS')
            ->get();

        foreach ($import_kps as $kps) {
            Kps::create([
                'nama_kps'  => $kps->KPS,
                'id_desa'   => $kps->DESA,
                'no_sk'     => $kps->no_sk,
                'tgl_sk'    => $kps->tgl_sk,
                'koord_x' => $kps->koord_y,
                'koord_y' => $kps->koord_x
            ]);
        }

        $import_kups = DB::table('import_kups')->get();

        foreach ($import_kups as $kups) {
            $kps = Kps::whereNamaKps($kups->KPS)->first();
            $bentuk_kups = BentukKups::whereBentukKups($kups->bentuk)->first();
            $kelas_kups = KelasKups::whereNamaKelasKups($kups->kelas)->first();
            $skema_ps = SkemaPs::whereNamaSkema($kups->skema)->first();

            if(!$kps)
            {
                dd($kups);
            }


            if (!$bentuk_kups) {
                $bentuk_kups = BentukKups::first();
            }

            if (!$kelas_kups) {
                $kelas_kups = KelasKups::first();
            }

            if (!$skema_ps) {
                $skema_ps = SkemaPs::first();
            }

            Kups::create([
                'nama_kups' => $kups->kups,
                'id_kps' => $kps->id,
                'id_bentuk_kups' => $bentuk_kups->id,
                'id_kelas_kups' => $kelas_kups->id,
                'no_sk' => $kups->no_sk,
                'tgl_sk' => $kups->tgl_sk,
                'koord_x' => $kups->koord_y,
                'koord_y' => $kups->koord_x,
                'id_desa' => $kups->DESA,
                'id_skema_ps' => $skema_ps->id,
                'tahun_dibentuk'    => $kups->dibentuk
            ]);
        }
    }
}
