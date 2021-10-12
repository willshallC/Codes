<?php

namespace TMS\Http\Controllers;

use TMS\Projects;
use TMS\Dsr;
use TMS\Departments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index(Request $request)
    {	 
		$project = $request->get('project') !== null ? $request->get('project') : "" ;
		$department = $request->get('department') !== null ? $request->get('department') : "";
		$employee = $request->get('employee') !== null ? $request->get('employee') : "";
		
		$projects = Projects::select('id','project_title')->orderBy('project_title','ASC')->get();
		$departments = Departments::all();
		
		$employees = DB::table('users')
		->select('id','name','department_id')
		->where('access_level','!=',1)
		->where('status','=',1)
		->orderBy('department_id','ASC')
		->get();

		$dsr = Dsr::select('*');

		$dsr = DB::table('dsr')
		->join('users', 'users.id', '=', 'dsr.employee_id')
		->join('departments', 'departments.id', '=', 'users.department_id')
		->join('projects', 'projects.id', '=', 'dsr.project_id')
		->join('categories', 'categories.id', '=', 'dsr.category_id')
		->leftjoin('subcategories', 'subcategories.id', '=', 'dsr.subcategory_id')
		->select('categories.category', 'subcategories.subcategory',
		'users.id as user_id','users.name','departments.department','projects.project_title',
		'dsr.id as dsr_id','dsr.dsr_date','dsr.time_spent','dsr.description');

		if($project != "")
		{
			$dsr->where('project_id', '=', $project);
		}
		if($department != "")
		{
			$dsr->where('departments.id', '=', $department);
		}
		if($employee != "")
		{
			$dsr->where('employee_id', '=', $employee);
		}
		$dsr->orderBy('employee_id','DESC');
		$dsr->orderBy('dsr_date','DESC');
		$dsr = $dsr->get();

		// $dsr = DB::table('dsr')
		// ->join('users', 'users.id', '=', 'dsr.employee_id')
		// ->join('departments', 'departments.id', '=', 'users.department_id')
		// ->join('projects', 'projects.id', '=', 'dsr.project_id')
		// ->join('categories', 'categories.id', '=', 'dsr.category_id')
		// ->leftjoin('subcategories', 'subcategories.id', '=', 'dsr.subcategory_id')
		// ->select('categories.category', 'subcategories.subcategory',
		// 'users.id as user_id','users.name','departments.department','projects.project_title',
		// 'dsr.id as dsr_id','dsr.dsr_date','dsr.time_spent','dsr.description');

    	return view('reports.reports',compact('employees','projects','dsr','departments'));
    }
}
