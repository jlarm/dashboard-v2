<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\RemediationSetting;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

class ReminderService
{
    public static function createRemediationReminders(Model $model): void
    {
        throw_unless(method_exists($model, 'reminders'), new RuntimeException($model::class.' must have a reminders() relationship'));

        throw_unless(property_exists($model, 'store_id') && $model->store_id !== null, new RuntimeException($model::class.' must have a store_id'));

        $setting = RemediationSetting::query()->where('store_id', $model->store_id)->first();

        if (! $setting) {
            return;
        }

        if ($setting->active === false) {
            return;
        }

        if ($setting->notifications === false) {
            return;
        }

        $interval = $setting->frequency->value();

        $dates = [
            now()->addDays($interval),
            now()->addDays($interval * 2),
        ];

        foreach ($dates as $date) {
            $model->reminders()->create([
                'send_date' => $date,
                'store_id' => $model->store_id,
            ]);
        }
    }
}
