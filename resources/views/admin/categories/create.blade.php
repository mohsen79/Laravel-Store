@component('admin.layouts.content', ['title' => 'Create'])
    <h2 class="text-center">Create New Category</h2>
    @foreach ($errors->all() as $error)
        <span class="text-danger m-1">{{ $error }}</span><br>
    @endforeach
    <div class="container mt-3">
        <form action="{{ route('admin.categories.store') }}" method="post">
            @csrf
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Category">
            </div>
            <button class="btn btn-success m-3">create</button>
            <a href="/admin/categories" class="btn btn-danger float-right m-3">cancel</a>
        </form>
    </div>
@endcomponent
