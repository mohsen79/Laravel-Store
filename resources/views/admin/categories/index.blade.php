@component('admin.layouts.content', ['title' => 'Products'])
    <div class="form-group">
        <a href="/" class="btn btn-outline-light float-right m-3">Home</a>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary m-3">create new Category</a>
        <form>
            <div class="form-input d-flex col-lg-8">
                <input type="text" name="search" class="form-control d-flex" placeholder="SEARCH"
                    value="{{ request('search') }}">
                <button class="btn btn-sm btn-warning"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
    <table class="table table-hover">
        <tr class="text-center">
            <th>Name</th>
            <th>functions</th>
        </tr>
        @include('admin.layouts.category',['categories'=>$categories->where('parent_id', 0)])
    </table>
@endcomponent
