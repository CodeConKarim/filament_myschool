<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\EnumTitles;
use App\Models\Admin;
use Illuminate\Database\Seeder;

final class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::factory()->create([
            'title' => EnumTitles::MR,
            'first_name' => 'Karim',
            'last_name' => 'Coder',
            'email' => 'codeconkarim@gmail.com',
            'phone' => '+1 6666666666',
            'is_super_admin' => true,
            'is_active' => true
        ]);
        Admin::factory()->count(20)->create();
    }
}
