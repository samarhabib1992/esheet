<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-light sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center" href="{{ url('index.html') }}">
        <img src="{{ asset('admin/img/logo.png') }}" width="80%" alt="">
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Items -->
    <li class="nav-item bold active">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-th-large"></i>
            <span>Dashboard</span>
        </a>
    </li>
    @can('user.view')
        <li class="nav-item bold">
            <a class="nav-link" href="{{ route('admin.users.listing') }}">
                <i class="fas fa-users"></i>
                <span>Users</span>
            </a>
        </li>
    @endcan
    @can('role.view')
        <li class="nav-item bold">
            <a class="nav-link" href="{{ route('admin.roles.listing') }}">
                <i class="fas fa-users"></i>
                <span>Roles</span>
            </a>
        </li>
    @endcan
    @canany(['product.view', 'productType.view', 'productCategory.view', 'productTopic.view'])
        <li class="nav-item bold">
            <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" data-target="#product-menu" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-boxes"></i>
                <span>Product Management</span>
            </a>
            <div id="product-menu" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @can('productType.view')
                        <a class="collapse-item" href="{{ route('admin.products.types.listing') }}">Product Types</a>
                    @endcan
                    @can('productCategory.view')
                        <a class="collapse-item" href="{{ route('admin.categories.listing') }}">Categories</a>
                    @endcan
                    @can('productTopic.view')
                        <a class="collapse-item" href="{{ route('admin.topics.listing') }}">Topics</a>
                    @endcan
                    @can('product.view')
                        <a class="collapse-item" href="{{ route('admin.products.listing') }}">Products</a>
                    @endcan
                </div>
            </div>
        </li>
    @endcanany
    @can('customer.view')
        <li class="nav-item bold">
            <a class="nav-link" href="#">
                <i class="fas fa-user-friends"></i>
                <span>Customers</span>
            </a>
        </li>
    @endcan
    @can('sale.view')
        <li class="nav-item bold">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-chart-line"></i>
                <span>Sales</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ url('Orders.html') }}">Orders</a>
                    <a class="collapse-item" href="{{ url('Payments.html') }}">Payments</a>
                    <a class="collapse-item" href="{{ url('Invoices.html') }}">Invoices</a>
                </div>
            </div>
        </li>
    @endcan
    @can('report.view')
        <li class="nav-item bold">
            <a class="nav-link" href="{{ url('Reporting.html') }}">
                <i class="fas fa-chart-area"></i>
                <span>Reporting</span>
            </a>
        </li>
    @endcan
    @canany(['blog.view','blogcategory.view'])
        <li class="nav-item bold">
            <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" data-target="#blog-menu" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-blog"></i>
                <span>Blog Management</span>
            </a>
            <div id="blog-menu" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @can('blog.view')
                        <a class="collapse-item" href="{{ route('admin.blog.listing') }}">Blog</a>
                    @endcan
                    @can('blogcategory.view')
                        <a class="collapse-item" href="{{ route('admin.blogcategories.listing') }}">Blog Categories</a>
                    @endcan
                </div>
            </div>
        </li>
    @endcanany
    <li class="nav-item bold">
        <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" data-target="#setting-menu" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-cogs"></i>
            <span>Setting</span>
        </a>
        <div id="setting-menu" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('setting.view')
                    <a class="collapse-item" href="{{ route('admin.setting.index') }}">General Setting</a>
                @endcan
                 <a class="collapse-item" href="{{ route('admin.users.profile') }}">Profile Setting</a>
            </div>
        </div>
    </li>
    <li class="mt-auto mb-4">
        <a class="btn btn-primary w-100 bold" href="{{ route('admin.logout') }}">
            <span><i class="fas fa-sign-out-alt"></i> Logout</span>
        </a>
    </li>
    
</ul>
<!-- End of Sidebar -->
