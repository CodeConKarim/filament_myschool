<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\RoleResource\Pages;

use App\Filament\Admin\Resources\RoleResource;
use App\Models\Role;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ManageRecords;

final class ManageRoles extends ManageRecords
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('generateRole')
                ->label('generate')
                ->requiresConfirmation()
                ->action(function (): void {
                    $this->generateRole();
                })
        ];
    }

    protected function generateRole(): void
    {
        $panels = Filament::getPanels();
        // Create a role for each Panel, checking if it exists

        foreach ($panels as $panel) {
            //skip the admin panel
            if('admin' === $panel->getId()) {
                continue;
            }
            // check if a role with the same panel ID already exists
            $existingRole = Role::where('panel_id', $panel->getId())->first();
            // if not, create it
            if( ! $existingRole) {
                Role::create([
                    'name' => $panel->getId(),
                    'panel_id' => $panel->getId()
                ]);
            }

        }
    }
}
