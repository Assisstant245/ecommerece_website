<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html"> <img alt="image" src="{{ asset('assets/img/favicon.ico') }}" class="header-logo" />
                <span class="logo-name">BixoSoft</span>
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown active">
                <a href="index.html" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            {{-- User Management --}}
            @canany(['user create', 'edit user', 'delete user', 'user view', 'role create', 'role edit', 'role delete',
                'role view', 'create permission', 'edit permissions', 'delete permission', 'view permission'])
                <li class="dropdown">
                    <a href="#" class="menu-toggle nav-link has-dropdown">
                        <i data-feather="briefcase"></i><span>User Management</span>
                    </a>
                    <ul class="dropdown-menu">

                        {{-- Users --}}
                        @canany(['user create', 'edit user', 'delete user', 'user view'])
                            <li><a class="nav-link" href="{{ route('admin.users.create') }}">Add Users</a></li>
                            <li><a class="nav-link" href="{{ url('admin/users') }}">View Users</a></li>
                        @endcanany

                        {{-- Roles Folder --}}
                        @canany(['role create', 'role edit', 'role delete', 'role view'])
                            <li class="dropdown">
                                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                                        data-feather="briefcase"></i><span>Roles</span></a>
                                <ul class="dropdown-menu">
                                    <li><a class="nav-link" href="{{ route('admin.roles.create') }}">Add Role</a></li>
                                    <li><a class="nav-link" href="{{ route('admin.roles.index') }}">View Roles</a></li>
                                </ul>
                            </li>
                        @endcanany

                        {{-- Permissions Folder --}}
                        @canany(['create permission', 'edit permissions', 'delete permission', 'view permission'])
                            <li class="dropdown">
                                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                                        data-feather="briefcase"></i><span>Permission</span></a>
                                <ul class="dropdown-menu">
                                    <li><a class="nav-link" href="{{ route('admin.permission.create') }}">Add Permission</a>
                                    </li>
                                    <li><a class="nav-link" href="{{ url('admin/permission') }}">View Permissions</a></li>
                                </ul>
                            </li>
                        @endcanany

                    </ul>

                </li>
                @endcanany



                @canany(['create category', 'edit category', 'delete category', 'view category'])
                    <li class="dropdown">
                        <a href="#" class="menu-toggle nav-link has-dropdown"><i
                                data-feather="briefcase"></i><span>Categories</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('admin.categories.create') }}">Add Category</a></li>

                            <li><a class="nav-link" href="{{ url('admin/categories') }}">View Category</a></li>

                        </ul>
                    </li>
                @endcanany
                @canany(['create subcategory', 'edit subcategory', 'delete subcategory', 'view subcategory'])
                    <li class="dropdown">
                        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="briefcase"></i><span>Sub
                                Categories</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('admin.subcategory.create') }}">Add Sub Category</a></li>

                            <li><a class="nav-link" href="{{ route('admin.subcategory.index') }}">View Sub Category</a></li>

                        </ul>
                    </li>
                @endcanany
                @canany(['create products', 'edit products', 'delete products', 'view products'])
                    <li class="dropdown">
                        <a href="#" class="menu-toggle nav-link has-dropdown"><i
                                data-feather="briefcase"></i><span>Products</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('admin.product.create') }}">Add products</a></li>

                            <li><a class="nav-link" href="{{ url('admin/product') }}">View products</a></li>

                        </ul>
                    </li>
                @endcanany
                @canany(['order view', 'order delete'])
                    <li class="dropdown">
                        <a href="#" class="menu-toggle nav-link has-dropdown"><i
                                data-feather="briefcase"></i><span>Orders</span></a>
                        <ul class="dropdown-menu">

                            <li><a class="nav-link" href="{{ url('admin/order') }}">View orders</a></li>

                        </ul>
                    </li>
                @endcanany
                @canany(['pos view', 'pos delete', 'pos edit'])
                    <li class="dropdown">
                        <a href="#" class="menu-toggle nav-link has-dropdown"><i
                                data-feather="briefcase"></i><span>POS</span></a>
                        <ul class="dropdown-menu">

                            <li><a class="nav-link" href="{{ url('admin/pos_view_admin_cart') }}">View pos</a></li>

                        </ul>
                    </li>
                @endcanany
                <li><a class="nav-link" href="{{ url('admin/getContactDetail') }}"></i><span>Messages</span></a></li>

            </ul>

        </aside>
    </div>

    <div class="settingSidebar">
        <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
        </a>
        <div class="settingSidebar-body ps-container ps-theme-default">
            <div class=" fade show active">
                <div class="setting-panel-header">Setting Panel
                </div>
                <div class="p-15 border-bottom">
                    <h6 class="font-medium m-b-10">Select Layout</h6>
                    <div class="selectgroup layout-color w-50">
                        <label class="selectgroup-item">
                            <input type="radio" name="value" value="1"
                                class="selectgroup-input-radio select-layout" checked>
                            <span class="selectgroup-button">Light</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="value" value="2"
                                class="selectgroup-input-radio select-layout">
                            <span class="selectgroup-button">Dark</span>
                        </label>
                    </div>
                </div>
                <div class="p-15 border-bottom">
                    <h6 class="font-medium m-b-10">Sidebar Color</h6>
                    <div class="selectgroup selectgroup-pills sidebar-color">
                        <label class="selectgroup-item">
                            <input type="radio" name="icon-input" value="1"
                                class="selectgroup-input select-sidebar">
                            <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                                data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="icon-input" value="2"
                                class="selectgroup-input select-sidebar" checked>
                            <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                                data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                        </label>
                    </div>
                </div>
                <div class="p-15 border-bottom">
                    <h6 class="font-medium m-b-10">Color Theme</h6>
                    <div class="theme-setting-options">
                        <ul class="choose-theme list-unstyled mb-0">
                            <li title="white" class="active">
                                <div class="white"></div>
                            </li>
                            <li title="cyan">
                                <div class="cyan"></div>
                            </li>
                            <li title="black">
                                <div class="black"></div>
                            </li>
                            <li title="purple">
                                <div class="purple"></div>
                            </li>
                            <li title="orange">
                                <div class="orange"></div>
                            </li>
                            <li title="green">
                                <div class="green"></div>
                            </li>
                            <li title="red">
                                <div class="red"></div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="p-15 border-bottom">
                    <div class="theme-setting-options">
                        <label class="m-b-0">
                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                                id="mini_sidebar_setting">
                            <span class="custom-switch-indicator"></span>
                            <span class="control-label p-l-10">Mini Sidebar</span>
                        </label>
                    </div>
                </div>
                <div class="p-15 border-bottom">
                    <div class="theme-setting-options">
                        <label class="m-b-0">
                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                                id="sticky_header_setting">
                            <span class="custom-switch-indicator"></span>
                            <span class="control-label p-l-10">Sticky Header</span>
                        </label>
                    </div>
                </div>
                <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                    <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                        <i class="fas fa-undo"></i> Restore Default
                    </a>
                </div>
            </div>
        </div>
    </div>
