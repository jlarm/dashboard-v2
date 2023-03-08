<div class="flex flex-col space-y-3">
    <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
    <span>{{ $user->phoneNumber }}</span>
    <div class="flex flex-col">
        @foreach($user->stores as $store)
            <div>
                <span>{{ $store->name ?? 'Liberty Auto Plaza' }}</span>
            </div>
        @endforeach
        <span>{{ $user->department->name ?? '-' }} {{ $user->roles->first()->name }}</span>
    </div>
</div>
