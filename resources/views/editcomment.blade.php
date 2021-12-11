@component('admin.layouts.content', ['title' => 'Edit'])
    <h2 class="text-center">Edit Comment</h2>
    @foreach ($errors->all() as $error)
        <span class="text-danger m-1">{{ $error }}</span><br>
    @endforeach
    <div class="container mt-3">
        <form action="/user/{{ $comment->id }}/comments/update" method="post">
            @csrf
            @method('put')
            <div class="form-group">
                <input type="text" name="comment" class="form-control" placeholder="Comment"
                    value="{{ $comment->comment }}">
            </div>
            <button class="btn btn-success m-3">edit</button>
            <a href="/user/{{auth()->user()->id}}/comments" class="btn btn-danger float-right m-3">cancel</a>
        </form>
    </div>
@endcomponent
