<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Course;

use App\Models\Certificate;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;

class DotCert extends Component
{
    public $showCertButton;

    public function mount(): void
    {
        $passingGrades = $this->passingGrades();

        if (! $passingGrades || auth()->user()->certificates()->where('course_name', 'DOT Hazardous Materials Transportation')->exists()) {
            $this->showCertButton = false;
        } elseif ($passingGrades->passed && $passingGrades->created_at->diffInDays(now()) <= 1095) {
            $this->showCertButton = true;
        } else {
            $this->showCertButton = false;
        }
    }

    public function download(Request $request): void
    {
        $passingGrades = $this->passingGrades();

        if (! $passingGrades instanceof CourseResults) {
            return;
        }

        $html = view('dealer.course.CertDownloadView', [
            'user' => auth()->user(),
            'store' => $request->get('store')?->name ?? tenant('name'),
            'passed_on' => $passingGrades->created_at->format('F d, Y'),
        ])->render();

        $pdf = Browsershot::html($html)->landscape()->pdf();

        $fileName = Str::slug(auth()->user()->name).'-'.now()->format('m-d-Y').'-dot-certificate.pdf';

        Storage::disk('local')->put($fileName, $pdf);

        $localFile = Storage::disk('local')->get($fileName);

        Storage::disk('armp-certs')->put(tenant('id').'/'.auth()->user()->id.'/'.$fileName, $localFile);

        Storage::delete($fileName);

        Certificate::query()->create([
            'user_id' => auth()->user()->id,
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
        return view('livewire.dealer.course.dot-cert');
    }

    private function passingGrades(): ?CourseResults
    {
        $course = Course::query()
            ->where('slug', 'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding')
            ->latest()
            ->value('id');

        return CourseResults::query()
            ->where('user_id', auth()->user()->id)
            ->where('course_id', $course)
            ->first();
    }
}
