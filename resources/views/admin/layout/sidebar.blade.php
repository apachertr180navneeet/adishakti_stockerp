<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: 0.8;" />
        <span class="brand-text font-weight-light">Adishakti Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image" />
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ $user_data->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Master
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.unit.list') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Unit Master
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.item.list') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Item Master
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.color.list') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Color Master
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.machine.list') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Machine Master
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.batch.list') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Batch Master
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.vendor.list') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Vendor Master
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.overhead.list') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Overhead Master
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.company.list') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Company Master
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.user.list') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    User Master
                                </p>
                            </a>
                        </li>
                        {{--  <li class="nav-item">
                            <a href="{{ route('admin.customer.list') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Customer Master
                                </p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.condition.list') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Chemical Master
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Process
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.color.stock.in') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Color Stock in
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.chemical.stock.in') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Chemical Stock in
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.stock.in.list') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Purchase Order
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.stock.dispatch.list') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Stock Shifting
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.stock.material.list') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Stock Material
                                </p>
                            </a>
                        </li>
                        {{--  <li class="nav-item">
                            <a href="{{ route('admin.stock.challan.list') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Order Management
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.order.dispatch.list') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Order Dispatch List
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.credit.note.list') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Credit Note
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.debit.note.list') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Debit Note
                                </p>
                            </a>
                        </li>  --}}
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Report
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.total.stock.report') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Current Stock Report
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.color.report') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Color Report
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.chemical.report') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Chemical Report
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.machine.report') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Machine Report
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p class="text">Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
