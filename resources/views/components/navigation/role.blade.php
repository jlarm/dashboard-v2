<div>
    <span class="inline-flex items-center rounded-md bg-green-100 px-2.5 py-0.5 text-sm font-medium text-green-800">
        {{ Auth::user()->roles()->first()->name ?? '' }}
    </span>
</div>
