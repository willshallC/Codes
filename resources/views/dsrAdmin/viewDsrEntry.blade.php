@extends('layouts.app', ['pageSlug' => 'dsr'])

@section('content')
	<?php //echo '<pre>';print_r($employee_time_spent);echo'</pre>';die; ?>
	<?php 
		/*$totalhours = isset($employee_time_spent[0]) && !empty($employee_time_spent[0]) ? floor($employee_time_spent[0]->total_time/60) : "";

		$totalmins = isset($employee_time_spent[0]) && !empty($employee_time_spent[0]) ? $employee_time_spent[0]->total_time - $totalhours*60 : "";

		if($totalhours){ $totalhours .= " hours"; }
		if($totalmins){ $totalmins .= " mins"; }*/

	?>
	<div class="row">
        <div class="col-12">
        	<a href="{{ url('/dsr') }}" class="btn">Back</a>
        </div>
		<div class="col-12"></div>
	</div>

	<table class="table table-striped table-bordered table-hover" id="project_list">
        <tbody>
			<tr>
                <td colspan="2"><strong>DSR Entry of {{ $dsr->name}} ({{ $dsr->dsr_date}})</strong></td>
            </tr>
            <tr>
                <td>Project Title : {{ $dsr->project_title }}</td>
			</tr>
			<tr>
                <td>Category : {{ $dsr->category }}</td>
			</tr>
			<tr>
				<td>Sub-Category   : {{  $dsr->subcategory }}</td>
            </tr>
			<?php 
				$hours = floor($dsr->time_spent/60);
				$mins = $dsr->time_spent - $hours*60;
				if($hours)
					$hours .= " hour(s) ";
				else
					$hours = "";
				
				if($mins)
					$mins .= " mins";
				else
					$mins = "";
			?>
			<tr>
                <td>Time spent : {{ $hours.$mins }}</td>
			</tr>
			<tr>
				<td>Description : {{  $dsr->description}}</td>
            </tr>
			
            <?php /*if($totalhours || $totalmins){ ?>
				<tr>
					<td colspan="2">
						<table class="table table-striped table-bordered table-hover">
							<tr>
								<?php $counter = 0; $totalemployees = count($employee_time_spent);
								foreach($employee_time_spent as $employee_time){ ?>
									
									<?php if($counter%4 == 0){ ?>
										</tr>
										<tr>
									<?php } ?>
									<td><a href="{{ route('view-user',$employee_time->id)}}">{{$employee_time->name}}</a> : {{ $hours .' '. $mins}}</td>
									
								<?php $counter++; } ?>
							</tr>
						</table>
					</td>
	            </tr>
        	<?php }*/ ?>
        </tbody>
    </table> 

	<!-- <div>
		<h1>No projects to display</h1>
	</div> -->
@endsection