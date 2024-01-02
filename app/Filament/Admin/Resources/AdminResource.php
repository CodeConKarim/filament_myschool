<?php

namespace App\Filament\Admin\Resources;

use App\Enums\EnumTitles;
use App\Filament\Admin\Resources\AdminResource\Pages;
use App\Models\Admin;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?string $slug = 'admins-management';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $activeNavigationIcon = 'heroicon-s-user-group';
    protected static ?string $navigationLabel = 'Admins Account';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Accounts Management';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'Admin';
    protected static ?string $pluralModelLabel = 'Admins Management';

    public static function getNavigationBadge(): ?string
    {
        return strval(AdminResource::getModel()::count());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make(' ')
                            ->schema([
                                Forms\Components\Select::make('title')
                                    ->required()
                                    ->options(EnumTitles::class)
                                    ->native(false)
                                    ->enum(EnumTitles::class),
                                Forms\Components\TextInput::make('first_name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('last_name')
                                    ->maxLength(255),
                            ])->columns(["lg" => 3]),
                        Section::make(' ')
                            ->schema([
                                Forms\Components\TextInput::make('phone')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                            ])->columns(["lg" => 2]),
                        Section::make(' ')
                            ->schema([
                                TextInput::make('password')
                                    ->label(__('filament-panels::pages/auth/edit-profile.form.password.label'))
                                    ->password()
                                    ->rule(Password::default())
                                    ->autocomplete('new-password')
                                    ->dehydrated(fn ($state): bool => filled($state))
                                    ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
                                    ->live(debounce: 500)
                                    ->same('passwordConfirmation'),
                                TextInput::make('passwordConfirmation')
                                    ->label(__('filament-panels::pages/auth/edit-profile.form.password_confirmation.label'))
                                    ->password()
                                    ->required()
                                    ->visible(fn (Get $get): bool => filled($get('password')))
                                    ->dehydrated(false),
                            ])->columns(["lg" => 2]),
                    ])->columnSpan(['lg' => 2]),
                Group::make()
                    ->schema([
                        Section::make(' ')
                            ->schema([
                                Forms\Components\SpatieMediaLibraryFileUpload::make('image_admin')
                                    ->label('')
                                    ->image()
                                    ->alignCenter()
                                    ->imageEditor()
                                    ->optimize('webp'),
                            ]),
                        Section::make(' ')
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->required(),
                                Forms\Components\Toggle::make('is_super_admin')
                                    ->required(),
                            ]),
                    ])
            ])->columns(["lg" => 3]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('image_admin')
                    ->label('')
                    ->defaultImageUrl(asset('images/defaultImageProfile2.webp'))
                    ->circular(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_super_admin')
                    ->label('Super Admin')
                    ->boolean(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
