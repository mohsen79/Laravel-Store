@component('admin.layouts.content', ['title' => 'Purchased'])
    @section('script')
        <script>
            function StatusUpdate(event, cart) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })

                //
                $.ajax({
                    type: 'POST',
                    url: 'purchased/status',
                    data: JSON.stringify({
                        cart: cart,
                        status: event.target.value,
                        _method: 'patch'
                    }),
                    success: function(res) {
                        // console.log('droud');
                        location.reload();
                    }
                });
            }

        </script>
    @endsection
    <a href="/" class="btn btn-outline-light float-right m-3">Home</a>
    <h2>In Process Orders</h2>
    <table class="table table-hover">
        <tr>
            <th>Product Name</th>
            <th>user Name</th>
            <th>Email</th>
            <th>Phone number</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Date</th>
            <th class="text-center">functions</th>
        </tr>
        @foreach ($carts->whereNotIn('status', 'sent') as $cart)
            <tr>
                <td>{{ $cart->name }}</td>
                <td>{{ $cart->user->name }}</td>
                <td>{{ $cart->user->email }}</td>
                <td>{{ $cart->user->phone_number ?? 'has not enterd' }}</td>
                <td>{{ $cart->quantity }}</td>
                <td>{{ $cart->price }}</td>
                <td>{{ $cart->total_price }}</td>
                <td>
                    @php
                        $list = ['order', 'deliverd', 'sent'];
                    @endphp
                    <select name="status" class="form-control" onchange="StatusUpdate(event,'{{ $cart }}')">
                        @foreach ($list as $item)
                            <option value="{{ $item }}" {{ $item == $cart->status ? 'selected' : '' }}>
                                {{ $item }}</option>
                        @endforeach
                    </select>
                </td>
                <td>{{ $cart->date }}</td>
                <form action="{{ route('admin.purchased.delete', $cart->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <td>
                        @can('Boss')
                            <button class="btn btn-outline-danger ml-2">delete</button>
                        @endcan
                    </td>
                </form>
            </tr>
        @endforeach
    </table>
    <hr style="height:5px;background:yellow">
    <h2>Sent Orders</h2>
    <table class="table table-hover">
        <tr>
            <th>Product Name</th>
            <th>user Name</th>
            <th>Email</th>
            <th>Phone number</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Date</th>
            <th class="text-center">functions</th>
        </tr>
        @foreach ($carts->where('status', 'sent') as $cart)
            <tr>
                <td>{{ $cart->name }}</td>
                <td>{{ $cart->user->name }}</td>
                <td>{{ $cart->user->email }}</td>
                <td>{{ $cart->user->phone_number ?? 'has not enterd' }}</td>
                <td>{{ $cart->quantity }}</td>
                <td>{{ $cart->price }}</td>
                <td>{{ $cart->total_price }}</td>
                <td>{{ $cart->status }}</td>
                <td>{{ $cart->date }}</td>
                <form action="{{ route('admin.purchased.delete', $cart->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <td>
                        @can('Boss')
                            <button class="btn btn-outline-danger ml-2">delete</button>
                        @endcan
                    </td>
                </form>
            </tr>
        @endforeach
    </table>
@endcomponent
