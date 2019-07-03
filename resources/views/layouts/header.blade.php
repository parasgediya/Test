<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ URL::to('/') }}" class="logo"><b>Test</b>App</a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                @impersonate()
                <li class="user user-menu">
                    <a href="{{ URL::to('admin/impersonate/destroy') }}" class="btn btn-danger btn-block" ><i class='fa fa-sign-out'></i> End Impersonate</a>                    
                </li>
                @endimpersonate
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        @if(\Auth::user()->image)
                        <img src="{{ asset( \Auth::user()->image) }}" class="user-image" alt="User Image" />
                        @else
                        <img src="{{ asset('images/default.jpg') }}" class="user-image" alt="User Image" />
                        @endif
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{ \Auth::user()->firstname}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            @if(\Auth::user()->image)
                            <img src="{{ asset( \Auth::user()->image) }}" class="img-circle" alt="User Image" />
                            @else
                            <img src="{{ asset('images/default.jpg') }}" class="img-circle" alt="User Image" />
                            @endif
                            <p>
                                {{ ucfirst(\Auth::user()->firstname.' '. \Auth::user()->lastname)}} - ({{ ucfirst(\Auth::user()->role)}})
                                <small>Member since Nov. 2012</small>
                            </p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{url('admin/profile')}}" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-default btn-flat" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>