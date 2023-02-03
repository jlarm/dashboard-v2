<div class="flex flex-col space-y-3">
    <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
    <span>{{ $user->phoneNumber }}</span>
    <div class="flex flex-col">
        <span>{{ $user->store->name ?? tenant('company') }}</span>
        <span>{{ $user->department->name ?? '-' }} {{ $user->roles->first()->name }}</span>
    </div>
</div>
