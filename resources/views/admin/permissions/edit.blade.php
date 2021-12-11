@component('admin.layouts.content', ['title' => 'Edit'])
    <h2 class="text-center">Edit New Permission</h2>
    @foreach ($errors->all() as $error)
        <span class="text-danger m-1">{{ $error }}</span><br>
    @endforeach
    <div class="container mt-3">
        <form action="{{ route('admin.permissions.update', ['permission' => $permission->id]) }}" method="post">
            @csrf
            @method('patch')
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $permission->name }}">
            </div>
            <div class="form-group">
                <input type="text" name="label" class="form-control" placeholder="Label" value="{{ $permission->label }}">
            </div>
            <button class="btn btn-success m-3">Edit</button>
            <a href="/admin/permissions" class="btn btn-danger float-right m-3">cancel</a>
        </form>
    </div>
@endcomponent
