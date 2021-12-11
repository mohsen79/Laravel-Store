<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <form action="{{ route('logout') }}" class="brand-link" method="post">
        @csrf
        <button class="brand-text font-weight-light btn btn-danger btn-block">Log Out
            <i class="fa fa-sign-out-alt"></i>
        </button>
    </form>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-1 pb-1 mb-1 d-flex">
            <div class="image">
                <img src="/dist/img/ac.jpg" class="img-circle" alt="User Image" style="width:100px;height:100px">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input name="search" class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
       with font-awesome or any other icon font library -->
                @canany(['admin', 'Boss'])
                    <li class="nav-item menu-open">
                        <a href="#"
                            class="nav-link {{ IsActive(['admin/users', 'admin/permissions', 'admin/roles'], 'active') }}">
                            <p>
                                <i class="fa fa-users"></i>
                                Users
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}"
                                    class="nav-link {{ IsActive('admin/users', 'active') }}">
                                    <i class="fa fa-users"></i>
                                    <p>users list</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.permissions.index') }}"
                                    class="nav-link {{ IsActive('admin/permissions', 'active') }}">
                                    <i class="fa fa-lock"></i>
                                    <p> permissions</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}"
                                    class="nav-link {{ IsActive('admin/roles', 'active') }}">
                                    <i class="fa fa-edit (alias)"></i>
                                    <p> Roles</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link {{ IsActive(['admin/products', 'admin/categories'], 'active') }}">
                            <p>
                                <i class="fa fa-shopping-cart"></i>
                                Products
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/admin/products" class="nav-link {{ IsActive('admin/products', 'active') }}">
                                    <i class="fa fa-shopping-basket"></i>
                                    <p>manage products</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.categories.index') }}"
                                    class="nav-link {{ IsActive('admin/categories', 'active') }}">
                                    <i class="fa fa-list-ul"></i>
                                    <p>categories</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @if (Route::has('admin.comments.approved'))
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link {{ IsActive(['admin/comments', 'admin/approved'], 'active') }}">
                                <p>
                                    <i class="fa fa-comments"></i>
                                    Comments
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/admin/comments"
                                        class="nav-link {{ IsActive('admin/comments', 'active') }}">
                                        <i class="fa fa-comment"></i>
                                        <p>all comments</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.comments.approved') }}"
                                        class="nav-link {{ IsActive('admin/approved', 'active') }}">
                                        <i class="fa fa-paint-brush"></i>
                                        <p>approved</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if (Route::has('discounts.index'))
                        <li class="nav-item">
                            <a href="{{ route('discounts.index') }}"
                                class="nav-link {{ IsActive('admin/discounts', 'active') }}">
                                <i class="fa fa-percent"></i>
                                <p>discounts</p>
                            </a>
                        </li>
                    @endif
                    @if (Route::has('main.index'))
                        <li class="nav-item">
                            <a href="{{ route('main.index') }}"
                                class="nav-link {{ IsActive('admin/main', 'active') }}">
                                <i class="fa fa-cog"></i>
                                <p>Modules</p>
                            </a>
                        </li>
                    @endif
                    @if (Route::has('admin.purchased'))
                        <li class="nav-item">
                            <a href="{{ route('admin.purchased') }}"
                                class="nav-link {{ IsActive('admin/purchased', 'active') }}">
                                <i class="fa fa-cart-arrow-down"></i>
                                <p>purchased</p>
                            </a>
                        </li>
                    @endif
                    @if (Route::has('actions'))
                        <li class="nav-item">
                            <a href="{{ route('actions') }}"
                                class="nav-link {{ IsActive('action', 'active') }}">
                                <i class="fa fa-history"></i>
                                <p>actions</p>
                            </a>
                        </li>
                    @endif
                @endcanany
                <li class="nav-item">
                    <a href="/user/{{ auth()->user()->id }}/comments"
                        class="nav-link {{ IsActive('user/{user}/comments', 'active') }}">
                        <i class="fa fa-comment"></i>
                        <p>Your Comments</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/user/{{ auth()->user()->id }}/purchased"
                        class="nav-link {{ IsActive('user/{user}/purchased', 'active') }}">
                        <i class="fa fa-cart-arrow-down"></i>
                        <p>Your Purchased</p>
                    </a>
                </li>

            </ul>
            </li>

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
