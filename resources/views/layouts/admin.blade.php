@php
    use App\Http\Middleware\RoleMenuCek;
    use App\Models\Menu_sub;
    $user_menu = RoleMenuCek::get();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Laravel SB Admin 2">
    <meta name="author" content="Alejandro RH">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <script src="https://kit.fontawesome.com/b69e31cf66.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ url('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('vendor/toastr/toastr.min.css') }}">

    <!-- Favicon -->
    <link href="{{ url('img/logo-img.png') }}" rel="icon" type="image/png">

    @stack('css')
</head>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

         <!-- Sidebar - Brand -->
         <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon">
                <img style="width: 60px" class="" src="{{ url('img/logo-img.png') }}" alt="">
            </div>
            {{-- <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div> --}}
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider">
        <div class="sidebar-heading">DASHBOARD</div>

        <li class="nav-item ">
            <a class="nav-link pb-2" href="{{ url('/home') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
        
        <li class="nav-item ">
            <a class="nav-link pb-2" href="{{ url('/profile') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>Profile</span></a>
        </li>

        <hr class="sidebar-divider mt-3">
        <div class="sidebar-heading">MENU</div>
        @php
            $i = 1;
        @endphp

        @foreach ($user_menu as $menu)
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse{{ $i }}" aria-expanded="false" aria-controls="collapse{{ $i }}">
                <i class="fas fa-fw {{ $menu->menu->icon }}"></i>
                <span>{{ $menu->menu->name }}</span>
            </a>
            <div id="collapse{{ $i }}" class="collapse" aria-labelledby="heading{{ $i }}" data-parent="#accordionSidebar" style="">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Item {{ $menu->menu->name }}:</h6>
                    @php
                        $menu_subs = Menu_sub::where('menus_id', $menu->menu->id)->get();
                        // dd($admin_sub_menu);
                    @endphp
                    @foreach ($menu_subs as $menu_sub)
                    <a class="collapse-item" href="{{ url($menu_sub->url) }}">{{ $menu_sub->name }}</a>
                    @endforeach
                </div>
            </div>
        </li>
        @php
            $i++;
        @endphp
        @endforeach


        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

              <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

              <!-- Sidebar Toggle (Topbar) -->
              <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                  <i class="fa fa-bars"></i>
              </button>

              <!-- Topbar Search -->
              <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                  <div class="input-group">
                      <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                      <div class="input-group-append">
                          <button class="btn btn-primary" type="button">
                              <i class="fas fa-search fa-sm"></i>
                          </button>
                      </div>
                  </div>
              </form>

              <!-- Topbar Navbar -->
              <ul class="navbar-nav ml-auto">

                  <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                  <li class="nav-item dropdown no-arrow d-sm-none">
                      <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-search fa-fw"></i>
                      </a>
                      <!-- Dropdown - Messages -->
                      <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                          <form class="form-inline mr-auto w-100 navbar-search">
                              <div class="input-group">
                                  <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                  <div class="input-group-append">
                                      <button class="btn btn-primary" type="button">
                                          <i class="fas fa-search fa-sm"></i>
                                      </button>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </li>

                  <!-- Nav Item - Alerts -->
                  <li class="nav-item dropdown no-arrow mx-1">
                      <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-bell fa-fw"></i>
                          <!-- Counter - Alerts -->
                          <span class="badge badge-danger badge-counter">3+</span>
                      </a>
                      <!-- Dropdown - Alerts -->
                      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                          <h6 class="dropdown-header">
                              Alerts Center
                          </h6>
                          <a class="dropdown-item d-flex align-items-center" href="#">
                              <div class="mr-3">
                                  <div class="icon-circle bg-primary">
                                      <i class="fas fa-file-alt text-white"></i>
                                  </div>
                              </div>
                              <div>
                                  <div class="small text-gray-500">December 12, 2019</div>
                                  <span class="font-weight-bold">A new monthly report is ready to download!</span>
                              </div>
                          </a>
                          <a class="dropdown-item d-flex align-items-center" href="#">
                              <div class="mr-3">
                                  <div class="icon-circle bg-success">
                                      <i class="fas fa-donate text-white"></i>
                                  </div>
                              </div>
                              <div>
                                  <div class="small text-gray-500">December 7, 2019</div>
                                  $290.29 has been deposited into your account!
                              </div>
                          </a>
                          <a class="dropdown-item d-flex align-items-center" href="#">
                              <div class="mr-3">
                                  <div class="icon-circle bg-warning">
                                      <i class="fas fa-exclamation-triangle text-white"></i>
                                  </div>
                              </div>
                              <div>
                                  <div class="small text-gray-500">December 2, 2019</div>
                                  Spending Alert: We've noticed unusually high spending for your account.
                              </div>
                          </a>
                          <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                      </div>
                  </li>

                  <!-- Nav Item - Messages -->
                  <li class="nav-item dropdown no-arrow mx-1">
                      <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-envelope fa-fw"></i>
                          <!-- Counter - Messages -->
                          <span class="badge badge-danger badge-counter">7</span>
                      </a>
                      <!-- Dropdown - Messages -->
                      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                          <h6 class="dropdown-header">
                              Message Center
                          </h6>
                          <a class="dropdown-item d-flex align-items-center" href="#">
                              <div class="dropdown-list-image mr-3">
                                  <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
                                  <div class="status-indicator bg-success"></div>
                              </div>
                              <div class="font-weight-bold">
                                  <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                                  <div class="small text-gray-500">Emily Fowler · 58m</div>
                              </div>
                          </a>
                          <a class="dropdown-item d-flex align-items-center" href="#">
                              <div class="dropdown-list-image mr-3">
                                  <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60" alt="">
                                  <div class="status-indicator"></div>
                              </div>
                              <div>
                                  <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                                  <div class="small text-gray-500">Jae Chun · 1d</div>
                              </div>
                          </a>
                          <a class="dropdown-item d-flex align-items-center" href="#">
                              <div class="dropdown-list-image mr-3">
                                  <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60" alt="">
                                  <div class="status-indicator bg-warning"></div>
                              </div>
                              <div>
                                  <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                                  <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                              </div>
                          </a>
                          <a class="dropdown-item d-flex align-items-center" href="#">
                              <div class="dropdown-list-image mr-3">
                                  <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="">
                                  <div class="status-indicator bg-success"></div>
                              </div>
                              <div>
                                  <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
                                  <div class="small text-gray-500">Chicken the Dog · 2w</div>
                              </div>
                          </a>
                          <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                      </div>
                  </li>

                  <div class="topbar-divider d-none d-sm-block"></div>

                  <!-- Nav Item - User Information -->
                  <li class="nav-item dropdown no-arrow">
                      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                          <figure class="img-profile rounded-circle avatar font-weight-bold" data-initial="{{ Auth::user()->name[0] }}"></figure>
                      </a>
                      <!-- Dropdown - User Information -->
                      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                          <a class="dropdown-item" href="{{ route('profile') }}">
                              <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                              {{ __('Profile') }}
                          </a>
                          <a class="dropdown-item" href="javascript:void(0)">
                              <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                              {{ __('Settings') }}
                          </a>
                          <a class="dropdown-item" href="javascript:void(0)">
                              <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                              {{ __('Activity Log') }}
                          </a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                              {{ __('Logout') }}
                          </a>
                      </div>
                  </li>

              </ul>

          </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">@yield('title')</h1>

                @if (session('success'))
                <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                @if (session('danger'))
                <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
                    {{ session('danger') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success border-left-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger border-left-danger" role="alert">
                        <ul class="pl-4 my-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('main-content')

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; simax1721 2023 - {{ now()->year }}</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Ready to Leave?') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-link" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ url('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ url('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ url('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ url('js/sb-admin-2.min.js') }}"></script>
<script src="{{ url('vendor/toastr/toastr.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@stack('scripts')
</body>
</html>
