<div>
    <div class="space-y-5">
        <div class="flex justify-start items-center gap-3">
            <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">{{ $video['title'] }}</h1>
            @if ($this->videoCompleted())
                <div class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                    Completed
                </div>
            @endif
        </div>

        <div class="w-full max-w-4xl mx-auto">
            <iframe src="{{ $video['player_embed_url'] }}" encrypted-media class="w-full h-[500px]"></iframe>
        </div>
    </div>

    <script src="https://player.vimeo.com/api/player.js" width="640" height="360"></script>
    <script>
        const iframe = document.querySelector('iframe');
        const player = new Vimeo.Player(iframe);

        player.on('ended', () => {
            Livewire.emit('completedVideo');
        });
    </script>
</div>
