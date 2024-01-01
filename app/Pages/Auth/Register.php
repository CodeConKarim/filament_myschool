<?php

declare(strict_types=1);

namespace App\Pages\Auth;

use App\Enums\EnumTitles;
use App\Models\Role;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Register as BaseRegister;

final class Register extends BaseRegister
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
                    ->dehydrateStateUsing(fn ($state) => true),
                Hidden::make("is_active")
                    ->dehydrateStateUsing(fn ($state) => true),
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
    public function register(): ?RegistrationResponse
    {
        $panelId = Filament::getCurrentPanel()->getId();
        $role = Role::where('panel_id', $panelId)->first();
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/register.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/register.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/register.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->send();

            return null;
        }

        $data = $this->form->getState();

        $user = $this->getUserModel()::create($data);

        // attach with the current panel role
        //check the role if exist
        if($role) {
            $user->roles()->attach($role);
        }


        $this->sendEmailVerificationNotification($user);

        Filament::auth()->login($user);

        session()->regenerate();

        return app(RegistrationResponse::class);
    }
}
