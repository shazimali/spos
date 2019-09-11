<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav slimscrollsidebar">
        <div class="sidebar-head">
            <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3> </div>
        <div class="user-profile">

        </div>
        <ul class="nav" id="side-menu">
            <li> <a href="{{url('/dashboard')}}" class="waves-effect"><i class="mdi  mdi-av-timer fa-fw"></i><span class="hide-menu">Dashboard</span></a> </li>
            <li class="devider"></li>
            <li> <a href="#" class="waves-effect"><i class="mdi mdi-cart-outline fa-fw"></i> <span class="hide-menu">Sales<span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{url('sales-create')}}"><i class="ti-plus fa-fw"></i> <span class="hide-menu">New Sales</span></a></li>
                    <li><a href="{{url('sales')}}"><i class="ti-list fa-fw"></i> <span class="hide-menu">Sales List</span></a></li>
                    <li><a href="{{url('sales-return')}}"><i class="ti-back-left fa-fw"></i> <span class="hide-menu">Return Sale</span></a></li>
                    <li><a href="{{url('sales-return-list')}}"><i class="ti-bar-chart fa-fw"></i> <span class="hide-menu">Return Sale List</span></a></li>
                </ul>
            </li>
            <li> <a href="#" class="waves-effect"><i class="mdi mdi-account-multiple fa-fw"></i> <span class="hide-menu">Customers<span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{url('customers')}}"><i class="ti-list fa-fw"></i> <span class="hide-menu">Customers List</span></a></li>
                </ul>
            </li>
            <li> <a href="#" class="waves-effect"><i class="mdi mdi-star fa-fw"></i> <span class="hide-menu">Stock<span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{url('stock')}}"><i class="ti-list fa-fw"></i> <span class="hide-menu">Stock List</span></a></li>
                </ul>
            </li>
            <li> <a href="#" class="waves-effect"><i class="mdi mdi-rotate-left-variant fa-fw"></i> <span class="hide-menu">Suppliers<span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{url('suppliers')}}"><i class="ti-list fa-fw"></i> <span class="hide-menu">Suppliers List</span></a></li>
                    </li>
                </ul>
            </li>
            <li> <a href="#" class="waves-effect"><i class="mdi mdi-content-copy fa-fw"></i> <span class="hide-menu">Purchase<span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{url('purchase-create')}}"><i class="ti-plus fa-fw"></i> <span class="hide-menu">Create Purchase</span></a></li>
                    <li><a href="{{url('purchase')}}"><i class="ti-list fa-fw"></i> <span class="hide-menu">Purchases List</span></a></li>
                    <li><a href="{{url('purchase-return')}}"><i class="ti-back-left fa-fw"></i> <span class="hide-menu">Return Purchase</span></a></li>
                    <li><a href="{{url('purchase-return-list')}}"><i class="ti-bar-chart fa-fw"></i> <span class="hide-menu">Return Purchase List</span></a></li>
                </ul>
            </li>
            <li> <a href="#" class="waves-effect"><i class="mdi mdi-clipboard-text fa-fw"></i> <span class="hide-menu">Vouchers<span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{url('supplier-voucher')}}"><i class="ti-list fa-fw"></i> <span class="hide-menu">Supplier Voucher</span></a></li>
                    <li><a href="{{url('customer-voucher')}}"><i class="ti-list fa-fw"></i> <span class="hide-menu">Customer Voucher</span></a></li>
                </ul>
            </li>
            <li> <a href="#" class="waves-effect"><i class="mdi mdi-chart-bar fa-fw"></i> <span class="hide-menu">Ledger Reporst<span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{url('supplier-ledger')}}"><i class="ti-list fa-fw"></i> <span class="hide-menu">Supplier</span></a></li>
                    <li><a href="{{url('customer-ledger')}}"><i class="ti-list fa-fw"></i> <span class="hide-menu">Customer</span></a></li>
                    <li><a href="{{url('product-ledger')}}"><i class="ti-list fa-fw"></i> <span class="hide-menu">Product</span></a></li>
                    <li><a href="{{url('day-book')}}"><i class="ti-list fa-fw"></i> <span class="hide-menu">Day Book</span></a></li>
                </ul>
            </li>
            {{-- <li> <a href="#" class="waves-effect"><i class="mdi mdi-apps fa-fw"></i> <span class="hide-menu">Expense Manage<span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{url('expense/create')}}"><i class="ti-plus fa-fw"></i> <span class="hide-menu">Create Expense</span></a></li>
                    <li><a href="{{url('expense')}}"><i class="ti-list fa-fw"></i> <span class="hide-menu">Expense List</span></a></li>
                </ul>
            </li> --}}
            <li> <a href="#" class="waves-effect"><i class="mdi mdi-briefcase fa-fw"></i> <span class="hide-menu">Profit Loss<span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{url('/customer-profit-loss')}}"><i class="ti-list fa-fw"></i> <span class="hide-menu">Customer</span></a></li>
                    <li><a href="{{url('/product-profit-loss')}}"><i class="ti-list fa-fw"></i> <span class="hide-menu">Product</span></a></li>
                </ul>
            </li>
            {{-- <li> <a href="{{url('expense-head')}}" class="waves-effect"><i class="mdi mdi-bullseye fa-fw"></i> <span class="hide-menu">Expense Head</span></a></li> --}}
            <li> <a href="{{url('products-head')}}" class="waves-effect"><i class="mdi mdi-bullseye fa-fw"></i> <span class="hide-menu">Products Head</span></a></li>

            {{-- <li> <a href="" class="waves-effect"><i class="mdi mdi-content-copy fa-fw"></i> <span class="hide-menu">User Manger<span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{url('user')}}"><i class="ti-layout-width-default fa-fw"></i> <span class="hide-menu">Users List</span></a></li>
                    @permission("create_user")
                    <li><a href="{{url('user/create')}}"><i class="ti-layout-sidebar-left fa-fw"></i> <span class="hide-menu">Create User</span></a></li>
                    @endpermission
                </ul>
            </li> --}}
            {{-- <li> <a href="" class="waves-effect"><i class="mdi mdi-content-copy fa-fw"></i> <span class="hide-menu">Role Manger<span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{url('role')}}"><i class="ti-layout-width-default fa-fw"></i> <span class="hide-menu">Roles List</span></a></li>
                    <li><a href="{{url('role/create')}}"><i class="ti-layout-sidebar-left fa-fw"></i> <span class="hide-menu">Create Role</span></a></li>
                </ul>
            </li> --}}
        </ul>
    </div>
</div>
