<x-guest-layout>
    <div class="container mx-auto text-center p-6">
        <div class="flex flex-col justify-center">
            <x-application-logo class="w-auto h-[50px] mx-auto mb-10" />
            <div class="prose min-w-full">
                <h1>Certificate of Completion</h1>
                <p class="my-0">This certificate is awarded to</p>
                <p class="text-4xl font-black my-0">{{ $user->name }}</p>
                <p class="mt-0">{{ $store }}</p>
                <p>for satisfactory completion of the online courses
                    <br /><strong>DOT Hazardous Materials Transportation</strong>
                    <br />which were designed to meet and to include the training requirements for
                    <br /><strong>Globally Harmonized System (GHS)</strong> Sections 1910.120, 1910.1200, 29 CFR
                    <br />and 49 CFR 172.700 Subpart H</p>
                <ul class="list-none text-xs">
                    <li>§172.700 Purpose and scope.</li>
                    <li>§172.701 Federal-State relationship</li>
                    <li>§172.702 Applicability and responsibility for training and testing.</li>
                    <li>§172.704 Training requirements.</li>
                </ul>
                <p>Awarded on: {{ $passed_on }}</p>
                <div class="flex justify-between items-start">
                    <div>
                        <img src="{{ global_asset('sig.png') }}" class="h-20 my-0" alt="">
                        <p class="mt-0">National Operations Director<br />Michael Backer</p>
                    </div>
                    <div>
                        <div class="h-20"></div>
                        <p class="mt-0 mr-20">{{ now()->format('F d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
