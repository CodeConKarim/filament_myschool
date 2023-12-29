<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\EnumTitles;
use App\Models\User;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'title' => EnumTitles::MR,
            'first_name' => 'Karim',
            'last_name' => 'Coder',
            'email' => 'codeconkarim@gmail.com',
            'phone' => '+1 6666666666',
            'is_owner' => true,
            'is_active' => true
        ]);
        User::factory()->count(20)->create();
    }
}
