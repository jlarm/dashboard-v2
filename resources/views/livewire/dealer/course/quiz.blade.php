<div>
    <form method="POST" action="{{ route('dealer.courses.results.store', $course) }}">
        @csrf
        <div class="questions space-y-10">
            @php
                $i = 1
            @endphp
            @foreach($course['questions'] as $c)
                <div class="bg-gray-50 rounded-lg p-10 border-md">
                    <p class="mb-5 font-bold">{{ $i }}. {{ $c['question'] ?? '' }}</p>
                    <div class="space-y-2">
                        @foreach($c['answers'][0] as $key => $value)
                            <label class="flex justify-start items-center space-x-3">
                                <input name="question[{{ $i }}]" type="radio"
                                       value="{{ $key }}" {{ $key === 'a' ? 'required' : '' }}/>
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
                <x-primary-button>{{ __('Submit') }}</x-primary-button>
                <a href="{{ url()->previous() }}">{{ __('Cancel') }}</a>
            </div>
        </div>
    </form>
</div>
