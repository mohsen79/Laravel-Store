@component('admin.layouts.content', ['title' => 'Functions'])
    <hr style="color:red:height:10px">
    <table class="table table-hover">
        <tr>
            <th>Admin Name</th>
            <th>Object Name</th>
            {{-- <th>Object Type</th> --}}
            <th>Function</th>
            <th>Date</th>
        </tr>
        @foreach ($actions as $action)
            <tr>
                <td>{{ $action->user->name }}</td>
                <td>{{ $action->object_name }}</td>
                {{-- <td>{{ $action->actionable }}</td> --}}
                <td>{{ $action->action }}</td>
                <td>{{ $action->date }}</td>
            </tr>
        @endforeach
    </table>
@endcomponent
