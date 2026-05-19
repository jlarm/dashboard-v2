@php
    $fontDir = resource_path('fonts/inter');
    $weights = [400, 500, 600, 700];
@endphp
<style>
    @foreach ($weights as $weight)
        @font-face {
            font-family: 'Inter';
            font-style: normal;
            font-weight: {{ $weight }};
            font-display: block;
            src: url(data:font/ttf;base64,{{ base64_encode(file_get_contents($fontDir.'/Inter-'.$weight.'.ttf')) }}) format('truetype');
        }
    @endforeach
</style>
