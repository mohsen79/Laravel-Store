@component('admin.layouts.content', ['title' => 'New Gallery'])
    @slot('script')
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                document.getElementById('button-image').addEventListener('click', (event) => {
                    event.preventDefault();

                    window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
                });
            });

            function fmSetLink($url) {
                document.getElementById('image_label').value = $url;
            }

        </script>
    @endslot
    <br>
    <br>
    <div class="container col-lg-10">
        <h2 class="text-warning">Product : {{ $product->title }}</h2>
        <form action="{{ route('admin.product.gallery.update', ['product' => $product->id, 'gallery' => $gallery]) }}"
            method="POST">
            @csrf
            @method('patch')
            <div class="form-group">
                <input type="text" class="form-control" name="alt" placeholder="Alt" value="{{ $gallery->alt }}">
            </div>
            <div class="input-group">
                <input type="text" id="image_label" class="form-control" name="image" value="{{ $gallery->image }}">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="button" id="button-image">Select</button>
                </div>
            </div>
            <button class="btn btn-success float-left m-3">edit</button>
            <a href="/admin/product/{{ $product->id }}/gallery" class="btn-danger btn float-right m-3">cancel</a>
        </form>
    </div>
@endcomponent
