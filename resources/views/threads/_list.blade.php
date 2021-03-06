@forelse ($threads as $thread)
    <div class="card">
        <div class="card-header">
            <div class="level">
                <div class="flex">
                    <h4>
                        <a href="{{ $thread->path() }}">
                            @if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                <strong>
                                    {{ $thread->title }}
                                </strong>
                            @else
                                {{ $thread->title }}
                            @endif
                        </a>
                    </h4>

                    <h5>
                        Postes by: <a href="{{ Route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>
                    </h5>
                </div>

                <a href="{{ $thread->path() }}">
                    {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}
                </a>
            </div>
        </div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="body">
                {{ $thread->body }}
            </div>
        </div>

        <div class="card-footer">
            {{ $thread->visits }} Visits
        </div>
    </div>
    <br>
@empty
    <p>There are no relevant result at this time.</p>
@endforelse
