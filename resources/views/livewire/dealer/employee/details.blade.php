<div class="flex flex-col space-y-3">
    {{ $user->email }}<br/>
    {{ $user->phone }}<br/>
    {{ $user->store->name ?? tenant('company') }}<br/>
    {{ $user->department->name ?? '-' }}
    {{ $user->roles->first()->name }}
</div>
