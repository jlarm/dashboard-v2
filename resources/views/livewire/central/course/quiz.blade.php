<div class="bg-white rounded-md p-4">
    <form method="POST" action="{{ route('courses.quiz.store', $course) }}">
        @csrf
        <div class="questions space-y-10">
            @php
                $i = 1
            @endphp
            @foreach($course['questions'] as $c)
                <div class="bg-gray-50 rounded-lg p-10 border-md">
                    <p class="mb-5 font-bold text-sm">{{ $i }}. {{ $c['question'] }}</p>
                    <div class="space-y-2">
                        @foreach($c['answers'][0] as $key => $value)
                            <label class="flex justify-start items-center space-x-3 text-sm">
                                <input
                                    class="text-arm-blue-600 focus:ring-arm-blue-600"
                                    name="question[{{ $i }}]"
                                    type="radio"
                                    value="{{ $key }}" {{ $key === 'a' ? 'required' : '' }}
                                />
                                <span class="ml-2">{{ $value }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                @php
                    $i++
                @endphp
            @endforeach
            <div class="space-x-3">
                <x-primary-button>Submit</x-primary-button>
                <a href="{{ url()->previous() }}">Cancel</a>
            </div>
        </div>
    </form>
</div>
