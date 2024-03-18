<div>
    <div class="px-6 py-5 sm:flex sm:items-center sm:justify-between">
        <div class="w-full flex justify-between space-x-3">
            <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate leading-normal">{{ $campaign['name'] }}</h1>
            <div class="flex items-center space-x-2">
                        <span class="relative flex h-3 w-3">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                        </span>
                <span class="text-sm font-medium text-green-700">{{ $campaign['status'] }}</span>
            </div>
        </div>
        <div class="mt-4 flex sm:mt-0 sm:ml-4">

        </div>
    </div>

    <div class="px-6">
        <div class="grid grid-cols-3 gap-3">
            <div class="col-span-2">
                <ul x-data="{ active: 0 }" role="list" class="space-y-3">
                    @foreach($users as $user)
                        <li
                            x-data="{
                                    id: {{ $loop->index }} + 1,
                                    get expanded() {
                                        return this.active === this.id
                                    },
                                    set expanded(value) {
                                        this.active = value ? this.id : null
                                    }
                                }"
                            class="border rounded-md"
                        >
                            <div x-on:click="expanded = !expanded" class="flex items-center gap-x-3 p-4 hover:cursor-pointer">
                                <h3 class="flex-auto truncate text-sm font-semibold leading-6 text-gray-900">{{ $user['first_name'] }} {{ $user['last_name'] }}</h3>
                                <button>
                                    <svg x-show="!expanded" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                    </svg>
                                    <svg x-show="expanded" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                                    </svg>

                                </button>
                            </div>
                            <div class="px-4" x-show="expanded" x-collapse x-cloak>
                                <p class="text-sm text-gray-400 italic">Email: {{ $user['email'] }}</p>
                                <p class="text-sm text-gray-400 italic">Result ID: {{ $user['id'] }}</p>
                                <div class="flow-root my-5">
                                    <ul role="list" class="-mb-8">
                                        @foreach($user['timeline'] as $entry)
                                            <li>
                                                <div class="relative pb-8">
                                                    <span class="absolute left-5 top-5 -ml-px h-full w-0.5 bg-gray-200 {{ $loop->last ? 'hidden' : '' }}" aria-hidden="true"></span>
                                                    <div class="relative flex items-start space-x-3">
                                                        <div>
                                                            <div class="relative px-1">
                                                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 ring-8 ring-white">
                                                                    @if($entry['message'] === 'Email Sent')
                                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-gray-500">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                                                        </svg>
                                                                    @elseif($entry['message'] === 'Email Opened')
                                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-gray-500">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z" />
                                                                        </svg>
                                                                    @elseif($entry['message'] === 'Clicked Link')
                                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-gray-500">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243-1.59-1.59" />
                                                                        </svg>
                                                                    @elseif($entry['message'] === 'Submitted Data')
                                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-gray-500">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                                                        </svg>
                                                                    @else
                                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-gray-500">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
                                                                        </svg>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="min-w-0 flex-1 py-0">
                                                            <div class="text-sm leading-8 text-gray-400">
                                                                      <span class="mr-0.5">
                                                                        <span class="font-medium text-gray-900">{{ $entry['message'] }}</span>
                                                                      </span>
                                                                <span class="whitespace-nowrap">{{ \Carbon\Carbon::parse($entry['time'])->format('F d, Y g:ia') }}</span>
                                                                @if($entry['message'] === 'Clicked Link' || $entry['message'] === 'Submitted Data')
                                                                    <div class="mt-2 text-gray-700">
                                                                        <div class="flex items-center space-x-1">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                                                                            </svg>
                                                                            <p>
                                                                                @php
                                                                                    $userAgent = json_decode($entry['details'], true)['browser']['user-agent'];

                                                                                    if (preg_match('/Windows NT (\d+\.\d+)/', $userAgent, $matches)) {
                                                                                        $osVersion = $matches[1];
                                                                                        echo "Windows (OS Version: $osVersion)" . PHP_EOL;
                                                                                    } elseif (preg_match('/Macintosh; Intel Mac OS X (\d+_\d+_\d+)/', $userAgent, $matches)) {
                                                                                        $osVersion = str_replace('_', '.', $matches[1]);
                                                                                        echo "Mac OS (OS Version: $osVersion)" . PHP_EOL;
                                                                                    } elseif (preg_match('/Linux/', $userAgent, $matches)) {
                                                                                        echo "Linux" . PHP_EOL;
                                                                                    } elseif (preg_match('/Android (\d+\.\d+)/', $userAgent, $matches)) {
                                                                                        $osVersion = $matches[1];
                                                                                        echo "Android (OS Version: $osVersion)" . PHP_EOL;
                                                                                    } elseif (preg_match('/iPhone OS (\d+_\d+)/', $userAgent, $matches)) {
                                                                                        $osVersion = str_replace('_', '.', $matches[1]);
                                                                                        echo "iPhone OS (OS Version: $osVersion)" . PHP_EOL;
                                                                                    } elseif (preg_match('/iPad OS (\d+_\d+)/', $userAgent, $matches)) {
                                                                                        $osVersion = str_replace('_', '.', $matches[1]);
                                                                                        echo "iPad OS (OS Version: $osVersion)" . PHP_EOL;
                                                                                    } elseif (preg_match('/CrOS/', $userAgent, $matches)) {
                                                                                        echo "Chrome OS" . PHP_EOL;
                                                                                    } elseif (preg_match('/Windows Phone (\d+\.\d+)/', $userAgent, $matches)) {
                                                                                        $osVersion = $matches[1];
                                                                                        echo "Windows Phone (OS Version: $osVersion)" . PHP_EOL;
                                                                                    } elseif (preg_match('/BlackBerry (\d+\.\d+)/', $userAgent, $matches)) {
                                                                                        $osVersion = $matches[1];
                                                                                        echo "BlackBerry (OS Version: $osVersion)" . PHP_EOL;
                                                                                    } elseif (preg_match('/Symbian/', $userAgent, $matches)) {
                                                                                        echo "Symbian" . PHP_EOL;
                                                                                    } elseif (preg_match('/webOS/', $userAgent, $matches)) {
                                                                                        echo "webOS" . PHP_EOL;
                                                                                    } elseif (preg_match('/Bada/', $userAgent, $matches)) {
                                                                                        echo "Bada" . PHP_EOL;
                                                                                    } elseif (preg_match('/Tizen/', $userAgent, $matches)) {
                                                                                        echo "Tizen" . PHP_EOL;
                                                                                    } elseif (preg_match('/KaiOS/', $userAgent, $matches)) {
                                                                                        echo "KaiOS" . PHP_EOL;
                                                                                    } else {
                                                                                        echo "Unable to determine OS from user-agent." . PHP_EOL;
                                                                                    }
                                                                                @endphp
                                                                            </p>
                                                                        </div>
                                                                        <div class="flex items-center space-x-1">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" color="#000000" fill="none">
                                                                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" />
                                                                                <circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5" />
                                                                                <path d="M8.53448 14L4.0332 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                                                                <path d="M11.5 21.5L15.5 14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                                                                <path d="M12 8H21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                                                            </svg>
                                                                            <p>
                                                                                @php
                                                                                    $userAgent = json_decode($entry['details'], true)['browser']['user-agent'];
                                                                                    preg_match('/Windows NT (\d+\.\d+)/', $userAgent, $matches);
                                                                                    preg_match('/Chrome\/([\d.]+)/', $userAgent, $matches);
                                                                                    if (preg_match('/Chrome\/([\d.]+)/', $userAgent, $matches)) {
                                                                                        $chromeVersion = $matches[1];
                                                                                        echo "Chrome (Version: $chromeVersion)" . PHP_EOL;
                                                                                    } elseif (preg_match('/Safari/', $userAgent, $matches)) {
                                                                                        echo "Safari" . PHP_EOL;
                                                                                    } elseif (preg_match('/Firefox/', $userAgent, $matches)) {
                                                                                        echo "Firefox" . PHP_EOL;
                                                                                    } elseif (preg_match('/Edge/', $userAgent, $matches)) {
                                                                                        echo "Edge" . PHP_EOL;
                                                                                    } elseif (preg_match('/Opera/', $userAgent, $matches)) {
                                                                                        echo "Opera" . PHP_EOL;
                                                                                    } elseif (preg_match('/MSIE/', $userAgent, $matches)) {
                                                                                        echo "Internet Explorer" . PHP_EOL;
                                                                                    } else {
                                                                                        echo "Unable to determine Chrome version from user-agent." . PHP_EOL;
                                                                                    }
                                                                                @endphp
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <dl class="mx-auto grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-2">
                    <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 px-4 py-10 sm:px-6 xl:px-8 border rounded-md hover:bg-gray-50">
                        <dt class="text-sm font-medium leading-6 text-gray-500">Email Sent</dt>
                        <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">{{ $sentCount }}</dd>
                    </div>
                    <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 px-4 py-10 sm:px-6 xl:px-8 border rounded-md hover:bg-gray-50">
                        <dt class="text-sm font-medium leading-6 text-gray-500">Email Opened</dt>
                        <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">{{ $counts['opened'] }}</dd>
                    </div>
                    <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 px-4 py-10 sm:px-6 xl:px-8 border rounded-md hover:bg-gray-50">
                        <dt class="text-sm font-medium leading-6 text-gray-500">Clicked Link</dt>
                        <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">{{ $counts['clicked'] }}</dd>
                    </div>
                    <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 px-4 py-10 sm:px-6 xl:px-8 border rounded-md hover:bg-gray-50">
                        <dt class="text-sm font-medium leading-6 text-gray-500">Submitted Data</dt>
                        <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">{{ $counts['submitted'] }}</dd>
                    </div>
                    <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 px-4 py-10 sm:px-6 xl:px-8 border rounded-md hover:bg-gray-50">
                        <dt class="text-sm font-medium leading-6 text-gray-500">Email Reported</dt>
                        <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">{{ $counts['reported'] }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
