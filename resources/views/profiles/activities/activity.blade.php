<div class="card">
    <div class="card-header">
        <div class="level">
            <span class="flex">
                {{ $heading }}

                {{--<a href="{{ route('profile', $thread->creator) }}">--}}
                {{--{{ $thread->creator->name }} </a> posted:--}}
                {{--<a href="{{ $thread->path() }}">{{ $thread->title }}</a>--}}
            </span>
        </div>
    </div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        {{ $body }}
    </div>
</div>
<br>
