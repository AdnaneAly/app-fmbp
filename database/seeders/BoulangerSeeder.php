<?php

namespace Database\Seeders;

use App\Models\Boulanger;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BoulangerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Boulanger::factory(10)->create();
    }
}
