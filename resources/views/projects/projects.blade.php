@extends('layouts.app', ['pageSlug' => 'projects'])

@section('content')
    <?php /* $status = array(
        '1' => 'Active',
        '2' => 'Completed',
        '3' => 'On-hold',
        '4' => 'Canceled',
        '5' => 'Dispute'
    ); */ ?>
	<?php //echo '<pre>';print_r($projects);echo'</pre>';die; ?>
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


<style>
#project_list_filter {
    display: none !important;
}
</style>
<div class="main_listing_projects1">
        <div class=""><h2>Projects</h2></div>
        <div class="row projects_departments">
            <div class="form-group col-md-3">
                <div class="controls">
                    <select id="department_id" class="form-control" name="department">
                        <option value="" selected="selected">Department</option>
                        @foreach($departments as $val)
                            <option value="{{ $val->id }}">{{ $val->department }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-md-3">
                <div class="controls">
                    <select id="employees" class="form-control" name="employees">
                        <option value="" selected="selected">Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
			<div class="form-group col-md-3">
                <div class="controls">
                    <select id="salesExecutive" class="form-control" name="sales_executive">
                        <option value="" selected="selected">Sales Executive</option>
                        @foreach($salesExecutive as $val)
                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-md-3" style="display:none;">
                <div class="controls">
                    <select id="project_status" class="form-control" name="status">
                        <option value="" selected="selected">Status</option>
                        <option value="1">Active</option>
                        <option value="2">Completed</option>
                        <option value="3">Paused</option>
                        <option value="4">Canceled</option>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-3" style="display:none;"> 
                <div class="controls">
                    <select id="inactive_30" class="form-control" name="inactive_30">
                        <option value="" selected="selected">All Projects</option>
                        <option value="1">Inactive Projects</option>
                    </select>
                </div>
            </div>
                           
        </div>

        <div class="row projects_departments_end-start">
		<div class="short-by-filter col-12 text-left ">
		
		<ul>

<li><strong>Start Date: </strong> </li>
          <li>  
           
                <div class="controls">
                    <input type="date" name="start_date" id="start_date" class="form-control datepicker-autoclose" placeholder="Please select start date"> <div class="help-block"></div>
                </div>
          
			</li>
			
			<li><strong>End Date: </strong> </li><li>   
                <div class="controls">
                    <input type="date" name="end_date" id="end_date" class="form-control datepicker-autoclose" placeholder="Please select end date"> <div class="help-block"></div>
                </div>
           
			</li>
           	<li><button type="text" id="btnFiterSubmitSearch" class="click-forword"><img src="{{ URL::asset('custom/images/forword-arrow.svg') }}" alt=""></button>
            
			</li>
            <li class="entire-search"><strong>Search: </strong><input type="text" id="myInputTextField" name="searchdata" placeholder="Search all type projects"></li>
			</ul>
			
        </div>
        </div>
       
		
		<div class="table-res-mobile">
    	<table class="table table-striped table-bordered table-hover new-bullet-class" id="project_list">
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Project Name</th>
                    <th>Department</th>
                    <th>Start Date</th>
                    <th class="text-center">Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
		</div>
		
	<div class="card-footer p-0 card-footer card-foote22 py-2">
       <a class="btn  btn-primary1" href="{{ url('/home') }}" class="btn">Back</a>
       <a href="{{ url('/add-project') }} " class="btn btn-sm btn-primary">Add Project</a>
       <div class="ctm-projects-counts">
           <div class="ctm-projects-counts-inner">
               <strong>Design: </strong>{{$designProjects}}
           </div>
           <div class="ctm-projects-counts-inner">
               <strong>Development: </strong>{{$devProjects}}
           </div>
           <div class="ctm-projects-counts-inner">
               <strong>SEO: </strong>{{$seoProjects}}
           </div>
       </div>
    </div>
    </div>

	<!-- <div>
		<h1>No projects to display</h1>
	</div> -->
@endsection

@push('js')
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="{{{ URL::asset('datatable/datatables.min.js')}}}"></script>
	<script type="text/javascript">
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		 oTable = $('#project_list').DataTable({
                processing: true,
                serverSide: true,
				pageLength: 25,
                ajax: {
                    url: "{{ url('projects-list') }}",
                    type: 'GET',
                    data: function (d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                        d.department = $("#department_id").children("option:selected").val();
                      //  d.status = $("#project_status").children("option:selected").val();
                      //  d.inactive = $("#inactive_30").children("option:selected").val();
                        d.salesExecutive = $("#salesExecutive").children("option:selected").val();
                        d.employees = $("#employees").children("option:selected").val();    
                        d.searchdata = $("#myInputTextField").val();    
                       
                    }
                },	
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'project_title', name: 'project_title', orderable: false },
                    { data: 'department', name: 'departments.department', orderable: false },
                    { data: 'start_date', name: 'start_date', orderable: false },
                    { data: 'status', name: 'status', orderable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                createdRow: function( row,data,dataIndex ){                     

                     if(data.class == "highlighted"){
                        $(row).addClass('highlightedRow');
                        $(row).attr('data-toggle',"tooltip");
                        $(row).attr('title',"Inactive Project Since Last 30 Days.");
                     }      
                }


            });
            
		});
        $('#btnFiterSubmitSearch').click(function(){
            $('#project_list').DataTable().draw(true);
        });
        $("#department_id, #salesExecutive, #employees").on("change",function(e){
            $('#project_list').DataTable().draw(true);
        });

        $('#myInputTextField').keyup(function(){
              oTable.search($(this).val()).draw() ;
        })

        
	</script>
    
    
@endpush