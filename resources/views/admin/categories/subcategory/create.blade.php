@component('admin.layouts.content', ['title' => 'Create'])
    <h2 class="text-center">Create New SubCategory</h2>
    @foreach ($errors->all() as $error)
        <span class="text-danger m-1">{{ $error }}</span><br>
    @endforeach
    <div class="container mt-3">
        <form action="{{ route('admin.subcategory.store', ['category' => $category->id]) }}" method="post">
            @csrf
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="SubCategory">
            </div>
            <button class="btn btn-success m-3">create</button>
            <a href="/admin/categories" class="btn btn-danger float-right m-3">cancel</a>
        </form>
    </div>
@endcomponent
