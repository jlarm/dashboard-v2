<?php

declare(strict_types=1);

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

    public function mount(): void
    {
        $this->showCertButton = $this->shouldShowCertButton();
    }

    public function download(Request $request): void
    {
        $fileName = $this->generatePdf($request);
        $filePath = $this->storePdf($fileName);

        Certificate::query()->create([
            'user_id' => $this->user->id,
            'course_name' => 'DOT Hazardous Materials Transportation',
            'file_name' => $fileName,
        ]);

        $this->showCertButton = false;

        $url = Storage::disk('armp-certs')->temporaryUrl($filePath, now()->addHour());

        $this->sendNotification($url);
    }

    public function render()
    {
        return view('livewire.dealer.employee.dot-cert');
    }

    private function shouldShowCertButton(): bool
    {
        $passingGrades = $this->passingGrades();

        if (! $passingGrades || $this->user->certificates()->where('course_name', 'DOT Hazardous Materials Transportation')->exists()) {
            return false;
        }

        return $passingGrades->passed && $passingGrades->created_at->diffInDays(now()) <= 1095;
    }

    private function passingGrades()
    {
        $courseId = Course::query()
            ->where('slug', 'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding')
            ->latest()
            ->value('id');

        return CourseResults::query()
            ->where('user_id', $this->user->id)
            ->where('course_id', $courseId)
            ->first();
    }

    private function generatePdf(Request $request): string
    {
        $html = view('dealer.course.CertDownloadView', [
            'user' => $this->user,
            'store' => $request->get('store')?->name ?? tenant('name'),
            'passed_on' => $this->passingGrades()->created_at->format('F d, Y'),
        ])->render();

        $pdf = Browsershot::html($html)->landscape()->pdf();
        $fileName = Str::slug($this->user->name).'-'.now()->format('m-d-Y').'-dot-certificate.pdf';

        Storage::disk('local')->put($fileName, $pdf);

        return $fileName;
    }

    private function storePdf(string $fileName): string
    {
        $localFile = Storage::disk('local')->get($fileName);
        $filePath = tenant('id').'/'.$this->user->id.'/'.$fileName;

        Storage::disk('armp-certs')->put($filePath, $localFile);
        Storage::delete($fileName);

        return $filePath;
    }

    private function sendNotification(string $url): void
    {
        Notification::make()
            ->title('Certificate Generated Successfully!')
            ->body('You can find your certificate in the Certificates section of your profile. <a href="'.$url.'">Download Certificate</a>')
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
}
