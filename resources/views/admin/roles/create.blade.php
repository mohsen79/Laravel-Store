@component('admin.layouts.content', ['title' => 'Create'])
    @slot('script')
        <script>
            $('#roles').select2({
                'placeholder': 'select your permissions'
            });

        </script>
    @endslot
    <h2 class="text-center">Create New Role</h2>
    @foreach ($errors->all() as $error)
        <span class="text-danger m-1">{{ $error }}</span><br>
    @endforeach
    <div class="container mt-3">
        <form action="{{ route('admin.roles.store') }}" method="post">
            @csrf
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Name">
            </div>
            <div class="form-group">
                <input type="text" name="label" class="form-control" placeholder="Label">
            </div>
            <div class="form-group">
                <select name="permissions[]" class="form-control" id="roles" multiple>
                    @foreach (App\Models\Permission::all() as $permissions)
                        <option value="{{ $permissions->id }}">{{ $permissions->name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-success m-3">create</button>
            <a href="/admin/roles" class="btn btn-danger float-right m-3">cancel</a>
        </form>
    </div>
@endcomponent
