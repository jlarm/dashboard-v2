<div class="relative p-4 flex flex-col bg-white border border-gray-200 rounded-xl {{ $this->dotProgress() ? 'opacity-35' : 'hover:border-gray-400' }}">
    <div class="min-w-0 flex-1">
        <div class="space-y-1">
            <h4 class="mb-2.5 font-medium text-sm text-gray-800">
                {{ Str::limit(__($course->name), 30) }}
            </h4>
            <!-- Item -->
            <div class="flex justify-between items-center gap-x-2">
                <span class="text-xs text-gray-600">
                  Grade:
                </span>
                <span class="text-xs text-gray-800">
                    {{ $course->lastResult ? $course->lastResult->percentage . '%' : '' }}
                </span>
            </div>
            <!-- End Item -->
            <!-- Item -->
            <div class="flex justify-between items-center gap-x-2">
<span class="text-xs text-gray-600">
  Last Taken:
</span>
                <span class="text-xs text-gray-800">
    {{ $course->lastResult ? $course->lastResult->created_at->format('F d, Y') : '' }}
</span>
            </div>
            <!-- End Item -->
            <!-- Item -->
            <div class="flex justify-between items-center gap-x-2">
<span class="text-xs text-gray-600">
  Status:
</span>
                <span
@class([
    'inline-flex items-center gap-x-1.5 py-0.5 px-1.5 rounded-md text-xs font-medium',
    'text-teal-800 bg-teal-100' => $this->status() === 'passed',
    'text-red-700 bg-red-100' => $this->status() === 'failed',
    'text-yellow-700 bg-yellow-100' => $this->status() === 'expired',
    'bg-gray-100 text-gray-600' => !$course->lastResult || $this->status() === null,
])
                >{{ $this->status() === 'expired' ? 'Retake Required' : Str::title($this->status() ?? 'Not Taken') }}</span>
            </div>
            <!-- End Item -->
            @if(!$this->dotProgress())
                <a class="after:absolute after:inset-0 after:z-10" href="{{ route('courses.show', $course) }}"></a>
            @endif
        </div>
    </div>
</div>
