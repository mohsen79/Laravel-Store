@component('admin.layouts.content', ['title' => 'Edit'])
    @slot('script')
        <script>
            document.addEventListener("DOMContentLoaded", function() {

            document.getElementById('button-image').addEventListener('click', (event) => {
            event.preventDefault();

            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
            });
            });

            // set file link
            function fmSetLink($url) {
            document.getElementById('image_label').value = $url;
            }
            // for attirubte
            let changeAttributeValues = (event, id) => {
                let valueBox = $(`select[name='attributes[${id}][value]']`);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })

                $.ajax({
                    type: 'POST',
                    url: '/admin/attribute/values',
                    data: JSON.stringify({
                        name: event.target.value
                    }),
                    success: function(res) {
                        valueBox.html(
                        `
                            <option value="" selected>select</option>
                            ${
                            res.data.map(function (item) {
                                return `<option value="${item}">${item}</option>`
                            })
                        }
                        `
                        );

                        $('.attribute-select').select2({
                            tags: true
                        });
                    }
                });
            }

            let createNewAttr = ({
                attributes,
                id
            }) => {
                return `
                        <div class="row" id="attribute-${id}">
                            <div class="col-5">
                                <div class="form-group">
                                        <label>attribute name</label>
                                        <select name="attributes[${id}][name]" onchange="changeAttributeValues(event, ${id});" class="attribute-select form-control">
                                        <option value="">select</option>
                                        ${
                                            attributes.map(function(item) {
                                                return `<option value="${item}">${item}</option>`
                                            })
                                        }
                                        </select>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                        <label>item</label>
                                        <select name="attributes[${id}][value]" class="attribute-select form-control">
                                            <option value="">select</option>
                                        </select>
                                </div>
                            </div>
                                <div class="col-2">
                                <div>
                                    <button type="button" class="btn btn-sm btn-danger" style="margin-top:30px" onclick="document.getElementById('attribute-${id}').remove()">delete</button>
                                </div>
                            </div>
                        </div>
                        `
            }

            $('#add_product_attribute').click(function() {
                let attributesSection = $('#attribute_section');
                let id = attributesSection.children().length;

                let attributes = $('#attributes').data('attributes');
                attributesSection.append(
                    createNewAttr({
                        attributes,
                        id
                    })
                );

                $('.attribute-select').select2({
                    tags: true
                });
            });
            $('.attribute-select').select2({
                tags: true
            });
        </script>
    @endslot
    <h2 class="text-center">Edit Product</h2>
    @foreach ($errors->all() as $error)
        <span class="text-danger m-1">{{ $error }}</span><br>
    @endforeach
    <div class="container mt-3">
        <div id="attributes" data-attributes="{{ json_encode(App\Models\Attribute::all()->pluck('name')) }}">
        </div>
        <form action="{{ route('admin.products.update',$product->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="form-group">
                <input type="text" name="title" class="form-control" placeholder="Title" value="{{ $product->title }}">
            </div>
            <div class="form-group">
                <input type="text" name="description" class="form-control" placeholder="Description"
                    value="{{ $product->description }}">
            </div>
            <div class="form-group">
                <input type="number" name="price" class="form-control" placeholder="Price" value="{{ $product->price }}">
            </div>
            <div class="form-group">
                <input type="number" name="inventory" class="form-control" placeholder="Inventory"
                    value="{{ $product->inventory }}">
            </div>
            <div class="form-group">
                <select name="category" id="category" class="form-control">
                    @foreach (App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}"
                            {{ in_array($category->id,$product->categories()->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
            <input type="text" name="brand" placeholder="Brand" class="form-control" value="{{$product->brand}}">
            </div>
            {{-- <div class="form-group">
                <img src="{{$product->image}}" alt="this product has not got any photo" class="m-2 rounded" style="width:300px;height:200px">
                <input type="file" class="form-control" name="image">
            </div> --}}
            <div class="form-group">
                <img src="{{$product->image}}" alt="this product has not got any photo" class="m-2 rounded" style="width:300px;height:200px">
            </div>
            <div class="input-group">
                <input type="text" id="image_label" class="form-control" name="image"
            value="{{$product->image}}">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="button" id="button-image">Select</button>
                </div>
            </div>
            <h6 class="m-2">attribute</h6>
            <hr>
            <div id="attribute_section">
                @foreach ($product->attributes as $attribute)
                <div class="row" id="attribute-{{$loop->index}}">
                    <div class="col-5">
                        <div class="form-group">
                            <label>attribute name</label>
                            <select name="attributes[{{$loop->index}}][name]" onchange="changeAttributeValues(event, {{$loop->index}});" class="attribute-select form-control">
                                <option value="">select</option>
                                @foreach (App\Models\Attribute::all() as $attr)
                                <option value="{{$attr->name}}" {{$attr->name == $attribute->name ? 'selected':''}}>{{$attr->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label>item</label>
                            <select name="attributes[{{$loop->index}}][value]" class="attribute-select form-control">
                                <option value="">select</option>
                                @foreach ($attribute->values as $value)
                                <option value="{{$value->value}}" {{$value->id === $attribute->pivot->value_id ? 'selected' :''}}>{{$value->value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div>
                            <button type="button" class="btn btn-sm btn-danger" style="margin-top:30px" onclick="document.getElementById('attribute-{{$loop->index}}').remove()">delete</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button class="btn btn-sm btn-warning" type="button" id="add_product_attribute">new
                attribute</button><br>
            <button class="btn btn-success m-3">edit</button>
            <a href="/admin/products" class="btn btn-danger float-right m-3">cancel</a>
        </form>
    </div>
@endcomponent
