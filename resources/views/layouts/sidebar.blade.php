<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">HEADER</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="{{ isset($page_title) &&  $page_title == 'Dashboard' ? 'active open' : '' }}"><a
                    href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
            @if(\Auth::user()->role == 'admin')
            <li
                class="{{ isset($page_title) &&  ($page_title == 'Users') ? 'treeview menu-open' : 'treeview' }}">
                <a href=""><i class="fa fa-list"></i><span>Users</span> <i
                        class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu"
                    style="{{ isset($page_title) &&  ($page_title == 'Add' || $page_title == 'Users') ? 'display:block' : 'display:none' }}">
                    <li class="{{ isset($page_title) &&  $page_title == 'Add' ? 'active open' : '' }}"><a
                            href="{{ URL::to('admin/users/add') }}"><i class="fa fa-circle-o"></i> Add Users</a></li>
                    <li class="{{ isset($page_title) &&  $page_title == 'Users' ? 'active open' : '' }}"><a
                            href="{{ URL::to('admin/users') }}"><i class="fa fa-circle-o"></i> Users</a></li>
                </ul>
            </li>
            <li class="{{ isset($page_title) &&  $page_title == 'Add' ? 'active open' : '' }}"><a
                            href="{{ URL::to('admin/clubs/add') }}"><i class="fa fa-list"></i> Clubs</a></li>
            @else
            <li
                class="{{ isset($page_title) &&  ($page_title == 'Teams' || $page_title =='Groups' || $page_title =='Players') ? 'treeview menu-open' : 'treeview' }}">
                <a href=""><i class="fa fa-list"></i><span>Team</span> <i
                        class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu"
                    style="{{ isset($page_title) &&  ($page_title == 'Groups' || $page_title == 'Teams' || $page_title =='Players') ? 'display:block' : 'display:none' }}">
                    <li class="{{ isset($page_title) &&  $page_title == 'Teams' ? 'active open' : '' }}"><a
                            href="{{ URL::to('admin/teams') }}"><i class="fa fa-circle-o"></i> Teams</a></li>
                    <li class="{{ isset($page_title) &&  $page_title == 'Groups' ? 'active open' : '' }}"><a
                            href="{{ URL::to('admin/groups') }}"><i class="fa fa-circle-o"></i> Groups</a></li>
                    <li class="{{ isset($page_title) &&  $page_title == 'Players' ? 'active open' : '' }}"><a
                            href="{{ URL::to('admin/players') }}"><i class="fa fa-circle-o"></i> Players</a></li>
                </ul>
            </li>
            @endif
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>