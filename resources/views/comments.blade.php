@component('admin.layouts.content', ['title' => 'Comments'])
    <div class="form-group">
        <a href="/" class="btn btn-outline-light float-right m-3">Home</a>
    </div>
    <table class="table table-hover">
        <tr>
            <th>Comment</th>
            <th>Status</th>
            <th>functions</th>
        </tr>
        @foreach ($comments as $comment)
            <tr>
                <td>
                    {{ $comment->comment }}
                </td>
                <td>
                    @if ($comment->approved)
                        <div class="badge badge-success">confirmed</div>
                    @else
                        <div class="badge badge-danger">not confirmed</div>
                    @endif
                </td>
                <form action="comments/{{ $comment->id }}/delete" method="post">
                    @csrf
                    @method('delete')
                    <td>
                        @if (!$comment->approved)
                            <a href="comments/{{ $comment->id }}/edit" class="btn btn-outline-warning">edit</a>
                        @endif
                        <button class="btn btn-outline-danger">delete</button>
                    </td>
                </form>
            </tr>
        @endforeach

    </table>
@endcomponent
