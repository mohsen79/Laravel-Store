@component('admin.layouts.content', ['title' => 'Comments'])
    <a href="/" class="btn btn-outline-light float-right m-3">Home</a>
    <table class="table table-hover">
        <tbody>
            <tr>
                <th>approved comment</th>
                <th>product</th>
                <th>user</th>
                <th></th>
            </tr>
            @foreach ($comments as $comment)
                <tr>
                    <td>{{ $comment->comment }}</td>
                    <td>{{ $comment->commentable->title }}</td>
                    <td>{{ App\Models\User::find($comment->user_id)->name }}</td>
                    <td>
                        <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-outline-danger">delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endcomponent
