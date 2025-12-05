<div class="mt-5 rounded-md">
    <div class="w-full border-b pb-3.5 mb-5">
        <p class="w-full text-sm font-semibold text-gray-900">Manage course assignments</p>
        <p class="mt-1 text-xs text-gray-600">Control which courses are assigned to this employee. Default courses follow department and role rules.</p>
    </div>
    <div class="grid grid-cols-12 gap-4 px-6 py-3 bg-slate-50/50 border-b border-slate-100 text-xs font-medium text-slate-500 uppercase tracking-wider">
        <div class="col-span-7">Course Name</div>
        <div class="col-span-2">Department Rule</div>
        <div class="col-span-3 text-right">Action</div>
    </div>
    <div class="divide-y divide-slate-50">
        @foreach($courses as $course)
            <div class="grid grid-cols-12 gap-4 px-6 py-2 items-center hover:bg-slate-50/50 transition-colors group">
                <div class="col-span-7 flex items-center gap-3">
                    <span class="text-xs font-medium text-slate-700 block">{{ $course->name }}</span>
                </div>
                <div class="col-span-2">
                    @if(in_array($course->id, $defaultCourseIds))
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-500">Optional</span>
                    @else
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-emerald-50 text-emerald-700">Required</span>
                    @endif
                </div>
                <div class="col-span-3 flex justify-end">
                    <div class="flex bg-slate-100 p-1 rounded-lg">
                        <button
                            type="button"
                            wire:click="setCourseState({{ $course->id }}, 'default')"
                            @class([
                                'px-3 py-1.5 text-xs font-medium rounded-md transition-all text-slate-500 hover:text-slate-700',
                                'bg-white text-slate-900 shadow-sm' => $courseStates[$course->id] === 'default',
                            ])
                        >
                            Default
                        </button>
                        <button
                            type="button"
                            wire:click="setCourseState({{ $course->id }}, 'add')"
                            @class([
                                'px-3 py-1.5 text-xs font-medium rounded-md transition-all text-slate-500 hover:text-emerald-600',
                                'bg-emerald-600 text-white shadow-sm hover:text-white' => $courseStates[$course->id] === 'add',
                            ])
                        >
                            Add
                        </button>
                        <button
                            type="button"
                            wire:click="setCourseState({{ $course->id }}, 'exclude')"
                            @class([
                                'px-3 py-1.5 text-xs font-medium rounded-md transition-all text-slate-500 hover:text-rose-600',
                                'bg-rose-600 text-white shadow-sm hover:text-white' => $courseStates[$course->id] === 'exclude',
                            ])
                        >
                            Exclude
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
