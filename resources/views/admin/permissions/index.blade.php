@component('admin.layouts.content', ['title' => 'Permissions'])
    <div class="form-group">
        <a href="/" class="btn btn-outline-light float-right m-3">Home</a>
        <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary m-3">create new permission</a>
        <form>
            <div class="form-input d-flex col-lg-8">
                <input type="text" name="search" class="form-control d-flex" placeholder="SEARCH"
                    value="{{ request('search') }}">
                <button class="btn btn-sm btn-warning"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
    <table class="table table-hover">
        <tr>
            <th>Name</th>
            <th>Label</th>
            <th>functions</th>
        </tr>
        @foreach ($permissions as $permission)
            <tr>
                <td>{{ $permission->name }}</td>
                <td>{{ $permission->label }}</td>
                <form action="{{ route('admin.permissions.destroy', ['permission' => $permission->id]) }}" method="post">
                    @csrf
                    @method('delete')
                    <td><a href="/admin/permissions/{{ $permission->id }}/edit" class="btn btn-outline-warning">edit</a>
                        <button class="btn btn-outline-danger ml-2">delete</button>
                    </td>
                </form>
            </tr>
        @endforeach
    </table>
@endcomponent
