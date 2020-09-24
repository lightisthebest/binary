<?php

namespace Database\Seeders;

use App\Models\Binar;
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
        Binar::create([
            'id' => 1,
            'path' => '1',
            'pos_path' => '1',
            'level' => 1,
        ]);
    }
}
