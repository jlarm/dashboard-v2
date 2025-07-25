<?php

namespace App\Services;

use App\Models\RemediationSetting;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

class ReminderService
{
    public static function createRemediationReminders(Model $model): void
    {
        if (! method_exists($model, 'reminders')) {
            throw new RuntimeException(get_class($model).' must have a reminders() relationship');
        }

        if (! isset($model->store_id)) {
            throw new RuntimeException(get_class($model).' must have a store_id');
        }

        $setting = RemediationSetting::where('store_id', $model->store_id)->first();

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
