<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LaraApp</title>
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ URL::asset('img/AdminLTELogo.png') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">


    <div class="wrapper" id="app">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- SEARCH FORM -->
            <!-- <div class="form-inline ml-3" v-if="schoolPage">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search"
                        aria-label="Search" v-model="search" @keyup="searchgrid" />
                    <div class="input-group-append">
                        <button class="btn btn-navbar" @click="searchgrid">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div> -->

            <!-- Right navbar links -->
            <!-- {{-- <notification></notification> --}} -->

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/dashboard" class="brand-link">
                <img src="{{ URL::asset('img/AdminLTELogo.png') }}" alt="DepEd Logo" class="brand-image" style="opacity: .8" />
                <!--   class="brand-image img-circle elevation-3" style="opacity: .8"-->
                <span class="brand-text font-weight-light">LaraApp</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @if(Auth::user()->avatar)
                        <img src="{{Auth::user()->avatar}}" class="img-circle elevation-2" alt="User Image" />
                        @elseif(Auth::user()->photo)
                        <img src="{{ URL::asset('img/'.Auth::user()->photo) }}" class="img-circle elevation-2" alt="User Image" />
                        @else
                        <img src="{{ URL::asset('img/userprofile.png') }}" class="img-circle elevation-2" alt="User Image" />
                        @endif
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">
                            <div id="username">{{Auth::user()->name}}</div>
                            <p>{{Auth::user()->role->name}}</p>
                        </a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                        <li class="nav-item">
                            <router-link to="/dashboard" class="nav-link">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>
                                    Dashboard
                                </p>
                            </router-link>
                        </li>
                        @canany(['isAdmin', 'isSupport'])
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-desktop"></i>
                                <p>
                                    Transaction
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="/school" class="nav-link ">
                                        <i class="nav-icon fas fa-school text-blue"></i>
                                        <p>School</p>
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                        @endcanany
                        @canany(['isAdmin', 'isSupport'])
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="/users" class="nav-link ">
                                        <i class="nav-icon fas fa-users text-blue"></i>
                                        <p>Users</p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/roles" class="nav-link ">
                                        <i class="nav-icon fas fa-key text-blue"></i>
                                        <p>Roles</p>
                                    </router-link>
                                </li>
                            </ul>
                        </li>
                        @endcanany
                        <li class="nav-item">
                            <router-link to="/sample" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Example Component
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/profile" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Profile
                                </p>
                            </router-link>
                        </li>
                        @can('isAdmin')
                        <li class="nav-item">
                            <router-link to="/developer" class="nav-link">
                                <i class="nav-icon fas fa-cogs text-blue"></i>
                                <p>
                                    Developer
                                </p>
                            </router-link>
                        </li>
                        @endcan
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-power-off text-red"></i>
                                <p>
                                    {{ __('Logout') }}
                                </p>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <router-view :key="$route.fullPath"></router-view>
            <vue-progress-bar></vue-progress-bar>
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Administrator Panel
            </div>
        </footer>
        <!-- ./wrapper -->
        <!-- <script src="//cdn.tinymce.com/4/tinymce.min.js"></script> -->

    </div>
    @auth
    <script>
        window.user = @json(auth() -> user());
    </script>
    @endauth

    <script src="{{ mix('/js/app.js') }}"></script>
    <script src="{{ mix('js/popper.js') }}"></script>
</body>

</html>