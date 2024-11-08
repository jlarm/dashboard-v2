<div class="px-4 py-2">
    <div class="flex items-center justify-between">
        <span class="text-sm text-gray-700">{{ __('Language') }}</span>
        <div class="bg-gray-100 rounded-lg p-0.5 flex">
            <button 
                onclick="window.location.href='{{ url('language/en') }}'"
                class="px-3 py-1 text-xs font-medium rounded-md transition-colors duration-200 {{ $current_locale === 'en' 
                    ? 'bg-white text-gray-900 shadow-sm' 
                    : 'text-gray-500 hover:text-gray-700' }}"
            >
                EN
            </button>
            <button 
                onclick="window.location.href='{{ url('language/es') }}'"
                class="px-3 py-1 text-xs font-medium rounded-md transition-colors duration-200 {{ $current_locale === 'es' 
                    ? 'bg-white text-gray-900 shadow-sm' 
                    : 'text-gray-500 hover:text-gray-700' }}"
            >
                ES
            </button>
        </div>
    </div>
</div>
<div class="border-t border-gray-100"></div>
