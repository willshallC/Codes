@extends('layouts.app', ['pageSlug' => 'dashboard'])

@section('content')

<?php $image_path = config('global.image_path'); ?>
    <?php /* ?>
	<div class="row">
        <div class="col-12">
            <div class="card card-chart">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-sm-6 text-left">
                            <h5 class="card-category">Total Shipments</h5>
                            <h2 class="card-title">Performance</h2>
                        </div>
                        <div class="col-sm-6">
                            <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                            <label class="btn btn-sm btn-primary btn-simple active" id="0">
                                <input type="radio" name="options" checked>
                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Accounts</span>
                                <span class="d-block d-sm-none">
                                    <i class="tim-icons icon-single-02"></i>
                                </span>
                            </label>
                            <label class="btn btn-sm btn-primary btn-simple" id="1">
                                <input type="radio" class="d-none d-sm-none" name="options">
                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Purchases</span>
                                <span class="d-block d-sm-none">
                                    <i class="tim-icons icon-gift-2"></i>
                                </span>
                            </label>
                            <label class="btn btn-sm btn-primary btn-simple" id="2">
                                <input type="radio" class="d-none" name="options">
                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Sessions</span>
                                <span class="d-block d-sm-none">
                                    <i class="tim-icons icon-tap-02"></i>
                                </span>
                            </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="chartBig1"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Total Shipments</h5>
                    <h3 class="card-title"><i class="tim-icons icon-bell-55 text-primary"></i> 763,215</h3>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="chartLinePurple"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Daily Sales</h5>
                    <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i> 3,500€</h3>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="CountryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Completed Tasks</h5>
                    <h3 class="card-title"><i class="tim-icons icon-send text-success"></i> 12,100K</h3>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="chartLineGreen"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="card card-tasks">
                <div class="card-header ">
                    <h6 class="title d-inline">Tasks(5)</h6>
                    <p class="card-category d-inline">today</p>
                    <div class="dropdown">
                        <button type="button" class="btn btn-link dropdown-toggle btn-icon" data-toggle="dropdown">
                            <i class="tim-icons icon-settings-gear-63"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#pablo">Action</a>
                            <a class="dropdown-item" href="#pablo">Another action</a>
                            <a class="dropdown-item" href="#pablo">Something else</a>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="table-full-width table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" value="">
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="title">Update the Documentation</p>
                                        <p class="text-muted">Dwuamish Head, Seattle, WA 8:47 AM</p>
                                    </td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" title="" class="btn btn-link" data-original-title="Edit Task">
                                            <i class="tim-icons icon-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" value="" checked="">
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="title">GDPR Compliance</p>
                                        <p class="text-muted">The GDPR is a regulation that requires businesses to protect the personal data and privacy of Europe citizens for transactions that occur within EU member states.</p>
                                    </td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" title="" class="btn btn-link" data-original-title="Edit Task">
                                            <i class="tim-icons icon-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" value="">
                                                    <span class="form-check-sign">
                                                        <span class="check"></span>
                                                    </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="title">Solve the issues</p>
                                        <p class="text-muted">Fifty percent of all respondents said they would be more likely to shop at a company </p>
                                    </td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" title="" class="btn btn-link" data-original-title="Edit Task">
                                            <i class="tim-icons icon-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" value="">
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="title">Release v2.0.0</p>
                                        <p class="text-muted">Ra Ave SW, Seattle, WA 98116, SUA 11:19 AM</p>
                                    </td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" title="" class="btn btn-link" data-original-title="Edit Task">
                                            <i class="tim-icons icon-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" value="">
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="title">Export the processed files</p>
                                        <p class="text-muted">The report also shows that consumers will not easily forgive a company once a breach exposing their personal data occurs. </p>
                                    </td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" title="" class="btn btn-link" data-original-title="Edit Task">
                                            <i class="tim-icons icon-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" value="">
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="title">Arival at export process</p>
                                        <p class="text-muted">Capitol Hill, Seattle, WA 12:34 AM</p>
                                    </td>
                                    <td class="td-actions text-right">
                                        <button type="button" rel="tooltip" title="" class="btn btn-link" data-original-title="Edit Task">
                                            <i class="tim-icons icon-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card ">
                <div class="card-header">
                    <h4 class="card-title">Simple Table</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tablesorter" id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Country
                                    </th>
                                    <th>
                                        City
                                    </th>
                                    <th class="text-center">
                                        Salary
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                      Dakota Rice
                                    </td>
                                    <td>
                                      Niger
                                    </td>
                                    <td>
                                      Oud-Turnhout
                                    </td>
                                    <td class="text-center">
                                      $36,738
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Minerva Hooper
                                    </td>
                                    <td>
                                        Curaçao
                                    </td>
                                    <td>
                                        Sinaai-Waas
                                    </td>
                                    <td class="text-center">
                                        $23,789
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Sage Rodriguez
                                    </td>
                                    <td>
                                        Netherlands
                                    </td>
                                    <td>
                                        Baileux
                                    </td>
                                    <td class="text-center">
                                        $56,142
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Philip Chaney
                                    </td>
                                    <td>
                                        Korea, South
                                    </td>
                                    <td>
                                        Overland Park
                                    </td>
                                    <td class="text-center">
                                        $38,735
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Doris Greene
                                    </td>
                                    <td>
                                        Malawi
                                    </td>
                                    <td>
                                        Feldkirchen in Kärnten
                                    </td>
                                    <td class="text-center">
                                        $63,542
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Mason Porter
                                    </td>
                                    <td>
                                        Chile
                                    </td>
                                    <td>
                                        Gloucester
                                    </td>
                                    <td class="text-center">
                                        $78,615
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Jon Porter
                                    </td>
                                    <td>
                                        Portugal
                                    </td>
                                    <td>
                                        Gloucester
                                    </td>
                                    <td class="text-center">
                                        $98,615
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php */ ?>
	
	
	
	
	<?php /*<div class="row admin-dashboard">
        <div class="col-6">
			<h4 style="text-align: center"> Digital Marketing</h4>
			<h4 style="text-align: center"> Projects Secured : {{count($seo_Projects_active)}} | <span>Projects Closed : {{count($seo_Projects_pause)}}</span></h4>
			<div class="row">
				<div class="col-6">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>Secured</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$counter = 0;
							?>
							@foreach($seo_Projects_active as $seo_Project_active)
							<?php $counter++; ?>
							<tr>
								<td><a href="{{ route('view-project',$seo_Project_active->id) }}">{{$seo_Project_active->project_title}}</a></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="col-6">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>Closed/Paused</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$counter = 0;
							?>
							@foreach($seo_Projects_pause as $seo_Project_pause)
							<?php $counter++; ?>
							<tr>
								<td><a href="{{ route('view-project',$seo_Project_pause->id) }}">{{$seo_Project_pause->project_title}}</a></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-6">
			<h4 style="text-align: center">Design & Development</h4>
			<h4 style="text-align: center"> Projects Secured : {{count($dev_design_Projects_active)}} | <span>Projects Closed : {{count($dev_design_Projects_pause)}}</span></h4>
			<div class="row">
				<div class="col-6">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>Secured</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$counter = 0;
							?>
							@foreach($dev_design_Projects_active as $dev_design_Project_active)
							<?php $counter++; ?>
							<tr>
								<td><a href="{{ route('view-project',$dev_design_Project_active->id) }}">{{$dev_design_Project_active->project_title}}</a></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="col-6">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>Closed/Paused</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$counter = 0;
							?>
							@foreach($dev_design_Projects_pause as $dev_design_Project_pause)
							<?php $counter++; ?>
							<tr>
								<td><a href="{{ route('view-project',$dev_design_Project_pause->id) }}">{{$dev_design_Project_pause->project_title}}</a></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	*/?>
	
	
	<div id="main_section" class="main_section">
		<div class="dashbrd-upr-otr">
			<div class="dashboard_profile_details " style="background-color:#f7f8f9; padding: 35px;">
				<div class="marketing_icon">
					<h2 class="digi-hd">digital marketing</h2>
					<p>projects secured: {{count($seo_Projects_active)}} <span>Projects Closed: {{count($seo_Projects_pause)}}</span></p>
				</div>
				<hr class="hori_line">
				<div class="inner_cintent">
					<h4>secured</h4>
					<ul>
						<?php
							$counter = 0;
						?>
							@foreach($seo_Projects_active as $seo_Project_active)
						<?php $counter++; ?>
							<li>- <a href="{{ route('view-project',$seo_Project_active->id) }}">{{$seo_Project_active->project_title}}</a></li>
						@endforeach		
					</ul>
					<h4 class="closed_icon">closed/paused</h4>
					<ul>
						<?php
						$counter = 0;
						?>
						@foreach($seo_Projects_pause as $seo_Project_pause)
						<?php $counter++; ?>
						<li>- <a href="{{ route('view-project',$seo_Project_pause->id) }}">{{$seo_Project_pause->project_title}}</a></li>
						
						@endforeach
					</ul>
				</div>
			</div>
			<div class="dashboard_profile_details " style="background-color:#f7f8f9; padding: 35px;">
				<div class="marketing_icon">
					<h2 class="digi-hd">Design & Development</h2>
					<p>projects secured: {{count($dev_design_Projects_active)}} <span>Projects Closed: {{count($dev_design_Projects_pause)}}</span></p>
				</div>
				<hr class="hori_line">
				<div class="inner_cintent">
					<h4>secured</h4>
					<ul>
						<?php
							$counter = 0;
						?>
						@foreach($dev_design_Projects_active as $dev_design_Project_active)
						<?php $counter++; ?>
							<li>- <a href="{{ route('view-project',$dev_design_Project_active->id) }}">{{$dev_design_Project_active->project_title}}</a></li>
						@endforeach		
					</ul>
					
					<h4 class="closed_icon">closed/paused</h4>
					<ul>
						<?php
						$counter = 0;
						?>
						@foreach($dev_design_Projects_pause as $dev_design_Project_pause)
						<?php $counter++; ?>
						<li>- <a href="{{ route('view-project',$dev_design_Project_pause->id) }}">{{$dev_design_Project_pause->project_title}}</a></li>
						
						@endforeach
					</ul>
				</div>
			</div>
		</div>
		<div class="biddr-otr">
			@foreach($hired_this_month as $bid)
            
            <?php // echo "<pre>"; print_r($hired_this_month ); ?>

			<div class="profile_details" style="background-color:#f7f8f9; padding: 25px 35px;">
				<div class="profile_image">
					<img src="{{ $image_path  }}{{$bid->profile_pic == "" ? 'employee.jpg' : $bid->profile_pic}}" >
				</div>
				<div class="profile_name">
					<h2>{{$bid->u_name}}</h2>
					<p> No. of Bids: {{$bid->bids_count}} </p>
					<h4> Projects Secured: {{$bid->hired_count}} </h4>
					<ul>
						<li>- SEO: {{$bid->secured_seo_projects}}</li>
						<li>- Design/Dev: {{$bid->secured_dev_design_projects}}</li>	
						
					</ul>
					<h4>projects closed: {{$bid->closed_projects}}</h4>
				</div>
			</div>
			@endforeach
		</div>
		
	</div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	<?php /*
	<div class="row">	
		@foreach($hired_this_month as $bid)
		<div class="col-6">
			<img src="{{ $image_path  }}{{$bid->profile_pic == "" ? 'employee.jpg' : $bid->profile_pic}}" >
			<div>
				<h4> No. of Bids: {{$bid->bids_count}} </h4>
				<h5> Projects Secured:{{$bid->hired_count}} </h5>
				<div>
				-SEO: {{$bid->secured_seo_projects}}<br>
				-Design/Dev: {{$bid->secured_dev_design_projects}}<br>
				Projects Closed: {{$bid->closed_projects}} 
				</div>
			</div>
		</div>
		@endforeach
	</div>
	*/?>
	
@endsection

@push('js')
    <script src="{{ asset('black') }}/js/plugins/chartjs.min.js"></script>
    <script>
        $(document).ready(function() {
          demo.initDashboardPageCharts();
        });
    </script>
@endpush
