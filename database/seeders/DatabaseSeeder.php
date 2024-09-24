<?php

namespace Database\Seeders;

use App\Modules\Menu\Models\Menu;
use App\Modules\SeksiWilayah\Models\SeksiWilayah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(UserRoleTableSeeder::class);
        $this->call(MenuTableSeeder::class);
        $this->call(PrivilegeTableSeeder::class);
        $this->call(BalaiPsklSeeder::class);
        $this->call(SeksiWilayahSeeder::class);
        $this->call(ProvinsiSeeder::class);
        $this->call(KabupatenSeeder::class);
        $this->call(KecamatanSeeder::class);
        $this->call(DesaSeeder::class);



        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
