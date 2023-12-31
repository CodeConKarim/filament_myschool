<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Role;
use Filament\Facades\Filament;
use Illuminate\Database\Seeder;

final class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve all Filament Panel
        $panels = Filament::getPanels();
        // Create a role for each Panel, cheking if it exists

        foreach ($panels as $panel) {
            //skip the admin panel
            if('admin' === $panel->getId()) {
                continue;
            }
            // check if a role with the same panel ID already exists
            $existingRole = Role::where('panel_id', $panel->getId())->first();
            // if not create it
            if( ! $existingRole) {
                Role::create([
                    'name' => $panel->getId(),
                    'panel_id' => $panel->getId()
                ]);
            }

        }
    }
}
