<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{route('admin.dashboard')}}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="/dynaroof-logo.png" alt="dynaroof logo" style="height:60px;" />
            </span>
        </a>

        <a href="javascript:void(0);"
            class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="{{Request::segment(1) == 'dashboard' ? 'menu-item active' : 'menu-item'}} ">
            <a href="{{route('admin.dashboard')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Layouts -->
        <li class="{{Request::segment(1) == 'customer' ? 'menu-item active' : 'menu-item'}}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-user-pin"></i>
                <div data-i18n="Layouts">Customer</div>
            </a>
            <ul class="menu-sub">
                <li class="{{Request::segment(2) == 'registered' ? 'menu-item active' : 'menu-item'}}">
                    <a href="{{route('admin.get.registered.customer')}}" class="menu-link">
                        <div data-i18n="Without menu">Registered Customers</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>