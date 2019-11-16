<div class="card">
    <div class="card-header">
        <a href="#">
            {{ $reply->owner->name }}
        </a> said {{ $reply->created_at->diffForHumans() }}
    </div>
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        {{ $reply->body }}
    </div>
</div>
<br>
