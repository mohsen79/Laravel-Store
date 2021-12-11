@component('admin.layouts.content', ['title' => 'Products'])
    <div class="form-group">
        <a href="/" class="btn btn-outline-light float-right m-3">Home</a>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary m-3">create new product</a>
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
            <th>Title</th>
            <th>Description</th>
            <th>price</th>
            <th>inventory</th>
            {{-- <th>view count</th> --}}
            <th>image</th>
            <th class="text-center">functions</th>
        </tr>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->title }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->inventory }}</td>
                <td>{{ $product->image }}</td>
                <form action="{{ route('admin.products.destroy', ['product' => $product->id]) }}" method="post">
                    @csrf
                    @method('delete')
                    <td><a href="/admin/products/{{ $product->id }}/edit" class="btn btn-outline-warning">edit</a>
                        <button class="btn btn-outline-danger ml-1">delete</button>
                        @if (in_array('Gallery', Module::getByStatus(1)))
                            <a href="/admin/product/{{ $product->id }}/gallery" class="btn btn-info ml-1">gallery</a>
                        @endif
                    </td>
                </form>
            </tr>
        @endforeach
    </table>
@endcomponent
