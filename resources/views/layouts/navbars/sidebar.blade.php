<div class="sidebar">
    <div class="sidebar-wrapper">
       <!--div class="logo">
            <a href="#" class="simple-text logo-mini">{{ __('BD') }}</a>
            <a href="#" class="simple-text logo-normal">{{ __('Black Dashboard') }}</a>
        </div-->
        <ul class="nav">
            <li class="dashboard-ic comonne <?php echo ($pageSlug == 'dashboard') ? 'active' : '' ?>">
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li class="fill-dsr-ic comonne <?php echo ($pageSlug == 'dsr') ? 'active' : '' ?>">
                <a href="{{ route('dsr') }}"> 
                    <i class="tim-icons icon-bullet-list-67"></i>
                    <p>{{ __('Employees DSR') }}</p>
                </a>
                
                <ul>
                    <!-- <li class="<?php //echo ($pageSlug == 'dsr') ? 'active' : '' ?>"><a href="{{ route('dsr') }}">Employees DSR</a></li> -->
                    <li class="<?php echo ($pageSlug == 'backdate-dsr-requests') ? 'active' : '' ?>"><a href="{{ route('backdate-dsr-requests') }}">Back Date DSR Requests</a> </li>
                </ul>
            </li>
			<li class="fill-dsr-ic comonne <?php echo ($pageSlug == 'ba-worksheets') ? 'active' : '' ?>">
                <a href="{{ route('ba-worksheets') }}"> 
                    <i class="tim-icons icon-bullet-list-67"></i>
                    <p>{{ __('BA Worksheets') }}</p>
                </a>
            </li>
            <li class="assigned-projects-ic comonne <?php echo ($pageSlug == 'projects' || $pageSlug == 'add-project') ? 'active' : '' ?>">
                <span> 
                    <i class="tim-icons icon-bullet-list-67"></i>
                    <p>{{ __('Projects') }}</p>
                </span>
                
                <ul>
                    <li class="<?php echo ($pageSlug == 'add-project') ? 'active' : '' ?>"><a href="{{ route('add-project') }}">Add Project</a></li>
                    <li class="<?php echo ($pageSlug == 'projects') ? 'active' : '' ?>"><a href="{{ route('projects') }}">View Projects</a> </li>
                    <li class="<?php echo ($pageSlug == 'inactive-projects') ? 'active' : '' ?>"><a href="{{ route('inactive-projects') }}">Inactive Projects</a> </li>
                
                </ul>
            </li>
            <li class="employee-management-ic comonne <?php echo ($pageSlug == 'users') ? 'active' : '' ?>">
                <span>
                    <i class="tim-icons icon-bullet-list-67"></i>
                    <p>{{ __('Employee Management') }}</p>
                </span>

                <ul>
                    <li class="<?php echo ($pageSlug == 'add-employee') ? 'active' : '' ?>"><a href="{{ route('user.create') }}">Add Employee</a></li>
                    <li class="<?php echo ($pageSlug == 'users') ? 'active' : '' ?>"><a href="{{ route('user.index') }}">View Employees</a> </li>
                </ul>
            </li>

            <?php if(in_array(auth()->user()->id,config('app.authenticUsers'))){ ?>
                <li class="mirror-task-ic comonne">
                    <span>
                        <i class="tim-icons icon-single-02"></i>
                        <p>{{ __('Mirror Site Record') }}</p>
                    </span>
                    <ul>
                        <li class="<?php echo ($pageSlug == 'add-task') ? 'active' : '' ?>">
                            <a href="{{ route('add-task') }}">Add Task</a>
                        </li>
                        <li class="<?php echo ($pageSlug == 'mirror-sheet') ? 'active' : '' ?>">
                            <a href="{{ route('mirror-sheet') }}">View Tasks</a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            
            <li class="fill-dsr-ic comonne">
                <a href="{{ route('reports') }}">
                    <i class="tim-icons icon-single-02"></i>
                    <p>{{ __('Reports') }}</p>
                </a>
            </li>
            
            <li class="my-profile-ic comonne <?php echo ($pageSlug == 'profile' || $pageSlug == 'edit-profile') ? 'active' : '' ?>">
                <span>
                    <i class="tim-icons icon-single-02"></i>
                    <p>{{ __('Profile Settings') }}</p>
                </span>
                
                <ul>
                <li class="<?php echo ($pageSlug == 'edit-profile') ? 'active' : '' ?>"><a href="{{ route('profile.edit')  }}">Edit Profile</a></li>
                <li class="<?php echo ($pageSlug == 'profile') ? 'active' : '' ?>"><a href="{{ route('profile.view')  }}">View Profile</a></li>
                <!-- <li><a href="#">Change Password</a></li> -->
                
                </ul>
            </li>
            <li class="administrator-ic comonne">
                <span>
                    <i class="tim-icons icon-single-02"></i>
                    <p>{{ __('Administrators') }}</p>
                </span>
                <ul>
                    <li class="<?php echo ($pageSlug == 'add-super-admin') ? 'active' : '' ?>"><a href="{{ route('add-admin')  }}">Add Admin</a></li>
                    <li class="<?php echo ($pageSlug == 'super-admin') ? 'active' : '' ?>"><a href="{{ route('admins')  }}">View Admins</a></li>
                </ul>
            </li>

            <li class="office-policy-ic comonne">
                <a href="https://www.willshall.com/office-policy.pdf" target="_blank">View Office Policy</a>
            </li>
            <li class="notifications-ic comonne <?php echo ($pageSlug == 'notifications') ? 'active' : '' ?>">
                <a href="{{ route('pages.notifications') }}">
                    <i class="tim-icons icon-bell-55"></i>
                    <p>{{ __('Notifications') }}</p>
                </a>
            </li>
            <li class="logout-ic comonne">
                <a href="{{ route('logout') }}" onclick="event.preventDefault();  document.getElementById('logout-form').submit();">Log out</a>
            </li>
        </ul>
    </div>
</div>
