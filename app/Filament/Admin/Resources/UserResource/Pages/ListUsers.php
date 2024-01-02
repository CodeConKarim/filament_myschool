<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\UserResource\Pages;

use App\Filament\Admin\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\IconPosition;
use Illuminate\Database\Eloquent\Builder;

final class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create'),
        ];
    }
    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All users')
                ->icon('heroicon-m-user-group')
                ->iconPosition(IconPosition::After)
                ->badge(User::all()->count())
                ->badgeColor('success'),
            'owner' => Tab::make('Owner users')
                ->icon('heroicon-m-user-group')
                ->iconPosition(IconPosition::After)
                ->badge(User::query()->where('is_owner', true)->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_owner', true)),
            'administration' => Tab::make('School administration')
                ->icon('heroicon-m-user-group')
                ->iconPosition(IconPosition::After)
                ->badge(User::query()->whereHas('roles',function ($query) {
                    $query->where('panel_id',Filament::getPanel('school')->getId());
                })->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('roles', function ($query) {
                    $query->where('panel_id',Filament::getPanel('school')->getId());
                })),
            'teacher' => Tab::make('Teachers')
                ->icon('heroicon-m-user-group')
                ->iconPosition(IconPosition::After)
                ->badge(User::query()->whereHas('roles',function ($query) {
                    $query->where('panel_id',Filament::getPanel('teacher')->getId());
                })->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('roles', function ($query) {
                    $query->where('panel_id',Filament::getPanel('teacher')->getId());
                })),
            'active' => Tab::make('Active users')
                ->icon('heroicon-m-user-group')
                ->iconPosition(IconPosition::After)
                ->badge(User::query()->where('is_active', true)->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', true)),
            'inactive' => Tab::make('inactive users')
                ->icon('heroicon-m-user-group')
                ->iconPosition(IconPosition::After)
                ->badge(User::query()->where('is_active', false)->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', false)),
        ];
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'all';
    }

}
