@component('admin.layouts.content', ['title' => 'Roles'])
    <div class="form-group">
        <a href="/" class="btn btn-outline-light float-right m-3">Home</a>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary m-3">create new Roles</a>
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
        @foreach ($roles as $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td>{{ $role->label }}</td>
                <form action="{{ route('admin.roles.destroy', ['role' => $role->id]) }}" method="post">
                    @csrf
                    @method('delete')
                    <td><a href="/admin/roles/{{ $role->id }}/edit" class="btn btn-outline-warning">edit</a>
                        <button class="btn btn-outline-danger ml-2">delete</button>
                    </td>
                </form>
            </tr>
        @endforeach
    </table>
@endcomponent
