<?php //echo'<pre>';print_r($admins);echo'</pre>';die; ?>
@extends('layouts.app', ['pageSlug' => 'super-admin'])

@section('content')
@if ($errors->any())
<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif

@if (session('status'))
<div class="alert alert-success">
	{{ session('status') }}
</div>
@endif
<?php $status = array(
        '1' => 'Active',
        '0' => 'Deactive'
    ); $counter=1; ?>

<div class="main_listing_projects1">
	<div class="">
		<h2>Administrators</h2>
	</div>

	<div class="table-res-mobile">
		<table class="table table-striped table-bordered table-hover new-bullet-class" id="admin_list">
			<thead>
				<tr>
					<th>Sr. No.</th>
					<th>Name</th>
					<th>Email</th>
					<th class="text-center">Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($admins as $index => $admin)
					<tr>
						<td>{{ $counter }}</td>
						<td>{{ $admin->name }}</td>
						<td>{{ $admin->email }}</td>
						<td class="st-{{ $status[$admin->status] }} text-center">{{ $status[$admin->status] }}</td>
						<td>
							<!-- <a href="#">
								<img src="{{ asset('/') }}custom/images/view-icon.svg">
							</a>&nbsp -->
							<a href="{{ route('edit-admin',$admin->id) }}">
								<img src="{{ asset('/') }}custom/images/edit-icon.svg">
							</a>
						</td>
					</tr>
					<?php $counter++; ?>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@endsection

@push('js')

@endpush