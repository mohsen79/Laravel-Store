@component('admin.layouts.content', ['title' => 'User Permission'])
    @slot('script')
        <script>
            $('#roles').select2({
                'placeholder': 'select your roles'
            });
            $('#permissions').select2({
                'placeholder': 'select your permissions'
            });

        </script>
    @endslot
    <h2>User : {{ $user->name }}</h2>
    <div class="container mt-3">
        <form action="{{ route('admin.user.permission.update', ['user' => $user->id]) }}" method="post">
            @csrf
            <div class="form-group">
                <select name="permissions[]" id="permissions" class="form-control" multiple>
                    @foreach (App\Models\Permission::all() as $permissions)
                        <option value="{{ $permissions->id }}"
                            {{ in_array($permissions->id, $user->permissions->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $permissions->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select name="roles" id="roles" class="form-control" multiple>
                    @foreach (App\Models\Role::all() as $roles)
                        <option value="{{ $roles->id }}"
                            {{ in_array($roles->id, $user->roles->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $roles->name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-success">Ok</button>
            <a href="/admin/users" class="btn btn-danger float-right">cancel</a>
        </form>
    </div>
@endcomponent
