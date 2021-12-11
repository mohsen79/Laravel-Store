@component('admin.layouts.content', ['title' => 'Comments'])
    <a href="/" class="btn btn-outline-light float-right m-3">Home</a>
    <table class="table table-hover">
        <tbody>
            <tr>
                <th>User</th>
                <th>Comment</th>
                <th>Date</th>
                <th class="text-center">functions</th>
                <th></th>
            </tr>
            @foreach ($comments as $comment)
                <tr>
                    <td>{{ $comment->user->name }}</td>
                    <td>{{ $comment->comment }}</td>
                    <td>{{ $comment->updated_at }}</td>
                    <td>
                        <form action="{{ route('admin.comments.update', $comment->id) }}" method="post">
                            @csrf
                            @method('patch')
                            <button class="btn btn-outline-success">approve</button>
                        </form>
                    </td>
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
