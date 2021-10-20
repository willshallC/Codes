<?php

namespace TMS\Http\Controllers\Employee;

use TMS\User;
use TMS\Dsr;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TMS\Http\Controllers\Controller;

class TlDsrController extends Controller
{
    public function index(Request $request)
    {
		$employee = $request->get('employee') !== null ? $request->get('employee') : "";
		$start_date = $request->get('start_date') !== null ? date("Y-m-d", strtotime($request->get('start_date'))) : '';
		$end_date = $request->get('end_date') !== null ? date("Y-m-d", strtotime($request->get('end_date'))) : '';

    	$logged_employee_department = User::select('department_id')->where('id',Auth::id())->first()->department_id;
    	$employees = User::where('department_id',$logged_employee_department)->where('id','!=',Auth::id())->get();
		$dsr = DB::table('dsr')
				->join('projects', 'projects.id', '=', 'dsr.project_id')
				->join('categories', 'categories.id', '=', 'dsr.category_id')
				->leftjoin('subcategories', 'subcategories.id', '=', 'dsr.subcategory_id')
				->join('users', 'users.id', '=', 'dsr.employee_id')
				->select('categories.category', 'subcategories.subcategory','projects.project_title','dsr.dsr_date','dsr.time_spent','dsr.description','dsr.id','users.id as user_id','users.name as name');

		if($employee != "")
		{
			$dsr->where('users.id', '=', $employee);
		}
		if($start_date != '' && $end_date != ''){
			$dsr->whereBetween('dsr.dsr_date', [$start_date, $end_date]);
		}else if($start_date != ''){
			$dsr->where('dsr.dsr_date',$start_date);
		}else{
			$dsr->where('dsr.dsr_date',date('Y-m-d'));
		}

		$dsr = $dsr->where('users.department_id',$logged_employee_department)
					->where('projects.is_deleted','0')
					->where('users.id','!=',Auth::id())
					->orderBy('dsr_date','DESC')
					->orderBy('users.id','ASC')
					->get();

    	return view('employee.tl.teamDsr.viewTeamDsr',compact('employees','dsr'));
    }
}
