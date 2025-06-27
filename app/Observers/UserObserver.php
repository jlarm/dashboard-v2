<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;


class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        try {
            Cache::store('redis')->tags(['user_index'])->flush();
        } catch (\Exception $e) {
            Cache::forget('user_index');
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        try {
            Cache::store('redis')->tags(['user_index'])->flush();
        } catch (\Exception $e) {
            Cache::forget('user_index');
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        try {
            Cache::store('redis')->tags(['user_index'])->flush();
        } catch (\Exception $e) {
            Cache::forget('user_index');
        }
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        try {
            Cache::store('redis')->tags(['user_index'])->flush();
        } catch (\Exception $e) {
            Cache::forget('user_index');
        }
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        try {
            Cache::store('redis')->tags(['user_index'])->flush();
        } catch (\Exception $e) {
            Cache::forget('user_index');
        }
    }
}
