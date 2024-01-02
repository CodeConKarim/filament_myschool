<?php

namespace App\Filament\Admin\Resources\AdminResource\Pages;

use App\Filament\Admin\Resources\AdminResource;
use App\Models\Admin;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\IconPosition;
use Illuminate\Database\Eloquent\Builder;

class ListAdmins extends ListRecords
{
    protected static string $resource = AdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        return [
            'all' => \Filament\Resources\Components\Tab::make('All users')
                ->icon('heroicon-m-user-group')
                ->iconPosition(IconPosition::After)
                ->badge(Admin::all()->count())
                ->badgeColor('success'),
            'super' => \Filament\Resources\Components\Tab::make('Super admins')
                ->icon('heroicon-m-user-group')
                ->iconPosition(IconPosition::After)
                ->badge(Admin::query()->where('is_super_admin', true)->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_super_admin', true)),
            'active' => \Filament\Resources\Components\Tab::make('Active users')
                ->icon('heroicon-m-user-group')
                ->iconPosition(IconPosition::After)
                ->badge(Admin::query()->where('is_active', true)->count())
                ->badgeColor('primary')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', true)),
            'inactive' => \Filament\Resources\Components\Tab::make('inactive users')
                ->icon('heroicon-m-user-group')
                ->iconPosition(IconPosition::After)
                ->badge(Admin::query()->where('is_active', false)->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', false)),
        ];
    }
}
