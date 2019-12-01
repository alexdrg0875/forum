<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="card">
        <div class="card-header">
            <div class="level">
                <h5 class="flex">
                    <a href="{{ route('profile', $reply->owner) }}">
                        {{ $reply->owner->name }}
                    </a> said {{ $reply->created_at->diffForHumans() }}
                </h5>
                <div>
                    <favorite :reply="{{ $reply }}"></favorite>
                    {{--<form method="POST" action="/replies/{{ $reply->id }}/favorites">--}}
                        {{--@csrf--}}
                        {{--<button type="submit"--}}
                                {{--class="btn btn-outline-secondary" {{ $reply->isFavorited() ? 'disabled' : '' }}>--}}
                            {{--{{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count) }}--}}
                        {{--</button>--}}
                    {{--</form>--}}
                </div>
            </div>
        </div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-primary btn-xs" @click="update">Update</button>
                <button class="btn btn-link btn-xs" @click="editing = false">Cancel</button>
            </div>
            <div v-else v-text="body"></div>
        </div>

        @can('update', $reply)
            <div class="card-footer level">
                <button class="btn btn-info btn-xs mr-1" @click="editing = true">Edit</button>
                <button class="btn btn-danger btn-xs mr-1" @click="destroy">Delete</button>

                {{--<form method="POST" action="/replies/{{  $reply->id }}">--}}
                    {{--@csrf--}}
                    {{--{{ method_field('DELETE') }}--}}
                    {{--<button type="submit" class="btn btn-danger btn-xs">--}}
                        {{--Delete--}}
                    {{--</button>--}}
                {{--</form>--}}
            </div>
        @endcan

    </div>
</reply>
