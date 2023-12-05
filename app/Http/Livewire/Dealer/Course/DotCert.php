<?php

namespace App\Http\Livewire\Dealer\Course;

use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use Illuminate\Http\Request;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;

class DotCert extends Component
{
    public $showCertButton;

    public function mount()
    {
        if (!$this->passingGrades()) {
            $this->showCertButton = false;
        } else {
            if ($this->passingGrades()->passed && $this->passingGrades()?->created_at->diffInDays(now()) <= 365) {
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
            ->where('user_id', auth()->user()->id)
            ->where('course_id', $course)
            ->first();
    }

    public function download(Request $request)
    {
        $html = view('dealer.course.CertDownloadView', [
            'user' => auth()->user(),
            'store' => $request->get('store')?->name ?? tenant('name'),
            'passed_on' => $this->passingGrades()->created_at->format('F d, Y'),
        ])->render();

        $pdf = Browsershot::html($html)->landscape()->pdf();

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf;
        }, 'certificate.pdf');
    }

    public function render()
    {
        return view('livewire.dealer.course.dot-cert');
    }
}
