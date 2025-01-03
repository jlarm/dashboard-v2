<div>
    @if(count($certs) > 0)
    <div class="max-w-xl mx-auto border rounded-md mt-10 p-3">
        <div>
            <ul role="list" class="divide-y divide-gray-100">
                @foreach($certs as $cert)
                    <livewire:dealer.employee.cert-index-item :cert="$cert" :user="$user"/>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
</div>
