@component('admin.layouts.content', ['title' => 'Panel'])
    <div class="form-group">
        <a href="/" class="btn btn-outline-light float-right m-3">Home</a>
        @canany(['create', 'admin', 'Boss'])
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary m-3">create new user</a>
        @endcanany
        <a href="{{ request()->fullUrlWithQuery(['admins' => 1]) }}" class="btn btn-secondary">Admins
            <i class="fas fa-star" style="color:yellow"></i></a>
        @if (in_array('Token', Module::getByStatus(1)))
            <a href="/user/twofactauth" class="btn btn-dark text-light ml-2">Two Factor Authenticat</a>
        @endif
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
            <th>Family</th>
            <th>Email</th>
            <th>Phone number</th>
            <th>Verified Email</th>
            <td>Two Factor Authenticat</td>
            <th class="text-center">functions</th>
        </tr>
        @foreach ($users as $user)
            <tr>
                <td>
                    <i class="{{ $user->admin == 1 ? 'fas fa-star' : '' }}" style=" color:yellow"></i>
                    {{ $user->name }}
                </td>
                <td>{{ $user->family }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone_number ?? 'has not enterd' }}</td>
                @if ($user->email_verified_at)
                    <td><span class="badge badge-success">verfied</span></td>
                @else
                    <td><span class="badge badge-danger">not verfied</span></td>
                @endif
                <td class="text-center">{{ strtoupper($user->two_fact_auth) }}</td>
                <form action="{{ route('admin.users.destroy', ['user' => $user->id]) }}" method="post">
                    @csrf
                    @method('delete')
                    <td>
                        @canany(['admin', 'edit','Boss'])
                            <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-outline-warning">edit</a>
                        @endcanany
                        @can('Boss')
                            <button class="btn btn-outline-danger ml-2">delete</button>
                            <a href="/admin/user/{{ $user->id }}/permissions" class="btn btn-info m-3">Permissions</a>
                        @endcan
                    </td>
                </form>
            </tr>
        @endforeach
    </table>
@endcomponent
