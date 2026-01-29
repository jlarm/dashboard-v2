<div class="flow-root">
    <table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-gray-300']) }}>
        <thead>
        <tr>
            {{ $head }}
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
        {{ $body }}
        </tbody>
    </table>
</div>
