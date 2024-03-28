<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Certificate;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;

class DotCert extends Component
{
    public User $user;
    public $showCertButton;

    public function mount()
    {
        if (! $this->passingGrades() || $this->user->certificates()->where('course_name', 'DOT Hazardous Materials Transportation')->exists()) {
            $this->showCertButton = false;
        } else {
            if ($this->passingGrades()->passed && $this->passingGrades()?->created_at->diffInDays(now()) <= 1095) {
                $this->showCertButton = true;
            } else {
                $this->showCertButton = false;
            }
        }
    }

    private function passingGrades()
    {
        $course = Course::query()
            ->where('slug', 'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding')
            ->latest()
            ->pluck('id')
            ->first();

        return CourseResults::query()
            ->where('user_id', $this->user->id)
            ->where('course_id', $course)
            ->first();
    }

    public function download(Request $request)
    {
        $html = view('dealer.course.CertDownloadView', [
            'user' => $this->user,
            'store' => $request->get('store')?->name ?? tenant('name'),
            'passed_on' => $this->passingGrades()->created_at->format('F d, Y'),
        ])->render();

        $pdf = Browsershot::html($html)->landscape()->pdf();

        $fileName = Str::slug($this->user->name).'-'.now()->format('m-d-Y').'-dot-certificate.pdf';

        Storage::disk('local')->put($fileName, $pdf);

        $localFile = Storage::disk('local')->get($fileName);

        Storage::disk('armp-certs')->put(tenant('id').'/'.$this->user->id.'/'.$fileName, $localFile);

        Storage::delete($fileName);

        Certificate::create([
            'user_id' => $this->user->id,
            'course_name' => 'DOT Hazardous Materials Transportation',
            'file_name' => $fileName,
        ]);

        $this->showCertButton = false;

        Notification::make()
            ->title('Certificate Generated Successfully!')
            ->body('You can find your certificate in the Certificates section of your profile.')
            ->icon('heroicon-o-document-text')
            ->iconColor('success')
            ->success()
            ->actions([
                Action::make('view-profile')
                    ->button()
                    ->color('primary')
                    ->url(route('dealer.profile.edit')),
            ])
            ->send();

    }

    public function render()
    {
        return view('livewire.dealer.employee.dot-cert');
    }
}
