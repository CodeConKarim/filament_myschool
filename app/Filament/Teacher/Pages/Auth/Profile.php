<?php

declare(strict_types=1);

namespace App\Filament\Teacher\Pages\Auth;

use App\Enums\EnumTitles;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Joshembling\ImageOptimizer\Components\SpatieMediaLibraryFileUpload;

final class Profile extends BaseEditProfile
{
    protected static string $view = 'filament.teacher.pages.auth.profile';

    protected static string $layout = 'filament-panels::components.layout.index';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Group::make()
                            ->schema([
                                Section::make(' ')
                                    ->schema([
                                        $this->getTitleFormComponent(),
                                        $this->getFirstNameFormComponent(),
                                        $this->getLastNameFormComponent(),
                                    ])->columns(["lg" => 3]),
                                Section::make(' ')
                                    ->schema([
                                        $this->getEmailFormComponent(),
                                        $this->getPhoneFormComponent(),
                                    ])->columns(["lg" => 2]),
                                Section::make(' ')
                                    ->schema([
                                        $this->getPasswordFormComponent(),
                                        $this->getPasswordConfirmationFormComponent(),
                                    ])->columns(["lg" => 2]),
                            ])->columnSpan(['lg' => 2]),
                        Group::make()
                            ->schema([
                                Section::make(' ')
                                    ->schema([
                                        $this->getImageFormComponent(),
                                    ])
                            ])
                    ])->columns(["lg" => 3]),
            ]);
    }
    protected function getImageFormComponent(): Component
    {
        return SpatieMediaLibraryFileUpload::make('image_user')
            ->label('')
            ->image()
            ->alignCenter()
            ->imageEditor()
            ->optimize('webp');
    }
    protected function getTitleFormComponent(): Component
    {
        return Select::make('title')
            ->label('Title')
            ->options(EnumTitles::class)
            ->default(EnumTitles::MR)
            ->enum(EnumTitles::class)
            ->native(false)
            ->required();
    }
    protected function getFirstNameFormComponent(): Component
    {
        return TextInput::make('first_name')
            ->label('First Name')
            ->required()
            ->maxLength(255)
            ->autofocus();
    }
    protected function getLastNameFormComponent(): Component
    {
        return TextInput::make('last_name')
            ->label("Last Name")
            ->required()
            ->maxLength(255);
    }
    protected function getPhoneFormComponent(): Component
    {
        return TextInput::make('phone')
            ->label('Phone number')
            ->tel()
            ->required()
            ->unique(ignoreRecord: true);
    }
}
