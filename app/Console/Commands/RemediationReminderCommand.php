<?php

namespace App\Console\Commands;

use App\Mail\RemediationReminderMail;
use App\Models\User;
use Illuminate\Console\Command;
use App\Models\RemediationReminders;
use App\Models\RemediationSetting;
use Illuminate\Support\Facades\Mail;

class RemediationReminderCommand extends Command
{
    protected $signature = 'remediation:reminder  {--tenants=* : The tenant(s) to run the command for. Default all.}';

    protected $description = 'Command description';

    public function handle(): void
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {
            $locations = tenant('locations');

            $reminders = RemediationReminders::with('remindable')
                ->where('send_date', now()->toDateString())
                ->get();

            foreach ($reminders as $reminder) {
                if ($reminder->remindable->remediation_pdf_path !== null) {
                    $reminder->delete();
                    continue;
                }

                $modelType = $this->getModelType($reminder->remindable);

                $setting = RemediationSetting::where('store_id', $reminder->store_id)
                    ->first();

                $storeSlug = $setting->store->slug;

                if (!$setting->notifications) {
                    $reminder->delete();
                    continue;
                }

                foreach ($setting->managers as $audit => $managers) {
                    if (str_contains($modelType, $audit)) {
                        foreach ($managers as $manager) {
                            $user = User::find($manager);
                            Mail::to($user->email)->queue(new RemediationReminderMail($audit, $locations, $storeSlug));
                        }
                    }
                }

                $reminder->delete();
            }
        });
    }

    private function getModelType($model): string
    {
        $modelType = $model->getMorphClass();
        return class_basename($modelType);
    }
}
