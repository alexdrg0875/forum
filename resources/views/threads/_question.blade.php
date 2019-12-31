{{--Editing the question--}}
<div class="card" v-if="editing">
    <div class="card-header">
        <div class="level">
            <input class="form-control" type="text" value="{{ $thread->title }}">

        </div>
    </div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="form-group">
            <textarea class="form-control" name="" id="" rows="10">{{ $thread->body }}</textarea>
        </div>
    </div>
    <div class="card-footer">
        <div class="level">
            {{--<button class="btn btn-xs btn-outline-secondary level-item" @click="editing = true">Edit</button>--}}
            <button class="btn btn-xs btn-outline-primary level-item" @click="">Update</button>
            <button class="btn btn-xs btn-outline-secondary level-item" @click="editing = false">Cancel</button>

            @can('update', $thread)
                <form action="{{ $thread->path() }}" method="POST" class="ml-auto">
                    @csrf
                    {{ method_field('DELETE') }}

                    <button type="submit" class="btn btn-link">Delete Thread</button>
                </form>
            @endcan
        </div>
    </div>
</div>

{{--Viewing the question--}}
<div class="card" v-else>
    <div class="card-header">
        <div class="level">
            <img class="mr-1"
                 src="{{ $thread->creator->avatar_path }}"
                 alt="{{ $thread->creator->name }}'s avatar"
                 width="25"
                 height="25">

            <span class="flex">
                <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> posted:{{ $thread->title }}
            </span>

        </div>
    </div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        {{ $thread->body }}
    </div>
    <div class="card-footer">
        <button class="btn btn-xs btn-outline-secondary" @click="editing = true">Edit</button>
    </div>
</div>
