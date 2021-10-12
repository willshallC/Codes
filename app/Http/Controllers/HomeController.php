<?php

namespace TMS\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
		
		$first_day_this_month = date('Y-m-01'); // hard-coded '01' for first day
		$last_day_this_month  = date('Y-m-t');
		
		$seo_Projects_active = DB::table('projects')
		->select('id','project_title','start_date','status')
        ->where('department_ids','=',3)
		->where('status','=',1)
        ->whereBetween('start_date', [$first_day_this_month, $last_day_this_month])
        ->orderBy('start_date','ASC')
		->get();
		
		$seo_Projects_pause = DB::table('projects')
		->select('id','project_title','start_date','status')
        ->where('department_ids','=',3)
		->whereIn('status', [2, 3])
        ->whereBetween('start_date', [$first_day_this_month, $last_day_this_month])
        ->orderBy('start_date','ASC')
		->get();
		
		$dev_design_Projects_active = DB::table('projects')
		->select('id','project_title','start_date','status')
		->whereIn('department_ids', [1, 2])
		->where('status','=',1)
        ->whereBetween('start_date', [$first_day_this_month, $last_day_this_month])
        ->orderBy('start_date','ASC')
		->get();
		
		$dev_design_Projects_pause = DB::table('projects')
		->select('id','project_title','start_date','status')
		->whereIn('department_ids', [1, 2])
		->whereIn('status', [2, 3])
        ->whereBetween('start_date', [$first_day_this_month, $last_day_this_month])
        ->orderBy('start_date','ASC')
		->get();
		
		$bids_this_month = DB::table('business_analyst_work_sheet')
		->select('id')
        ->whereBetween('date', [$first_day_this_month, $last_day_this_month])
		->count();


		 $hired_this_month = DB::table('business_analyst_work_sheet')
		->join('users','users.id','=','business_analyst_work_sheet.employee_id')
		->selectRaw("business_analyst_work_sheet.employee_id as emp_id, users.name as u_name, profile_pic, (SELECT count('id') from `business_analyst_work_sheet` where employee_id = emp_id and `date` between '".$first_day_this_month."' AND '".$last_day_this_month."') as bids_count , (SELECT count('id') from `business_analyst_work_sheet` where employee_id = emp_id and status = 3 and `date` between '".$first_day_this_month."' AND '".$last_day_this_month."') as hired_count,(SELECT count('id') from `projects` where sales_executive = emp_id and department_ids = 3 and status = 1 and `start_date` between '".$first_day_this_month."' AND '".$last_day_this_month."') as secured_seo_projects, (SELECT count('id') from `projects` where sales_executive = emp_id and department_ids IN (1,2) and status = 1 and `start_date` between '".$first_day_this_month."' AND '".$last_day_this_month."') as secured_dev_design_projects,(SELECT count('id') from `projects` where sales_executive = emp_id and status IN (2,3) and `start_date` between '".$first_day_this_month."' AND '".$last_day_this_month."') as closed_projects")
		->whereBetween('business_analyst_work_sheet.date', [$first_day_this_month, $last_day_this_month])
		->where('users.status','1')
		->where(function ($q) {
	        $q->where('business_analyst_work_sheet.status','=',Null)
            ->orWhere('business_analyst_work_sheet.status','=',"1");
		})
		// ->where('business_analyst_work_sheet.status','=',Null)
		// ->orWhere('business_analyst_work_sheet.status','=',"1")
		->groupBy('emp_id','u_name','profile_pic')
		->get();
		// ->toSql();
		// echo $hired_this_month;die;



        if($user['access_level'] == 1 && $user['status'] == 1){
            return view('dashboard',compact('seo_Projects_active','seo_Projects_pause','dev_design_Projects_active','dev_design_Projects_pause','bids_this_month','hired_this_month'));
        }else if($user['access_level'] != 1 && $user['status'] == 1){
            return view('employee.emp-dashboard');
        }else{
            Auth::logout();
            return redirect('login')->withErrors(['error' => 'Please ask Admin to approve your account.']);
        }
    }
}
