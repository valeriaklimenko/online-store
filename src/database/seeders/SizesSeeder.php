<?php

namespace Database\Seeders;

use App\Enums\Sizes\ClothesSizes;
use App\Models\Sizes;
use Illuminate\Database\Seeder;

class SizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (ClothesSizes::cases() as $size) {
            Sizes::updateOrCreate(
                ['code' => strtolower($size->value)],
                ['name' => $size->value]
            );
        }
    }
}
