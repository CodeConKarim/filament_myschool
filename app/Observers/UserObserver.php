<?php

namespace App\Observers;

use App\Models\Admin;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //send notification to admin where admin->email it's me or to all admins
        Notification::make()
            ->success()
            ->title('Account created: '.$user->email)
            ->body('The user has been created successfully.')
            ->sendToDatabase(Admin::all());
        //send notification to the user
        Notification::make()
            ->warning()
            ->title('Welcome '. $user->name. ' to the system')
            ->body('Please update your profile')
            ->actions([
                Action::make('Update your profile')
                    ->button()
                    ->url(route('filament.school.auth.profile')),
            ])
            ->sendToDatabase($user);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
