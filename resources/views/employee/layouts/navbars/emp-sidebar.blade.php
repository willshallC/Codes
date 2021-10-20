<div class="sidebar">
    <div class="sidebar-wrapper">
        <!--div class="logo">
            <a href="#" class="simple-text logo-mini">{{ __('BD') }}</a>
            <a href="#" class="simple-text logo-normal">{{ __('Black Dashboard') }}</a>
        </div-->
        <ul class="nav">
            <li class="dashboard-ic comonne <?php echo ($pageSlug == 'dashboard') ? 'active' : '' ?>" @if ($pageSlug == 'dashboard') @endif>
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>

            <li class="assigned-projects-ic comonne <?php echo ($pageSlug == 'assigned-projects') ? 'active' : '' ?>" @if ($pageSlug == 'assigned-projects')  @endif>
                <a href="{{ route('assigned-projects') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Assigned Projects') }}</p>
                </a>


            </li>

            @if(auth()->user()->access_level == 4 || auth()->user()->department_id == '4')
            <li class="assigned-projects-ic comonne">
                <span>
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Projects') }}</p>
                </span>

                <ul>
                    <li class="<?php echo ($pageSlug == 'tl/add-project') ? 'active' : '' ?>"><a href="{{ route('tl/add-project') }}">Add Project</a></li>
                    <li class="<?php echo ($pageSlug == 'tl/projects') ? 'active' : '' ?>"><a href="{{ route('tl/projects') }}">View Projects</a></li>
                    <li class="<?php echo ($pageSlug == 'tl/inactive-project') ? 'active' : '' ?>"><a href="{{ route('tl/inactive-project') }}">Inactive Projects</a></li>

                </ul>
            </li>
            @endif

            @if(auth()->user()->access_level == 2)
            <li class="fill-dsr-ic comonne <?php echo ($pageSlug == 'hr-dsr') ? 'active' : '' ?>">
                <a href="{{ route('hr/dsr') }}"> 
                    <i class="tim-icons icon-bullet-list-67"></i>
                    <p>{{ __('Employees DSR') }}</p>
                </a>
                
                <ul>
                    <!-- <li class="<?php //echo ($pageSlug == 'dsr') ? 'active' : '' ?>"><a href="{{ route('dsr') }}">Employees DSR</a></li> -->
                    <li class="<?php echo ($pageSlug == 'hr-backdate-dsr-requests') ? 'active' : '' ?>"><a href="{{ route('hr/backdate-dsr-requests') }}">Back Date DSR Requests</a> </li>
                </ul>
            </li>

            <li class="fill-dsr-ic comonne <?php echo ($pageSlug == 'hr-users') ? 'active' : '' ?>">
                <span>
                    <i class="tim-icons icon-bullet-list-67"></i>
                    <p>{{ __('Employee Management') }}</p>
                </span>

                <ul>
                    <li class="<?php echo ($pageSlug == 'hr/add-employee') ? 'active' : '' ?>"><a href="{{ route('hr/add-employee') }}">Add Employee</a></li>
                    <li class="<?php echo ($pageSlug == 'hr-users') ? 'active' : '' ?>"><a href="{{ route('hr/employees') }}">View Employees</a> </li>
                </ul>
            </li>
            @endif

            <li class="fill-dsr-ic comonne <?php echo ($pageSlug == 'fill-dsr') ? 'active' : '' ?>" @if ($pageSlug == 'fill-dsr')  @endif>
                <span>
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Daily Status Report') }}</p>
                </span>

                <ul>
                    <li class="<?php echo ($pageSlug == 'fill-dsr') ? 'active' : '' ?>"><a href="{{ route('fill-dsr') }}">Fill Daily Status Report</a></li>
                    <li class="<?php echo ($pageSlug == 'backdate-request') ? 'active' : '' ?>"><a href="{{ route('backdate-request') }}">Backdate Request</a></li>
					<li class="<?php echo ($pageSlug == 'old-dsr') ? 'active' : '' ?>"><a href="{{ route('old-dsr') }}">Old DSR</a></li>
                    @if(auth()->user()->access_level == 4)
                    <li class="<?php echo ($pageSlug == 'team-dsr') ? 'active' : '' ?>"><a href="{{ route('tl/team-dsr') }}">Team DSR</a></li>
                    @endif
                    <!-- <li><a href="#">View Daily Status Report</a></li> -->
                </ul>
            </li>

            <li class="my-profile-ic comonne <?php echo ($pageSlug == 'my-profile' || $pageSlug == 'edit-profile') ? 'active' : '' ?>" @if ($pageSlug == 'my-profile') @endif>
                <span>
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Profile Settings') }}</p>
                </span>

                <ul>
                    <li class="<?php echo ($pageSlug == 'my-profile') ? 'active' : '' ?>"><a href="{{ route('my-profile') }}">View Profile</a></li>
                    <li class="<?php echo ($pageSlug == 'edit-profile') ? 'active' : '' ?>"><a href="{{ route('edit-profile') }}">Edit Profile</a></li>
					<li class="<?php echo ($pageSlug == 'update-password') ? 'active' : '' ?>"><a href="{{ route('update-password') }}">Change Password</a></li>
                    <!-- <li><a href="{{ route('edit-profile') }}">Change Password</a></li> -->

                </ul>
            </li>
			
			<?php 
			$user = auth()->user();
			if($user->department_id == 4)
			{
				//if(in_array(auth()->user()->id,config('app.authenticUsers'))){ ?>
				<li class="fill-dsr-ic comonne">
					<span>
						<i class="tim-icons icon-single-02"></i>
						<p>{{ __('Work Sheet-BA') }}</p>
					</span>
					<ul>
						<li class="<?php echo ($pageSlug == 'add-lead') ? 'active' : '' ?>">
							<a href="{{ route('add-lead') }}">Add Lead</a>
						</li>
						<li class="<?php echo ($pageSlug == 'old-work-sheets') ? 'active' : '' ?>">
							<a href="{{ route('old-work-sheets') }}">View Old Work Sheets</a>
						</li>
					</ul>
				</li>
				<?php 
			} 
			?>

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

            <li class="notifications-ic comonne <?php echo ($pageSlug == 'notifications') ? 'active' : '' ?>" @if ($pageSlug == 'notifications')  @endif>
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-bell-55"></i>
                    <p>{{ __('Notifications') }}</p>
                </a>
            </li>

            <li class="office-policy-ic comonne">
                <a href="https://www.willshall.com/office-policy.pdf" target="_blank">View Office Policy</a>
            </li>

            <li class="logout-ic comonne">
                <a href="{{ route('logout') }}" onclick="event.preventDefault();  document.getElementById('logout-form').submit();">Log out</a>
            </li>
        </ul>
    </div>
</div>
