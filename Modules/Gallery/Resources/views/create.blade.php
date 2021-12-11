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
        <form action="{{ route('admin.product.gallery.store', $product->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control" name="alt" placeholder="Alt">
            </div>
            <div class="input-group">
                <input type="text" id="image_label" class="form-control" name="image">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="button" id="button-image">Select</button>
                </div>
            </div>
            <button class="btn btn-success float-left m-3">create</button>
            <a href="/admin/product/{{ $product->id }}/gallery" class="btn-danger btn float-right m-3">cancel</a>
        </form>
    </div>
@endcomponent
