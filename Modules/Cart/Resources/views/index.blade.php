@extends('layouts.app')
@section('script')
    <script>
        function QuantityChange(event, id, cartName = null) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })

            //
            $.ajax({
                type: 'POST',
                url: 'cart/quantity/update',
                data: JSON.stringify({
                    id: id,
                    quantity: event.target.value,
                    // cart : cartName,
                    _method: 'patch'
                }),
                success: function(res) {
                    location.reload();
                }
            });
        }

    </script>
@endsection
@section('content')
    <div class="container">
        <table class="table table-hover text-light">
            <tbody>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
                @foreach (Cart::all() as $cart)
                    <tr>
                        <td>{{ $cart['Product']->title }}</td>
                        <td>
                            @if (!$cart['discount_percent'])
                                {{ $cart['Product']->price }}
                            @else
                                <del class="text-danger">{{ $cart['Product']->price }}</del>
                                {{ $cart['Product']->price - $cart['Product']->price * $cart['discount_percent'] }}
                            @endif
                        </td>
                        <td>
                            <select class="form-control" onchange="QuantityChange(event,'{{ $cart['id'] }}')">
                                @foreach (range(1, $cart['Product']->inventory) as $quantity)
                                    <option {{ $quantity == $cart['quantity'] ? 'selected' : '' }}>
                                        {{ $quantity }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            @php
                                $total_price = Cart::all()->sum(function ($cart) {
                                    return $cart['Product']->price * $cart['quantity'];
                                });
                            @endphp
                            @if (!$cart['discount_percent'])
                                {{ $cart['Product']->price * $cart['quantity'] }}
                            @else
                                <del class="text-danger">{{ $cart['Product']->price * $cart['quantity'] }}</del>
                                {{ ($cart['Product']->price - $cart['Product']->price * $cart['discount_percent']) * $cart['quantity'] }}
                            @endif
                        </td>
                        <td>
                            <form action="cart/remove/{{ $cart['id'] }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger">delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if (Route::has('discounts.index'))
            @if ($discount = Cart::getdiscount())
                <form action="admin/discount/delete" method="post" id="discount-delete">
                    @csrf
                    @method('delete')
                </form>
                <span>acitve discount : <span class="text-info">{{ $discount->code }}</span> with <span
                        class="text-info">{{ $discount->percent }}%</span></span>
                <a onclick="event.preventDefault();document.getElementById('discount-delete').submit()"
                    class="badge badge-danger btn">delete</a>
                <form action="admin/discount/check" method="post">
                    @csrf
                    <div class="form-group d-flex">
                        <input name="code" type="text"
                            class="col-lg-3 form-control mb-2 @error('discount')is-invalid @enderror"
                            placeholder="Discount">
                        <button class="btn btn-outline-dark ml-1" style="height:40px">Check</button>
                        @error('code')
                            <br><span class="text-danger m-2">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            @else
                <form action="admin/discount/check" method="post">
                    @csrf
                    <div class="form-group d-flex">
                        <input name="code" type="text"
                            class="col-lg-3 form-control mb-2 @error('discount')is-invalid @enderror"
                            placeholder="Discount">
                        <button class="btn btn-outline-dark ml-1" style="height:40px">Check</button>
                        @error('code')
                            <br><span class="text-danger m-2">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            @endif
        @endif
        <form action="cart/pay/{{ $total_price }}" method="post">
            @csrf
            <a href="/" class="btn btn-warning">BACK</a>
            <button class="btn btn-primary float-right">PAY</button>
        </form>
    </div>
@endsection
