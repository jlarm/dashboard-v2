<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $course->name }} — Quiz</title>
    <style>
        @page { margin: 40px; }
        body { font-family: 'Helvetica Neue', Arial, sans-serif; color: #1f2937; margin: 0; }
        h1 { font-size: 24px; padding-bottom: 4px; margin-bottom: 4px; }
        .department { font-size: 13px; color: #6b7280; margin-bottom: 20px; padding-bottom: 8px; border-bottom: 2px solid #1f2937; }
        .department-label { font-weight: 600; color: #1f2937; }
        .question { margin-bottom: 24px; page-break-inside: avoid; }
        .question-text { font-weight: 600; margin-bottom: 10px; }
        .answers { list-style: none; padding: 0; margin: 0; }
        .answers li { padding: 6px 10px; margin-bottom: 4px; border: 1px solid #e5e7eb; border-radius: 4px; }
        .answers li.correct { background-color: #d1fae5; border-color: #10b981; font-weight: 600; }
        .key { display: inline-block; width: 22px; font-weight: 700; }
        .badge { float: right; background: #10b981; color: #fff; font-size: 11px; padding: 2px 8px; border-radius: 999px; }
    </style>
</head>
<body>
    <h1>{{ $course->name }}</h1>
    @if(!empty($departmentLabel))
        <div class="department"><span class="department-label">Department:</span> {{ $departmentLabel }}</div>
    @else
        <div class="department"></div>
    @endif

    @foreach($course->questions as $index => $question)
        <div class="question">
            <div class="question-text">{{ $index + 1 }}. {{ $question['question'] }}</div>
            <ul class="answers">
                @foreach($question['answers'][0] as $key => $answer)
                    <li class="{{ $key === $question['correctAnswer'] ? 'correct' : '' }}">
                        <span class="key">{{ strtoupper($key) }}.</span>
                        {{ $answer }}
                        @if($key === $question['correctAnswer'])
                            <span class="badge">Correct</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</body>
</html>
