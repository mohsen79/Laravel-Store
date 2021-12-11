@component('admin.layouts.content', ['title' => 'Edit'])
    <h2 class="text-center">Edit User</h2>
    @foreach ($errors->all() as $error)
        <span class="text-danger m-1">{{ $error }}</span><br>
    @endforeach
    <div class="container mt-3">
        <form action="{{ route('admin.users.update', ['user' => $user]) }}" method="post">
            @csrf
            @method('put')
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $user->name }}">
            </div>
            <div class="form-group">
                <input type="text" name="family" class="form-control" placeholder="Family" value="{{ $user->family }}">
            </div>
            <div class="form-group">
                <input type="text" name="email" class="form-control" placeholder="E-mail" value="{{ $user->email }}">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="password">
            </div>
            <div class="form-group">
                <input type="password" name="password_confirmation" class="form-control"
                    placeholder="confirm your password">
            </div>
            <div class="form-group">
                <input type="number" name="phone_number" class="form-control" placeholder="Phone Number"
                    value="{{ $user->phone_number }}">
            </div>
            <div class="form-check">
                <label for="verified" class="text-info form-check-label">Verify User Email</label>
                <input type="checkbox" class="form-check-input ml-2" id="verified" name="verified"
                    {{ $user->hasVerifiedEmail() ? 'checked' : '' }}>
            </div>
            <button class="btn btn-success m-3">edit</button>
            <a href="/admin/users" class="btn btn-danger float-right m-3">cancel</a>
        </form>
    </div>
@endcomponent
