@component('admin.layouts.content', ['title' => 'Create'])
    <h2 class="text-center">Create New Permission</h2>
    @foreach ($errors->all() as $error)
        <span class="text-danger m-1">{{ $error }}</span><br>
    @endforeach
    <div class="container mt-3">
        <form action="{{ route('admin.permissions.store') }}" method="post">
            @csrf
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Name">
            </div>
            <div class="form-group">
                <input type="text" name="label" class="form-control" placeholder="Label">
            </div>
            <button class="btn btn-success m-3">create</button>
            <a href="/admin/permissions" class="btn btn-danger float-right m-3">cancel</a>
        </form>
    </div>
@endcomponent
