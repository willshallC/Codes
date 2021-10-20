<?php

namespace TMS\Http\Controllers;

use TMS\User;
use TMS\Departments;
use TMS\Designation;
use TMS\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use TMS\Http\Requests\AdminRequest;
use Auth;
use Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \TMS\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        $users = User::where('access_level', '!=', 1)->where('id','!=','30')->get();
        $departments = Departments::all();
        return view('users.index', ['users' => $users, 'departments' => $departments]);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $departments = Departments::all();
        $designation = Designation::all();
        return view('users.create', compact('departments','designation'));
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \TMS\Http\Requests\UserRequest  $request
     * @param  \TMS\User  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request, User $model)
    {
        $allData = $request->merge(['password' => Hash::make($request->get('password'))])->all();
        if($allData['access_level'] == ''){
            $allData['access_level'] = '3';
        }
        $data = $model->create($allData);

        DB::table('employee_profile')->insert(['emp_id' => $data->id,'joining_date' => $request->joining_date,'designation_id' => $request->designation]);

        return redirect()->route('user.index')->withStatus(__('User successfully created.'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \TMS\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        if ($user->id == 1) {
            return redirect()->route('user.index');
        }
        $userinfo = DB::table('employee_profile')->where('emp_id',$user->id)->first();

        $departments = Departments::all();
        $designation = Designation::all();

        return view('users.edit', compact('user','departments','designation','userinfo'));
    }

    /**
     * Update the specified user in storage
     *
     * @param  \TMS\Http\Requests\UserRequest  $request
     * @param  \TMS\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User  $user)
    {
        $hasPassword = $request->get('password');
        $allData = $request->merge(['password' => Hash::make($request->get('password'))])->except([$hasPassword ? '' : 'password']);
        if($allData['access_level'] == ''){
            $allData['access_level'] = '3';
        }
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
            ->bcc('deepak.kumar@willshall.com', 'Deepak')
            ->subject('Account approved on willshall.churnings.com');
            $message->from('pms@willshall.com','Willshall');
            });
        }

        return redirect()->route('user.index')->withStatus(__('User successfully updated.'));
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \TMS\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User  $user)
    {
        if ($user->id == 1) {
            return abort(403);
        }

        $user->delete();

        return redirect()->route('user.index')->withStatus(__('User successfully deleted.'));
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
        $projects = DB::table('users')
                        ->join('project_user_relation','users.id','=','project_user_relation.user_id')
                        ->join('projects','project_user_relation.project_id','=','projects.id')
                        ->select('projects.project_title','projects.id')
                        ->where('users.id', $user_id)
                        ->get();
        return view('users.viewuser', ['user' => $users, 'projects' => $projects]);
    }

    public function filterusers(){
        $searchedDepartment = (!empty($_GET["department"])) ? ($_GET["department"]) : ('');

        $usersQuery = DB::table('users')->leftjoin('departments', 'users.department_id', '=', 'departments.id');
        if($searchedDepartment){
            $usersQuery->whereRaw("users.department_id = '" . $searchedDepartment . "'");
        }
        $users = $usersQuery->where("access_level","!=","1")->where('users.id','!=','30')->select('users.*','departments.department')->OrderBy('users.status','DESC')->OrderBy('users.name','ASC');

        // '<a href="#" class="delete_confirm">XX</a>';
        
        return datatables()->of($users)->addIndexColumn()->editColumn('name', function ($users) {
                    return '<a href="'. route('view-user',$users->id) .'" class="">'.$users->name.'</a>';
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
                    return '<a class="all_icons" href="'. route('view-user',$users->id) .'" class=""><img src="'.asset('custom/images/view-icon.svg').'" title="View"></a> <a class="all_icons" href="'. route('user.edit',$users->id) .'" class=""><img src="'.asset('custom/images/edit-icon.svg').'" title="Edit"></a>';
                })->rawColumns(['name' => 'name','email' => 'email','status' => 'status','action' => 'action'])->make(true);
    }

    // To view all Admins
    public function allAdmins(){
        $adminId =  Auth::id();
        $admins = DB::table('users')->leftjoin('employee_profile','employee_profile.emp_id','=','users.id'    )
                ->select(
                    'users.name',
                    'users.email',
                    'users.status',
                    'users.id'
                )->where('users.id','!=',$adminId)->where('users.access_level','1')->get();
        return view('superAdmin.index',compact('admins'));
    }

    // To add New Admin User
    public function addAdmin(){
        return view('superAdmin.addAdmin');
    }

    // To save New Admin User
    public function saveAdmin(AdminRequest $request, User $model){
        $alldata = $request->merge(['password' => Hash::make($request->get('password'))])->all();
        $alldata['access_level'] = '1';
        $alldata['profile_pic'] = 'willshall.svg';
        $alldata['department_id'] = '0';
        $data = $model->create($alldata);
        DB::table('employee_profile')->insert(['emp_id' => $data->id]);

        return redirect('admins')->with('status', 'Admin added successfully!');
    }

    // To edit Admin User
    public function editAdmin(User $admin){
        return view('superAdmin.addAdmin',compact('admin'));
    }

    // To save Edited Admin User
    public function saveEditedAdmin(AdminRequest $request, User $admin){
        $hasPassword = $request->get('password');
        $admin->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except([$hasPassword ? '' : 'password']
        ));

        return redirect('admins')->with('status', 'Admin updated successfully!');
    }
}
