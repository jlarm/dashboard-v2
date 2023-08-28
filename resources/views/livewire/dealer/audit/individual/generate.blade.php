<div>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <button type="button"
            x-data
            @if(!$managerCheck)
                x-tooltip="All audits must have a manager assigned."
            @endif
            @if($managerCheck)
                wire:click="generatePdf('{{ $individualAudit->id }}')"
            @endif
            class="@if(!$managerCheck) cursor-not-allowed @endif inline-flex items-center gap-x-1.5 rounded-md bg-arm-blue-600 px-2.5 py-1.5 text-sm text-white shadow-sm hover:bg-arm-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-arm-blue-600">
        <svg wire:loading class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
             xmlns="http://www.w3.org/2000/svg"
             fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                    stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Generate PDF
    </button>
    <script>
        document.addEventListener('alpine:init', () => {
            // Magic: $tooltip
            Alpine.magic('tooltip', el => message => {
                let instance = tippy(el, {content: message, trigger: 'manual'})

                instance.show()

                setTimeout(() => {
                    instance.hide()

                    setTimeout(() => instance.destroy(), 150)
                }, 2000)
            })

            // Directive: x-tooltip
            Alpine.directive('tooltip', (el, {expression}) => {
                tippy(el, {content: expression})
            })
        })
    </script>
</div>
