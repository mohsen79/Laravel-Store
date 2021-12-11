@component('admin.layouts.content', ['title' => 'Edit'])
    <h2 class="text-center">Edit category</h2>
    @foreach ($errors->all() as $error)
        <span class="text-danger m-1">{{ $error }}</span><br>
    @endforeach
    <div class="container mt-3">
        <form action="{{ route('admin.categories.update', ['category' => $category->id]) }}" method="post">
            @csrf
            @method('patch')
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $category->name }}">
            </div>
            <button class="btn btn-success m-3">Edit</button>
            <a href="/admin/categories" class="btn btn-danger float-right m-3">cancel</a>
        </form>
    </div>
@endcomponent
