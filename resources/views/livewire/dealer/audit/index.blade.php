<div>
    @foreach($audits as $audit)
        <div>
            <a href="{{ route('dealer.audit.show', $audit) }}">{{ $audit->created_at->format('F d, Y') }}<br/></a>
        </div>

    @endforeach
</div>
