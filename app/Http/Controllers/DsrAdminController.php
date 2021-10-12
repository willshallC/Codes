<?php

namespace TMS\Http\Controllers;

use TMS\Dsr;
use TMS\DsrEditRequestToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use Mail;

class DsrAdminController extends Controller
{
	public function index(Request $request){
	 	$employeeWorked = "";
		$department = $request->get('department') !== null ? $request->get('department') : "" ;
		$employee = $request->get('employee') !== null ? $request->get('employee') : "";
		$date = $request->get('date') !== null ?  date("Y-m-d", strtotime($request->get('date'))) :  date('Y-m-d');
		$start_date = $request->get('start_date') !== null ? date("Y-m-d", strtotime($request->get('start_date'))) : date('Y-m-d');
		$end_date = $request->get('end_date') !== null ? date("Y-m-d", strtotime($request->get('end_date'))) : date('Y-m-d');
		$hdn_date = $request->get('hdn_date') !== null ? $request->get('hdn_date') : "date";
		
		//$date = $employee == "" && $date == "" ?  date('Y-m-d') : $date;
		
		$dsr = DB::table('dsr')
		->join('users', 'users.id', '=', 'dsr.employee_id')
		->join('departments', 'departments.id', '=', 'users.department_id')
		->join('projects', 'projects.id', '=', 'dsr.project_id')
		->join('categories', 'categories.id', '=', 'dsr.category_id')
		->leftjoin('subcategories', 'subcategories.id', '=', 'dsr.subcategory_id')
		->select('categories.category', 'subcategories.subcategory',
		'users.id as user_id','users.name','departments.department','projects.project_title',
		'dsr.id as dsr_id','dsr.dsr_date','dsr.time_spent','dsr.description');

		if($department != "")
		{
			$dsr->where('users.department_id', '=', $department);
		}
		if($employee != "")
		{
			$dsr->where('users.id', '=', $employee);
		}
		if($hdn_date == 'date')
		{
			$dsr->where('dsr.dsr_date', '=', $date);
		}
		else if($hdn_date == 'range')
		{
			
			$dsr->whereBetween('dsr.dsr_date', [$start_date, $end_date]);
		}
		
		$dsr->where('projects.is_deleted','0');
		$dsr->orderBy('dsr_date','DESC');
		$dsr->orderBy('departments.id','ASC');
		$dsr->orderBy('users.id','ASC');
		$dsr = $dsr->get();
		
		if($hdn_date == 'range')
		{
			$employeeWorked = DB::table('dsr')->where('employee_id', '=', $employee)->whereBetween('dsr_date', [$start_date, $end_date])->distinct()->get('dsr_date');;
		}
		
		$departments = DB::table('departments')
		->select('id','department')
		->get();
		
		$employees = DB::table('users')
		->select('id','name','department_id')
		->where('access_level','!=',1)
		->where('status','=',1)
		->orderBy('department_id','ASC')
		->get();

		return view('dsrAdmin.viewDsrAdmin',compact('dsr','employees','departments','employeeWorked'));
    }
	
	public function viewDsrEntry($id)
	{
		$dsr = Dsr::findOrFail($id);
		$dsr = DB::table('dsr')
		->join('users', 'users.id', '=', 'dsr.employee_id')
		->join('departments', 'departments.id', '=', 'users.department_id')
		->join('projects', 'projects.id', '=', 'dsr.project_id')
		->join('categories', 'categories.id', '=', 'dsr.category_id')
		->leftjoin('subcategories', 'subcategories.id', '=', 'dsr.subcategory_id')
		->select('categories.category', 'subcategories.subcategory',
		'users.id as user_id','users.name','departments.department','projects.project_title',
		'dsr.id as dsr_id','dsr.dsr_date','dsr.time_spent','dsr.description')
		->where('dsr.id', '=', $id)
		->where('projects.is_deleted','0')
		->first();
		
		return view('dsrAdmin.viewDsrEntry',compact('dsr'));

	}
	
	public function viewDsrBackDateEntries()
	{
		$backdateDsrRequests = DB::table('dsr_edit_request_token')
		->join('users', 'users.id', '=', 'dsr_edit_request_token.employee_id')
		->join('departments', 'departments.id', '=', 'users.department_id')
		->select('dsr_edit_request_token.*','users.name','departments.department')
		->where('users.status', '=', 1)
		->where('token_number','=',NULL)
		->orderBy('users.name', 'ASC')
		->get()->toArray();
		return view('dsrAdmin.backdateDsrRequests',compact('backdateDsrRequests'));
	}
	
	public function approveBackdateDsrRequest($id)
	{
		$dsrEditToken = DsrEditRequestToken::findOrFail($id);
		$str = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1";
		$token = '';
		
		for($i=0;$i <= 7; $i++)
		{
			$randNumber = rand(0,60);
			$token .= $str[$randNumber];
		}
		
		$dsrEditToken->issued_by = Auth::id();
		$dsrEditToken->issued_at = date('Y-m-d H:i:s');
		$dsrEditToken->valid_till_date =  now();
		$dsrEditToken->token_number = $token;
		$dsrEditToken->save();
		
		return redirect('backdate-dsr-requests')->with('status', 'Request approved successfully!');
	}

	public function SendEmailNotfillDsr(){

		$date = date('Y-m-d', strtotime("-1 days"));
		$users = DB::table('dsr')
		->select('employee_id')
		->where('dsr_date','=',$date)
		->groupBy('employee_id')
		->pluck('employee_id')->toArray();
	
	    $total_users = DB::table('users')
		->select('id')
		->where('status','=',1)
		->where('department_id','!=',0)
		->where('department_id','!=',4)	
		->pluck('id')->toArray();	

		$result = array_diff($total_users, $users);

		$user_data = array();

		foreach ($result as $id){ 

		  	$data = DB::table('users')
			->select('name','id')
			->where('status','=',1)
			->where('department_id','!=',0)	
			->where('department_id','!=',4)	
			->where('id','=',$id)	
			->get();

			$user_data[] = $data; 	

		   // $obj = json_decode($data);
		   // $username = $obj[0]->name;
		   // $userId = $obj[0]->id;

		}
		
		$data = array('name'=>$user_data);

		if(count($user_data) > '0'){
			Mail::send('emailTemplates.tmsDefaulterEmail', $data, function($message){
		             $message->to('sachin@willshall.com', 'Sachin')
		            ->to('manoj@willshall.com', 'Manoj')
		            ->to('hr@willshall.com', 'HR')
		            ->bcc('neha.kumari@willshall.com', 'Neha')
		            ->bcc('kirandeep.singh@willshall.com', 'Kirandeep')
		            ->subject('List of employees who have not filled PMS');
		            $message->from('pms@willshall.com','Willshall');
		        });
		}else{

			echo "No user available.";
		}

	}

	/**********************Inactive project**************************/

	public function InactiveProject(){

		$to = 'devformtesting@gmail.com';
		$subject = 'Email Testing';
		$message = 'Hi this is Testing'; 
		$from = 'willshall@churnings.com';
		 
		// Sending email
		if(mail($to, $subject, $message)){
		    echo 'Your mail has been sent successfully.';
		} else{
		    echo 'Unable to send email. Please try again.';
		}
		


	$projects = DB::table('projects')
		->select('id')
		->where('status','=',1)
		->pluck('id')->toArray();
	

	$total_dsr_project = array();	

		foreach ($projects as $value) {
			    $dsr_project_id = $value;
				$dsr_project = DB::table('dsr')
					->select('project_id','dsr_date')
					->where('project_id','=',$dsr_project_id)
					->whereDate('created_at', '>', Carbon::now()->subDays(30))
	                ->get();
				
				$total_dsr_project[] = $dsr_project;
		}

	$single_value = array();

			foreach ($total_dsr_project as $key => $value) {

				$obj = json_decode($total_dsr_project[$key]);	
				$data_value = $obj;		
			
				foreach ($data_value as $data_arr_value) {
					$test =  $data_value[0]->project_id;
					$single_value[] = $test;
				}
		}	

	$unique_array = array_unique($single_value);
	$array_diff = array_diff($projects, $unique_array);
	$list_projects = array();

			foreach ($array_diff as $inc_prj) { 
				$inactive_project = DB::table('projects')
				->select('project_title','id')
				->where('status','=',1)
				->where('id','=',$inc_prj)
				->get();
				// $obj = json_decode($inactive_project);
				// echo $obj[0]->project_title;
				$list_projects[] = $inactive_project; 					
			} 
				$data = array('name'=>$list_projects);
				if(count($list_projects)>0){
					
				 	Mail::send('emailTemplates.inactiveProjectEmail', $data, function($message){
				            $message->to('neha.kumari@willshall.com', 'Neha')
				            ->subject('List Of Inactive Projects since last 30 days');
				            $message->from('pms@willshall.com','Willshall');
				    });

				}else{

					echo "No Projects Available.";
				}

	}

		


}
