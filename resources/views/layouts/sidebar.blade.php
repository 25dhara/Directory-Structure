<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('dist/img/logo.jpg') }}" class="brand-image img-circle elevation-5" alt="Logo">

        <span class="brand-text font-weight-light">Directory</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link {{ Request::is('users') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p> User </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('permission.index') }}"
                        class="nav-link {{ Request::is('permission') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Permission</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('files.index') }}" class="nav-link {{ Request::is('files') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p> Files </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('folders.index') }}"
                        class="nav-link {{ Request::is('folders') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-folder"></i>
                        <p> Folder </p>
                    </a>
                </li>



            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
