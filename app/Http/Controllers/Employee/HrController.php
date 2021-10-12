<?php

namespace TMS\Http\Controllers\Employee;

use Auth;
use Mail;
use TMS\Dsr;
use TMS\User;
use Datatables;
use TMS\Departments;
use TMS\Designation;
use TMS\DsrEditRequestToken;
use Illuminate\Http\Request;
use TMS\Http\Requests\UserRequest;
use TMS\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class HrController extends Controller
{
    public function __construct()
    {
        $this->middleware('hr');
    }

    public function index(Request $request)
    {
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
		
		$departments = DB::table('departments')
		->select('id','department')
		->get();
		
		$employees = DB::table('users')
		->select('id','name','department_id')
		->where('access_level','!=',1)
		->where('status','=',1)
		->orderBy('department_id','ASC')
		->get();

		return view('employee.hr.viewDsrHr',compact('dsr','employees','departments'));
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
		return view('employee.hr.backdateDsrRequestsHr',compact('backdateDsrRequests'));
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
		
		return redirect('hr/backdate-dsr-requests')->with('status', 'Request approved successfully!');
	}

	/*
	** Section for Adding/Updating Employee
	*/

	public function viewAllEmployeesToHR()
	{
        $users = User::where('access_level', '!=', 1)->where('id','!=','30')->get();
        $departments = Departments::all();
        return view('employee.hr.employees.index', ['users' => $users, 'departments' => $departments]);
	}

    public function filterusers(){ 
        $searchedDepartment = (!empty($_GET["department"])) ? ($_GET["department"]) : ('');

        $usersQuery = DB::table('users')->leftjoin('departments', 'users.department_id', '=', 'departments.id');
        if($searchedDepartment){
            $usersQuery->whereRaw("users.department_id = '" . $searchedDepartment . "'");
        }
        $users = $usersQuery->where("access_level","!=","1")->where('users.id','!=','30')->select('users.*','departments.department')->OrderBy('users.status','DESC')->OrderBy('users.name','ASC');
        
        return datatables()->of($users)->addIndexColumn()->editColumn('name', function ($users) {
                    return '<a href="'. route('hr/view-employee',$users->id) .'" class="">'.$users->name.'</a>';
                })->editColumn('department', function ($users) {
                    return !empty($users->department) ? $users->department : "-" ;
                })->editColumn('status', function ($users) {
                    $status = array(
                        '1' => 'Active',
                        '0' => 'Deactive'
                    );
                    return '<span class="st-'.$status[$users->status].'">'.$status[$users->status].'</span>';
                })->editColumn('email', function ($users) {
                    return '<a href="mailto:'.$users->email.'">'.$users->email.'</a>';
                })->addColumn('action', function ($users) {
                    return '<a class="all_icons" href="'. route('hr/view-employee',$users->id) .'" class=""><img src="'.asset('custom/images/view-icon.svg').'" title="View"></a> <a class="all_icons" href="'. route('hr/edit-employee',$users->id) .'" class=""><img src="'.asset('custom/images/edit-icon.svg').'" title="Edit"></a>';
                })->rawColumns(['name' => 'name','email' => 'email','status' => 'status','action' => 'action'])->make(true);
    }

    public function create()
    {
        $departments = Departments::all();
        $designation = Designation::all();
        return view('employee.hr.employees.create', compact('departments','designation'));
    }

    public function store(UserRequest $request, User $model)
    {
        $allData = $request->merge(['password' => Hash::make($request->get('password'))])->all();
        $allData['access_level'] = '3';
        $data = $model->create($allData);

        DB::table('employee_profile')->insert(['emp_id' => $data->id,'joining_date' => $request->joining_date,'designation_id' => $request->designation]);

        return redirect()->route('hr/employees')->withStatus(__('User successfully created.'));
    }

    public function edit(User $user)
    {
        $userinfo = DB::table('employee_profile')->where('emp_id',$user->id)->first();

        $departments = Departments::all();
        $designation = Designation::all();

        return view('employee.hr.employees.edit', compact('user','departments','designation','userinfo'));
    }

    public function update(UserRequest $request, User $user)
    {
        $hasPassword = $request->get('password');
        $allData = $request->merge(['password' => Hash::make($request->get('password'))])->except([$hasPassword ? '' : 'password']);
        // if($allData['access_level'] == ''){
        //     $allData['access_level'] = '3';
        // }
        $user->update($allData);
        DB::table('employee_profile')->where('emp_id',$user->id)->update(['joining_date' => $request->joining_date,'designation_id' => $request->designation]);
		
		$userData =  DB::table('users')->select('email','name')->where('id','=',$user->id)->first();
		$userEmail = $userData->email;
		
		if($request->get('status') == 1)
		{
			$data = array('title'=>"Willshall",'username'=>$userData->name);
   
			Mail::send('emailTemplates.accountApprovalEmail', $data, function($message) use ($userEmail) {
			$message->to($userEmail)
			->bcc('kirandeep.singh@willshall.com', 'Kirandeep Singh')
			->subject('Account approved on willshall.churnings.com');
			$message->from('pms@willshall.com','Willshall');
			});
		}

        return redirect()->route('hr/employees')->withStatus(__('User successfully updated.'));
    }

    public function viewuser($user_id)
    {
        $users = DB::table('users')
            ->leftjoin('departments', 'users.department_id', '=', 'departments.id')
            ->join('employee_profile', 'users.id', '=', 'employee_profile.emp_id')
            ->leftjoin('designations', 'employee_profile.designation_id', '=', 'designations.id')
            ->select(
			'users.*', 
			'employee_profile.gender',
			'employee_profile.joining_date',
			'employee_profile.core_skills',
			'employee_profile.qualification',
			'employee_profile.dob',
            'employee_profile.marital_status',
			'employee_profile.phone_personal',
			'employee_profile.phone_emergency',
			'employee_profile.address_present',
			'employee_profile.address_permanent',
			'employee_profile.info',
			'departments.department',
            'designations.designation'
			)
            ->where('users.id', $user_id)
            ->first();
        //$users = User::where('id',$user_id)->first();

        // $projects = DB::table('users')
        //                 ->join('project_user_relation','users.id','=','project_user_relation.user_id')
        //                 ->join('projects','project_user_relation.project_id','=','projects.id')
        //                 ->select('projects.project_title','projects.id')
        //                 ->where('users.id', $user_id)
        //                 ->get();
        // return view('employee.hr.employees.viewuser', ['user' => $users, 'projects' => $projects]);


        return view('employee.hr.employees.viewuser', ['user' => $users]);
    }
}
