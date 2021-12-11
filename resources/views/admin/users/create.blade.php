@component('admin.layouts.content', ['title' => 'Create'])
    <h2 class="text-center">Create New User</h2>
    @foreach ($errors->all() as $error)
        <span class="text-danger m-1">{{ $error }}</span><br>
    @endforeach
    <div class="container mt-3">
        <form action="{{ route('admin.users.store') }}" method="post">
            @csrf
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Name">
            </div>
            <div class="form-group">
                <input type="text" name="family" class="form-control" placeholder="Family">
            </div>
            <div class="form-group">
                <input type="text" name="email" class="form-control" placeholder="E-mail">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="password">
            </div>
            <div class="form-group">
                <input type="password" name="password_confirmation" class="form-control"
                    placeholder="confirm your password">
            </div>
            <div class="form-group">
                <input type="number" name="phone_number" class="form-control" placeholder="Phone Number">
            </div>
            <div class="form-check">
                <label for="verified" class="text-info form-check-label">Verify User Email</label>
                <input type="checkbox" class="form-check-input ml-2" id="verified" name="verified">
            </div>
            <button class="btn btn-success m-3">create</button>
            <a href="/admin/users" class="btn btn-danger float-right m-3">cancel</a>
        </form>
    </div>
@endcomponent
