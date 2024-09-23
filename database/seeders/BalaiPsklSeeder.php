<?php

namespace Database\Seeders;

use App\Modules\BalaiPskl\Models\BalaiPskl;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BalaiPsklSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BalaiPskl::create([
            'nama_balai_pskl' => 'BPSKL Sumatera'
        ]);
        BalaiPskl::create([
            'nama_balai_pskl' => 'BPSKL Jawa'
        ]);
        BalaiPskl::create([
            'nama_balai_pskl' => 'BPSKL Kalimantan'
        ]);
        BalaiPskl::create([
            'nama_balai_pskl' => 'BPSKL Sulawesi'
        ]);
        BalaiPskl::create([
            'nama_balai_pskl' => 'BPSKL Maluku Papua'
        ]);
        BalaiPskl::create([
            'nama_balai_pskl' => 'BPSKL Bali & Nusa Tenggara'
        ]);
    }
}
