<?php $user = auth()->user();
if($user->access_level == "1"){
    $layout = 'layouts.app';
}else if($user->access_level == "3"){
    $layout = 'employee.layouts.emp-app';
}
?>

@extends($layout, ['pageSlug' => 'mirror-sheet'])

@section('content')
<?php //echo '<pre>';print_r($user);echo'</pre>';die; ?>

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


<div class="main_listing_projects1">
    <div class="">
        <h2>Tasks</h2>
    </div>

    <div class="row projects_departments">
        <div class="form-group col-md-4">
            <div class="controls">
                <select id="projects" class="form-control" name="projects">
                    <option value="" selected="selected">Select Website</option>
                    <option value="IM">IM</option>
                    <option value="ML">ML</option>
                    <option value="BCW">BCW</option>
                </select>
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="controls">
                <select id="status" class="form-control" name="status">
                    <option value="" selected="selected">Select Status</option>
                    <option value="1">Not Started Yet</option>
                    <option value="2">Working</option>
                    <option value="3">Waiting for Feedback</option>
                    <option value="4">Working on Bug Fixing</option>
                    <option value="5">Working on Additional Changes</option>
                    <option value="6">Done</option>
                </select>
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="controls">
                <select id="payment_status" class="form-control" name="paymentstatus">
                    <option value="" selected="selected">Select Payment Status</option>
                    <option value="1">Paid</option>
                    <option value="2">Unpaid</option>
                </select>
            </div>
        </div>
    </div>

    <div class="table-res-mobile">
        <table class="table table-striped table-bordered table-hover new-bullet-class" id="tasks_list">
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Website</th>
                    <th>Upwork Code</th>
                    <th>Quote</th>
                    <th>Amount($)</th>
                    <th>Status</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

    <div class="card-footer p-0 card-footer card-foote22 py-2">
        <a class="btn  btn-primary1" href="{{ url('/home') }}" class="btn">Back</a>
        <a href="{{ url('/add-task') }} " class="btn btn-sm btn-primary">Add Task</a>
    </div>
</div>
@endsection

@push('js')
<script src="{{{ URL::asset('datatable/datatables.min.js')}}}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#tasks_list').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 25,
            ajax: {
                url: "{{ url('task-list') }}",
                type: 'GET',
                data: function (d) {
                    d.website = $("#projects").children("option:selected").val();
                    d.status = $("#status").children("option:selected").val();
                    d.payment_status = $("#payment_status").children("option:selected").val();
                    console.log(d);
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'website', name: 'website', orderable: false },
                { data: 'upwork_code', name: 'upwork_code', orderable: false },
                { data: 'quote', name: 'quote', orderable: false },
                { data: 'amount', name: 'amount', orderable: false },
                { data: 'status', name: 'status', orderable: false },
                { data: 'payment_status', name: 'payment_status', orderable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
    $("#projects, #status, #payment_status").on("change",function(e){
        $('#tasks_list').DataTable().draw(true);
    });
</script>
@endpush