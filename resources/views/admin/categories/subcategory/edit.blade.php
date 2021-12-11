@component('admin.layouts.content', ['title' => 'Create'])
    <h2 class="text-center">Edit SubCategory</h2>
    @foreach ($errors->all() as $error)
        <span class="text-danger m-1">{{ $error }}</span><br>
    @endforeach
    <div class="container mt-3">
        <form action="{{ route('admin.subcategory.update', $category->id) }}" method="post">
            @csrf
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Category" value="{{ $category->name }}">
            </div>
            <div class="form-group">
                <select name="parent_id" id="parent_id" class="form-control">
                    @foreach (App\Models\Category::all()->where('parent_id', 0) as $cats)
                        <option value="{{ $cats->id }}"
                            {{ in_array($cats->id, $category->pluck('parent_id')->toArray()) ? 'selected' : '' }}>
                            {{ $cats->name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-success m-3">update</button>
            <a href="/admin/categories" class="btn btn-danger float-right m-3">cancel</a>
        </form>
    </div>
@endcomponent
