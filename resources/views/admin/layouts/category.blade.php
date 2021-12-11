@foreach ($categories as $category)
    <tr class="text-center">
        <td>{{ $category->name }}</td>
        <td>
            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="post">
                @csrf
                @method('delete')
                @if ($category->parent_id == 0)
                    <a href="categories/{{ $category->id }}/edit" class="btn btn-outline-warning">edit</a>
                @else
                    <a href="subcategory/{{ $category->id }}/edit" class="btn btn-outline-warning">edit</a>
                @endif
                <button class="btn btn-outline-danger ml-2">delete</button>
                @if ($category->parent_id == 0)
                    <a href="subcategory/{{ $category->id }}" class="btn btn-outline-info ml-5">
                        register subcategory
                    </a>
                @endif
            </form>
        </td>
        <td>
            @if ($category->parent_id == 0 && $category->child->count())
                <div class="card" style="width:350px">
                    <button type="button" class="btn btn-secondary" data-toggle="collapse"
                        data-target="#{{ $category->name }}">subcategoris <i class=" fa fa-angle-down"></i></button>
                    <div id="{{ $category->name }}" class="collapse m-3">
                        <table class="table">
                            @if ($category->child->count())
                                @include('admin.layouts.category',['categories'=>$category->child])
                            @endif
                        </table>
                    </div>
                </div>
            @endif
        </td>
    </tr>
@endforeach
