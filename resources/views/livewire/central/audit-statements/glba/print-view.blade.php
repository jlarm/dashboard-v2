<div class="max-w-7xl mx-auto">
    <div class="space-y-3">
        @foreach($violations as $violation)
            <p>{{ $loop->index + 1 }}. {{ $violation->statement }}</p>
        @endforeach
    </div>
</div>

<script>window.print()</script>
