@component('admin.layouts.content', ['title' => 'Panel'])
    <div class="form-group">
        <a href="/" class="btn btn-outline-light float-right m-3">Home</a>
        @if (in_array('Token', Module::getByStatus(1)))
            <a href="/user/twofactauth" class="btn btn-dark text-light m-2">Two Factor Authenticat</a>
        @endif
    </div>
    <table class="table table-hover">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone number</th>
            <th>Verified Email</th>
            <td>Two Factor Authenticat</td>
            <th class="text-center">functions</th>
        </tr>
        @php
            $user = auth()->user();
        @endphp
        <tr>
            <td>
                {{ $user->name }}
            </td>
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
                    <a href="{{ $user->id }}/edit" class="btn btn-outline-warning">edit</a>

                </td>
            </form>
        </tr>
    </table>
@endcomponent
