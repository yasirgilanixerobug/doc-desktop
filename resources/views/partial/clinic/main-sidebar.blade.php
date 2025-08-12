<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('clinic.dashboard') }}" class="brand-link">
        <img src="{{ asset(Auth::user()->clinic->brandLogo ?? config('app.logo_icon'))  }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset(Auth::user()->userDetail->image ?? '/clinic-assets/dist/img/user2-160x160.jpg')  }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('clinic.dashboard') }}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input id="filterMainSidebarSearch" class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
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

                <li class="nav-item">
                    <a href="{{ route('clinic.dashboard')  }}" class="nav-link {{ request()->routeIs('clinic.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-wheelchair"></i>
                        <p>
                            Review Follow Up
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('clinic.reviewRequest.index')  }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Patient List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('clinic.reviewRequest.providerListing.index') . '#locations' }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Google Listing</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('clinic.reviewRequest.bulkImport')  }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Upload And Schedule</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('clinic.reviewRequest.sendMessageForm')  }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Request Review Now</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('clinic.reviewRequest.singleRequest')  }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Single Request Review</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('clinic.reporting.index')  }}" class="nav-link {{ request()->routeIs('clinic.reporting.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>
                            Reporting
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('clinic.calendar')  }}" class="nav-link {{ request()->routeIs('clinic.calendar') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-alt "></i>
                        <p>
                            Calendar
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('clinic.pendingAppointment')  }}" class="nav-link {{ request()->routeIs('clinic.pendingAppointment') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clock "></i>
                        <p>
                            Pending Appt
                            <span class="badge badge-danger navbar-badge">{{ $viewPendingAppointmentCount }}</span>
                        </p>

                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('clinic.customer.*') ? 'menu-open' : '' }}">
                    <a href="{{ route('clinic.customer.index')  }}" class="nav-link {{ request()->routeIs('clinic.customer.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-wheelchair "></i>
                        <p>
                            Customer
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('clinic.customer.index')  }}" class="nav-link {{ request()->routeIs('clinic.customer.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('clinic.customer.create')  }}" class="nav-link {{ request()->routeIs('clinic.customer.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ request()->routeIs('clinic.location.*') ? 'menu-open' : '' }}">
                    <a href="{{ route('clinic.location.index')  }}" class="nav-link {{ request()->routeIs('clinic.location.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-location-arrow "></i>
                        <p>
                            Location
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('clinic.location.index')  }}" class="nav-link {{ request()->routeIs('clinic.location.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                        @role('owner')
                        <li class="nav-item">
                            <a href="{{ route('clinic.location.create')  }}" class="nav-link {{ request()->routeIs('clinic.location.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create</p>
                            </a>
                        </li>
                        @endrole
                    </ul>
                </li>

                <li class="nav-item {{ request()->routeIs('clinic.provider.*') ? 'menu-open' : '' }}">
                    <a href="{{ route('clinic.provider.index')  }}" class="nav-link {{ request()->routeIs('clinic.provider.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-nurse "></i>
                        <p>
                            Provider
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('clinic.provider.index')  }}" class="nav-link {{ request()->routeIs('clinic.provider.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('clinic.provider.create')  }}" class="nav-link {{ request()->routeIs('clinic.provider.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('clinic.provider.trashed')  }}" class="nav-link {{ request()->routeIs('clinic.provider.trashed') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Trashed</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ request()->routeIs('clinic.staff.*') ? 'menu-open' : '' }}">
                    <a href="{{ route('clinic.staff.index')  }}" class="nav-link {{ request()->routeIs('clinic.staff.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-hospital-user "></i>
                        <p>
                            Staff
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('clinic.staff.index')  }}" class="nav-link {{ request()->routeIs('clinic.staff.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                        @role('owner')
                        <li class="nav-item">
                            <a href="{{ route('clinic.staff.create')  }}" class="nav-link {{ request()->routeIs('clinic.staff.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create</p>
                            </a>
                        </li>
                        @endrole
                        <li class="nav-item">
                            <a href="{{ route('clinic.staff.trashed')  }}" class="nav-link {{ request()->routeIs('clinic.staff.trashed') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Trashed</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ request()->routeIs('clinic.profile') || request()->routeIs('clinic.activityViewer') || request()->routeIs('clinic.changePasswordForm') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('clinic.profile') || request()->routeIs('clinic.activityViewer') || request()->routeIs('clinic.changePasswordForm') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog "></i>
                        <p>
                            Setting
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @role('owner')
                        <li class="nav-item">
                            <a href="{{ route('clinic.profile')  }}" class="nav-link {{ request()->routeIs('clinic.profile') ? 'active' : '' }}">
                                <i class="nav-icon far fa-circle "></i>
                                <p>
                                    Profile
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('clinic.activityViewer')  }}" class="nav-link {{ request()->routeIs('clinic.activityViewer') ? 'active' : '' }}">
                                <i class="nav-icon far fa-circle "></i>
                                <p>
                                    Activity
                                </p>
                            </a>
                        </li>

                        @endrole

                        <li class="nav-item">
                            <a href="{{ route('clinic.changePasswordForm')  }}" class="nav-link {{ request()->routeIs('clinic.changePasswordForm') ? 'active' : '' }}">
                                <i class="nav-icon far fa-circle "></i>
                                <p>
                                    Change Password
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="{{ route('auth.logout') }}">
                        <i class="nav-icon fas fa-user-lock"></i>
                        <p>Logout</p>
                    </a>
                    <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
