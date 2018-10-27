<!-- sidebar -->
<div class="sidebar app-aside" id="sidebar">
    <div class="sidebar-container perfect-scrollbar">
        <div>
            <!-- start: SEARCH FORM -->
            <div class="search-form hidden-md hidden-lg">
                <a class="s-open" href="#"> <i class="ti-search"></i> </a>
                <form class="navbar-form" role="search">
                    <a class="s-remove" href="#" target=".navbar-form"> <i class="ti-close"></i> </a>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter search text here...">
                        <button class="btn search-button" type="submit">
                            <i class="ti-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <!-- end: SEARCH FORM -->
            <!-- start: USER OPTIONS -->
            <?php $path = \Route::currentRouteName(); ?>
            <div class="nav-user-wrapper">
                <div class="media">
                    <div class="media-left">
                        <a class="profile-card-photo" href="#">{{ Html::image('assets/images/admin2.jpeg','Admin',['style'=>'width:30px','height'=> '30px']) }}</a>
                    </div>
                    <div class="media-body" style="padding-left: 5px">
                        <span class="media-heading text-white">{{Auth::user()->name}}</span>
                        <div class="text-small text-white-transparent">

                        </div>
                    </div>
                    <div class="media-right media-middle">
                        <div class="dropdown">
                            <button href class="btn btn-transparent text-white dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-caret-down"></i>
                            </button>

                            <ul class="dropdown-menu animated fadeInRight pull-right">
                                @can('changepassword')
                                <li>
                                    <a href="{{route('changepassword')}}"> Change Password </a>
                                </li>
                                @endcan
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
            <!-- end: USER OPTIONS -->
            <nav>
                <!-- start: MAIN NAVIGATION MENU -->
                <div class="navbar-title">
                    <span>Main Navigation</span>
                </div>
                <ul class="main-navigation-menu">
                    @hasrole(['Administrator','HR','Employee'])
                    @can('dashboard')
                    <li  class="{{ $path == 'dashboard' ? 'active open': ''}}">
                        <a href="{{route('dashboard')}}">
                            <div class="item-content">
                                <div class="item-media">
                                    <i class="fa fa-home"></i>
                                </div>
                                <div class="item-inner">
                                    <span class="title"> Dashboard </span>
                                </div>
                            </div> 
                        </a>
                    </li>
                    @endcan
                    @endhasrole
                    @hasrole(['Administrator','HR'])
                    @can('employee')
                    <li class="{{ $path == 'employee' ? 'active': '' || $path == 'employee_add' ? 'active': '' }}">
                        <a href="javascript:void(0)">
                            <div class="item-content">
                                <div class="item-media">
                                    <i class="fa fa-group"></i>
                                </div>
                                <div class="item-inner">
                                    <span class="title"> Employee </span><i class="icon-arrow"></i>
                                </div>
                            </div> 
                        </a>

                        <ul class="sub-menu">

                            <li class="{{ $path == 'employee' ? 'active': ''}}">
                                <a href="{{route('employee')}}"><i class="fa fa-user"> <span class="title"> </i>    Employee List</i></span> </a> 
                            </li>
                            @can('employee_add')
                            <li class="{{ $path == 'employee_add' ? 'active': ''}}">
                                <a href="{{route('employee_add')}}"><i class="fa fa-user-plus"> <span class="title"></i>      Add Employee</span> </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan
                    @endhasrole
                    @hasrole('Employee')
                    @can('employee')
                    <li class="{{ $path == 'employee_edit' ? 'active': ''}}">   
                        <a href=" {{ url('employee_edit',Auth::user()->id) }}">
                            <div class="item-content">
                                <div class="item-media">
                                    <i class="fa fa-group"></i>
                                </div>
                                <div class="item-inner">
                                    <span class="title"> Employee </span>
                                </div>
                            </div> 
                        </a>
                    </li>
                    @endcan
                    @endhasrole
                    @hasrole('Administrator')
                    @can('role')
                    <li class="{{ $path == 'role' ? 'active': ''|| $path == 'role_detail' ? 'active': ''}}">
                        <a href="javascript:void(0)">
                            <div class="item-content">
                                <div class="item-media">
                                    <i class="fa fa-check-square-o"></i>
                                </div>
                                <div class="item-inner">
                                    <span class="title"> Roles </span><i class="icon-arrow"></i>
                                </div>
                            </div> 
                        </a>

                        <ul class="sub-menu">
                            <li class="{{ $path == 'role' ? 'active': ''}}">
                                <a href="{{route('role')}}"> <i class="fa fa-list"><span class="title"></i>    Role List</span> </a>
                            </li>
                            @can('role_detail')
                            <li class="{{ $path == 'role_detail' ? 'active': ''}}">
                                <a href="{{route('role_detail')}}"><i class="fa fa-user"> <span class="title"> </i>        Manage Role </span> </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan
                    @endhasrole
                    @hasrole(['Administrator','HR','Employee'])
                    @can('holiday')
                    <li class="{{ $path == 'holiday' ? 'active': ''}}">
                        <a href="{{route('holiday')}}">
                            <div class="item-content">
                                <div class="item-media">
                                    <i class="fa fa-plane"></i>
                                </div>
                                <div class="item-inner">
                                    <span class="title"> Holiday </span>
                                </div>
                            </div> 
                        </a>
                    </li>
                    @endcan
                    @endhasrole

                    @hasrole(['Administrator','Employee','HR'])
                    @can('calendar')
                    <li class="{{ $path == 'calendar' ? 'active': ''}}">
                        <a href="{{route('calendar')}}">
                            <div class="item-content">
                                <div class="item-media">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <div class="item-inner">
                                    <span class="title"> Calendar </span>
                                </div>
                            </div> 
                        </a>
                    </li>
                    @endcan
                    @endhasrole
                    @can('leave')
                    <li class="{{ $path == 'leave' ? 'active': ''}}">
                        <a href="{{route('leave')}}">
                            <div class="item-content">
                                <div class="item-media">
                                    <i class="fa fa-bed"></i>
                                </div>
                                <div class="item-inner">
                                    <span class="title"> Leave </span>
                                </div>
                            </div> 
                        </a>
                    </li>
                    @endcan
                    @hasrole(['Administrator','HR'])
                    <li class="{{ $path == 'general_setting' ? 'active': '' || $path == 'department' ? 'active': '' || $path == 'designation' ? 'active': '' || $path == 'leaveTypeView' ? 'active': ''}}">
                        <a href="javascript:void(0)">
                            <div class="item-content">
                                <div class="item-media">
                                    <i class="fa fa-cogs"></i>
                                </div>
                                <div class="item-inner">
                                    <span class="title"> Settings </span><i class="icon-arrow"></i>
                                </div>
                            </div> 
                        </a>
                        <ul class="sub-menu">
                            @can('general_setting')
                            <li class="{{ $path == 'general_setting' ? 'active': ''}}">
                                <a href="{{route('general_setting')}}"><i class="fa fa-wrench"><span class="title"> </i>     General Settings</span> </a>
                            </li>
                            @endcan
                            @can('department')
                            <li class="{{ $path == 'department' ? 'active': ''}}">
                                <a href="{{route('department')}}"><i class="fa fa-institution"> <span class="title"></i>    Department</span> </a>
                            </li>
                            @endcan
                            @can('designation')
                            <li class="{{ $path == 'designation' ? 'active': ''}}">
                                <a href="{{route('designation')}}"><i class="fa fa-user-secret" aria-hidden="true"> <span class="title"></i>     Designation</span> </a>
                            </li>
                            @endcan
                            @can('leaveTypeView')
                            <li class="{{ $path == 'leaveTypeView' ? 'active': ''}}">
                                <a href="{{route('leaveTypeView')}}"><i class="fa fa-bars"> <span class="title" ></i>   Leave Type</span> </a>
                            </li>
                            @endcan
                            <!--                            <li>
                                                            <a href="{{route('leaveTypeView')}}"><i class="fa fa-bars"> <span class="title" ></i>   Leave Type</span> </a>
                                                        </li>-->
                        </ul>
                    </li>
                    @endhasrole

                </ul>
                <!-- end: MAIN NAVIGATION MENU -->
            </nav>
        </div>
    </div>
</div>
<!-- / sidebar -->