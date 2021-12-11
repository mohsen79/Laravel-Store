@component('admin.layouts.content', ['title' => 'Discounts'])
    <div class="form-group">
        <a href="/" class="btn btn-outline-light float-right m-3">Home</a>
        <a href="{{ route('discounts.create') }}" class="btn btn-primary m-3">create new Discount</a>
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
            <th>Percent</th>
            <th>Expire</th>
        </tr>
        @foreach ($discounts as $discount)
            <tr>
                <td>{{ $discount->code }}</td>
                <td>{{ $discount->percent }}</td>
                <td>{{ $discount->expire }}</td>
                <form action="{{ route('discounts.destroy', ['discount' => $discount->id]) }}" method="post">
                    @csrf
                    @method('delete')
                    <td><a href="discounts/{{ $discount->id }}/edit" class="btn btn-outline-warning">edit</a>
                        <button class="btn btn-outline-danger ml-2">delete</button>
                    </td>
                </form>
            </tr>
        @endforeach
    </table>
@endcomponent
