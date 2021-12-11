@foreach ($comments as $comment)
    <div class="card m-2">
        <div class="card-header">
            <p>{{ $comment->user->name }} <span class="ml-3">{{ $comment->created_at }}</span>
                @if ($comment->parent_id == 0)
                    <span class="btn btn-sm btn-primary mt-2 float-right" data-toggle="modal" id="btn"
                        data-target="#sendComment" data-id="{{ $comment->id }}" data-type="product">Reply</span>
                @endif
            </p>

        </div>
        <div class="card-body">
            <p>{{ $comment->comment }}</p>
            @include('comment::comment',['comments' => $comment->child->where('approved',1)])
        </div>
    </div>
@endforeach
