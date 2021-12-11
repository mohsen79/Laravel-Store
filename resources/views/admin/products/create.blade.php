@component('admin.layouts.content', ['title' => 'Create'])
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

            //for attributes
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
                    url: '/admin/attribute/value',
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

        </script>
    @endslot
    <h2 class="text-center">Create New Product</h2>
    @foreach ($errors->all() as $error)
        <span class="text-danger m-1">{{ $error }}</span><br>
    @endforeach
    <div class="container mt-3">
        <div id="attributes" data-attributes="{{ json_encode(App\Models\Attribute::all()->pluck('name')) }}">
        </div>
        <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="text" name="title" class="form-control" placeholder="Title">
            </div>
            <div class="form-group">
                <input type="text" name="description" class="form-control" placeholder="Description">
            </div>
            <div class="form-group">
                <input type="number" name="price" class="form-control" placeholder="Price">
            </div>
            <div class="form-group">
                <input type="number" name="inventory" class="form-control" placeholder="Inventory">
            </div>
            <div class="form-group">
                <select name="category" id="category" class="form-control">
                    @foreach (App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <input type="text" name="brand" placeholder="Brand" class="form-control">
            </div>
            {{-- <div class="form-group">
                <input type="file" class="form-control" name="image">
            </div> --}}
            <div class="input-group">
                <input type="text" id="image_label" class="form-control" name="image">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="button" id="button-image">Select</button>
                </div>
            </div>
            <h4>Attribute</h4>
            <div id="attribute_section">
            </div>
            <button class="btn btn-sm btn-warning" type="button" id="add_product_attribute">new
                attribute</button><br>
            <button class="btn btn-success m-3">create</button>
            <a href="/admin/products" class="btn btn-danger float-right m-3">cancel</a>
        </form>
    </div>
@endcomponent
