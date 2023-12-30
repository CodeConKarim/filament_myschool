<?php

namespace App\Filament\School\Pages\Auth;

use App\Enums\EnumTitles;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as BaseRegister;

class Register extends BaseRegister
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getTitleFormComponent(),
                $this->getFirstNameFormComponent(),
                $this->getLastNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPhoneFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
                Hidden::make("is_owner")
                    ->dehydrateStateUsing(fn($state)=>true),
                Hidden::make("is_active")
                    ->dehydrateStateUsing(fn($state)=>true),
            ]);
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
