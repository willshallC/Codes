@extends('layouts.app', ['page' => __('Employee Management'), 'pageSlug' => 'users'])

@section('content')
@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif
<div class="employes_user_index1">
    <div class="row">
      <div class="col-md-12">
          <div class="card ">
              <h4 class="card-title">{{ __('Employees') }}</h4>
          </div>
      </div>
      <div class="form-group col-md-3 slect_employees">
        <div class="controls">
            <select id="department_id" class="form-control" name="department">
                <option value="" selected="selected">Select Department</option>
                @foreach($departments as $val)
                <option value="{{ $val->id }}">{{ $val->department }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="table-res-mobile">
    <table class="table table-striped table-bordered table-hover new-bullet-class" id="user_list">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Full Name</th>
                <th>Department</th>
                <th>Email</th>
                <th class="text-center">Status</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

<div class="card-footer p-0 card-footer card-foote22 py-2">

   <a class="btn  btn-primary1" href="{{ route('home') }}">Back</a>
   <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">{{ __('Add Employee') }}</a>
</div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@endsection


@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{{ URL::asset('datatable/datatables.min.js')}}}"></script>
<script type="text/javascript">
    function ConfirmDialog(message){
        $('<div></div>').appendTo('body')
        .html('<div><h6>' + message + '?</h6></div>')
        .dialog({
            modal: true,
            title: 'Delete message',
            zIndex: 10000,
            autoOpen: true,
            width: 'auto',
            resizable: false,
            buttons: {
                Yes: function() {
                  // $(obj).removeAttr('onclick');                                
                  // $(obj).parents('.Parent').remove();

                    $('body').append('<h1>Confirm Dialog Result: <i>Yes</i></h1>');

                    $(this).dialog("close");
                },
                No: function() {
                    $('body').append('<h1>Confirm Dialog Result: <i>No</i></h1>');
                    $(this).dialog("close");
                }
            },
            close: function(event, ui) {
                $(this).remove();
            }
        });
    };
    $(document).on("click","a.delete_confirm",function(e){
        $("a.delete_confirm").attr("id","");
        $(this).attr("id","to_delete");
        ConfirmDialog('Are you sure you want to delete this User?');
    });
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#user_list').DataTable({
            processing: true,
            serverSide: true,
			pageLength: 15,
            ajax: {
                url: "{{ url('user-list') }}",
                type: 'GET',
                data: function (d) {
                    d.department = $("#department_id").children("option:selected").val();
                }
            },
            columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false  },
            { data: 'name', name: 'name' },
            { data: 'department', name: 'departments.department' },
            { data: 'email', name: 'email' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
        // $('#btnFiterSubmitSearch').click(function(){
        //     $('#project_list').DataTable().draw(true);
        // });
        $("#department_id").on("change",function(e){
            $('#user_list').DataTable().draw(true);
        });
    </script>
    @endpush
