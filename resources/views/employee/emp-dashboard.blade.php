@extends('employee.layouts.emp-app', ['pageSlug' => 'dashboard'])

@section('content')
    <div class="row">
        <div class="col-12">
			
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
           
        </div>
        <div class="col-lg-4">
            
        </div>
        <div class="col-lg-4">
            
        </div>
    </div>
    <div class="row">
        
    </div>
@endsection

@push('js')
    <script src="{{ asset('black') }}/js/plugins/chartjs.min.js"></script>
    <script>
        $(document).ready(function() {
          demo.initDashboardPageCharts();
        });
    </script>
@endpush
