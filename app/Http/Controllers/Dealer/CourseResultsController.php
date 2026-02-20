<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dealer;

use App\Exports\UserCourseResultsExport;
use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Browsershot\Browsershot;

class CourseResultsController extends Controller
{
    public function export()
    {
        return Excel::download(new UserCourseResultsExport, 'users.csv', \Maatwebsite\Excel\Excel::CSV, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function store(Request $request, Course $course): RedirectResponse
    {
        $questions = collect($course['questions'])->values();
        $count = $questions->count();
        $submittedAnswers = $request->input('question', []);
        $score = 0;
        $incorrectQuestions = [];

        for ($i = 0; $i < $count; $i++) {
            $question = $questions[$i];
            $answers = $question['answers'][0] ?? [];
            $correctAnswerKey = (string) ($question['correctAnswer'] ?? '');
            $submittedAnswerKey = (string) ($submittedAnswers[$i + 1] ?? '');

            if ($correctAnswerKey === $submittedAnswerKey) {
                $score++;
                continue;
            }

            $incorrectQuestions[] = [
                'question' => __($question['question'] ?? ''),
                'incorrect_answer_key' => $submittedAnswerKey,
                'incorrect_answer' => __($answers[$submittedAnswerKey] ?? ''),
            ];
        }

        // generate score
        $score = $count > 0 ? ($score / $count) * 100 : 0;

        // check if passed
        $passed = $score >= 70;

        $results = CourseResults::query()->create([
            'percentage' => $score,
            'passed' => $passed,
            'course_id' => $course->id,
            'user_id' => auth()->user()->id,
        ]);

        if ($course->slug === 'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding' && $passed) {

            $html = view('dealer.course.CertDownloadView', [
                'user' => auth()->user(),
                'store' => $request->get('store')?->name ?? tenant('name'),
                'passed_on' => $results->created_at->format('F d, Y'),
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

            Notification::make()
                ->title('Certificate Created Successfully!')
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

        session()->flash('flash.quizPercentage', round($score));
        session()->flash('flash.quizPassed', $passed);
        session()->flash('flash.courseName', $course->name);
        session()->flash('flash.courseUrl', route('dealer.courses.show', $course));
        session()->flash('flash.quizIncorrectQuestions', $incorrectQuestions);

        return redirect()->route('dealer.courses.index');
    }
}
