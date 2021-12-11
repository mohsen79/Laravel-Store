@component('admin.layouts.content', ['title' => 'Gallery'])
    <a href="gallery/create" class="btn btn-primary m-3">Add New Picture</a>
    <div class="row">
        @foreach ($product->gallery as $pro)
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ $pro->alt }}</h3>
                    </div>
                    <div class="card-body">
                        <a href="{{ url($pro->image) }}" target="_blank"><img style="width:500px;height:400px"
                                src="{{ $pro->image }}" class="card-img-top"></a>
                        <form
                            action="{{ route('admin.product.gallery.destroy', ['product' => $product->id, 'gallery' => $pro->id]) }}"
                            method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger float-left mt-2">delete</button>
                        </form>
                        <a href="{{ route('admin.product.gallery.edit', ['product' => $product->id, 'gallery' => $pro->id]) }}"
                            class="btn btn-warning float-right mt-2">edit</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endcomponent
