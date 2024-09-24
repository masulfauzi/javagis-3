<?php

namespace Database\Seeders;

use App\Modules\BalaiPskl\Models\BalaiPskl;
use App\Modules\SeksiWilayah\Models\SeksiWilayah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeksiWilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $balai_pskl = BalaiPskl::all();
        $daftar_balai = [
            'BPSKL Sumatera',
            'BPSKL Kalimantan',
            'BPSKL Sulawesi',
            'BPSKL Maluku Papua'
        ];

        foreach ($balai_pskl as $item_balai) {
            if (in_array($item_balai->nama_balai_pskl, $daftar_balai)) {
                for ($i = 1; $i <= 3; $i++) {
                    SeksiWilayah::create([
                        'nama_seksi_wilayah' => 'Seksi Wilayah ' . $i,
                        'id_balai_pskl'     => $item_balai->id
                    ]);
                }
            }
            else
            {
                for ($i = 1; $i <= 2; $i++) {
                    SeksiWilayah::create([
                        'nama_seksi_wilayah' => 'Seksi Wilayah ' . $i,
                        'id_balai_pskl'     => $item_balai->id
                    ]);
                }
            }
        }
    }
}
