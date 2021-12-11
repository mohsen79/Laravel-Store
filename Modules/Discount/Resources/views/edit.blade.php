@component('admin.layouts.content', ['title' => 'Edit'])
    @section('script')
        <script>
            $('#categories').select2({
                'placeholder': 'select categories'
            });
            $('#products').select2({
                'placeholder': 'select products'
            });
            $('#users').select2({
                'placeholder': 'select users'
            });

        </script>
    @endsection
    <h2 class="text-center">Edit Discount</h2>
    @foreach ($errors->all() as $error)
        <span class="text-danger m-1">{{ $error }}</span><br>
    @endforeach
    <div class="container mt-3">
        <form action="{{ route('discounts.update', ['discount' => $discount->id]) }}" method="post">
            @csrf
            @method('patch')
            <div class="form-group">
                <input type="text" name="code" class="form-control" placeholder="Code" value="{{ $discount->code }}">
            </div>
            <div class="form-group">
                <input type="text" name="percent" class="form-control" placeholder="Percent"
                    value="{{ $discount->percent }}">
            </div>
            <div class="form-group">
                <input type="datetime-local" name="expire" class="form-control"
                    value="{{ \Carbon\Carbon::parse($discount->expire)->format('Y-m-d\TH:i:s') }}">
            </div>
            <div class="form-group">
                <select name="users[]" id="users" class="form-control" multiple>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"
                            {{ in_array($user->id, $discount->users->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select name="products[]" id="products" class="form-control" multiple>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}"
                            {{ in_array($product->id, $discount->products->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $product->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select name="categories[]" id="categories" class="form-control" multiple>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ in_array($category->id, $discount->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-success m-3">Edit</button>
            <a href="/admin/discounts" class="btn btn-danger float-right m-3">cancel</a>
        </form>
    </div>
@endcomponent
