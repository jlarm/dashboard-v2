<x-guest-layout>
    <div class="h-screen flex items-center justify-center">
        <div class="flex flex-col space-y-10">
            <x-application-logo class="w-auto h-14 text-gray-600" />
            @if(session('error'))
                <p>This contract has already been signed. If you have any questions please contact your ARMP consultant.</p>
            @else
                <p>Thank You, we will be sending you the completed contract once it has been accepted by the office.</p>
            @endif
        </div>
    </div>
</x-guest-layout>
