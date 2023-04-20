<div class="space-y-8">
    <div class="space-y-5">
        <div>
            <p>Oil Manifest</p>
            @if($audit->oil_manifest === 1)
                <p>Yes</p>
            @elseif($audit->oil_manifest === 2)
                <p>No</p>
            @else
                N/A
            @endif
        </div>
        <div>
            <p>Comments:</p>
            {{ $audit->osha_q1_comment }}
        </div>
        <div class="flex -space-x-16">
            @foreach($audit->getMedia('osha_q1_images') as $image)
                <dd>
                    <img alt="{{ $image->name }}" src="{{ $image->getUrl() }}"
                         class="h-36 w-36 rounded-full bg-gray-50 ring-2 ring-white">
                </dd>
            @endforeach
        </div>
    </div>
    <div>
        {{ $audit->osha_q2_answer }}<br/>
        {{ $audit->osha_q2_comment }}<br/>
        <div class="flex -space-x-16">
            @foreach($audit->getMedia('osha_q2_images') as $image)
                <dd>
                    <img alt="{{ $image->name }}" src="{{ $image->getUrl() }}"
                         class="h-36 w-36 rounded-full bg-gray-50 ring-2 ring-white">
                </dd>
            @endforeach
        </div>
    </div>
    <div>
        {{ $audit->osha_q3_answer }}<br/>
        {{ $audit->osha_q3_comment }}<br/>
        <div class="flex -space-x-16">
            @foreach($audit->getMedia('osha_q3_images') as $image)
                <dd>
                    <img alt="{{ $image->name }}" src="{{ $image->getUrl() }}"
                         class="h-36 w-36 rounded-full bg-gray-50 ring-2 ring-white">
                </dd>
            @endforeach
        </div>
    </div>
</div>
