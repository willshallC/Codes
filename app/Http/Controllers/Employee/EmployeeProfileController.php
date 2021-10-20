<?php

namespace TMS\Http\Controllers\Employee;

use Auth;
use TMS\User;
use TMS\Projects;
use TMS\Departments;
use TMS\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class EmployeeProfileController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \TMS\User  $model
     * @return \Illuminate\View\View
     */
    public function index()
    {
		$userId =  Auth::id();
		$user = User::findOrFail($userId);
		
		$user = DB::table('users')
		->join('departments','departments.id','=','users.department_id')
		->leftjoin('employee_profile','employee_profile.emp_id','=','users.id')
		->leftjoin('designations','designations.id','=','employee_profile.designation_id')
          ->select(
			'users.name',
			'users.email',
			'users.status',
			'departments.department',
			'employee_profile.gender',
			'employee_profile.joining_date',
			'designations.designation',
			'employee_profile.core_skills',
			'employee_profile.qualification',
			'employee_profile.dob',
			'employee_profile.phone_personal',
			'employee_profile.phone_emergency',
			'employee_profile.address_present',
			'employee_profile.address_permanent',
			'employee_profile.marital_status',
			'employee_profile.info',
			
          )->where('users.id','=',$userId)->get()->toArray();
		
		$user = $user[0];
		
		return view('employee.emp-profile',compact('user'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \TMS\User  $user
     * @return \Illuminate\View\View
     */
    public function edit()
    {
       $userId =  Auth::id();
	   $user = User::findOrFail($userId);
		
		$user = DB::table('users')
		->join('departments','departments.id','=','users.department_id')
		->join('employee_profile','employee_profile.emp_id','=','users.id')
		->leftjoin('designations','designations.id','=','employee_profile.designation_id')
          ->select(
			'users.name',
			'users.email',
			'users.status',
			'users.department_id',
			'departments.department',
			'employee_profile.gender',
			'designations.designation',
			'employee_profile.joining_date',
			'employee_profile.phone_personal',
			'employee_profile.phone_emergency',
			'employee_profile.address_present',
			'employee_profile.address_permanent',
			'employee_profile.marital_status',
			'employee_profile.core_skills',
			'employee_profile.qualification',
			'employee_profile.dob',
			'employee_profile.info',
			
          )->where('users.id','=',$userId)->first();
		
		return view('employee.emp-editProfile',compact('user'));
    }
	
	
	/*show change password form to user*/
	public function updatePassword()
    {
	   return view('employee.emp-editPassword');
	}


	/* To update User Password */
    public function savePassword(Request $request){
		$userId =  Auth::id();
		$validator = Validator::make($request->all(), [
					        'old_password' => 'required|min:6',
					        'password' => 'required|min:6|confirmed',
					        'password_confirmation' => 'required|min:6'
				        ],
				        $messages = [
						    'old_password.required' => 'Old Password field is required.',
						    'password.required' => 'New Password field is required.',
							'password.confirmed' => 'Confirm Password must match with Password field.',
							'password_confirmation.required' => 'Confirm Password field is required.'
						]
			    	);
					
		$old_password = DB::table('users')->select('password')->where('id', $userId)->first();

        if ($validator->fails()) {
            return redirect('update-password')
                        ->withErrors($validator)
                        ->withInput();
        }

		if(!Hash::check($request->old_password,$old_password->password))
		{
			return redirect('update-password')
				->withErrors(['error'=>'Please fill correct Old Password.']);
		}
		
		$alldata = $request->all();
		unset($alldata['_token']);
		
		$newPassword =  Hash::make($request->password);
		
		DB::table('users')->where('id', $userId)->update(array('password' =>$newPassword));
		return redirect('update-password')->with('status', 'Profile updated successfully!');
	}
	
	
    /* To update User Profile */
    public function saveProfile(Request $request){		
		$userId =  Auth::id();
		$validator = Validator::make($request->all(), [
					        'gender' => 'required',
					        'phone_personal' => 'required|regex:/[0-9]{9}/',
					        'phone_emergency' => 'required',
					        'address_present' => 'required',
                            'address_permanent' => 'required',
					        'qualification' => 'required',
					        'core_skills' => 'required',
                            'dob' => 'required',
                            'marital_status' => 'required',
				        ],
				        $messages = [
						    'gender.required' => 'Gender field is required.',
						    'phone_personal.required' => 'Phone Number (Personal) field is required.',
						    'phone_emergency.required' => 'Phone Number (Emergency) field is required.',
						    'address_present.required' => 'Address (Present) field is required.',
						    'address_permanent.required' => 'Address (Permanent) field is required.',
						    'qualification.required' => 'Qualification field is required.',
						    'core_skills.required' => 'Core Skills field is required.',
						    'dob.required' => 'DoB field is required.',
						    'marital_status.required' => 'Marital Status field is required.'
						]
			    	);

        if ($validator->fails()) {
            return redirect('edit-profile')
                        ->withErrors($validator)
                        ->withInput();
        }
		
		$alldata = $request->all();
		//dd($alldata);
		unset($alldata['_token']);
		unset($alldata['photo']);
		
		
		
		
		if($request->hasFile('photo'))
		{
		
			$allowedfileExtension=['jpg','png'];
			$files = $request->file('photo');
			foreach($files as $file)
			{
				//$filename = $file->getClientOriginalName();
				$extension = $file->getClientOriginalExtension();
				$check=in_array($extension,$allowedfileExtension);
				//dd($check);
				if($check)
				{
					//$items= Item::create($request->all());
					//foreach ($request->photo as $photo) {
					$filename = $file->store('public');
					$filename = explode("public/",$filename);
					echo $filename = $filename[1];
					//print_r($filename);
					/*ItemDetail::create([
					'item_id' => $items->id,
					'filename' => $filename
					]);*/
					//}
					
					
				
					DB::table('users')->where('id', $userId)->update(array('profile_pic' =>$filename));
				}
				else
				{
					return redirect('edit-profile')->withErrors(['error'=>'Sorry only upload png , jpg files.']);
				}
			}
		}
		
		try {
		    DB::table('employee_profile')->where('emp_id', $userId)->update($alldata);
		    return redirect('edit-profile')->with('status', 'Profile updated successfully!');
		} catch (\Illuminate\Database\QueryException $e) {
			return redirect('edit-profile')->withErrors(['error' => $e->errorInfo[2]]);
		}
    }



    /**
     * Update the specified user in storage
     *
     * @param  \TMS\Http\Requests\UserRequest  $request
     * @param  \TMS\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \TMS\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy()
    {
       
    }
	
	
	/**
	* Remove the specified user from storage
	*
	* @param  \TMS\User  $user
	* @return \Illuminate\Http\RedirectResponse
	*/
	
	public function assignedProjects()
    {
		$userId =  Auth::id();
		
		$assignedProjects = DB::table('projects')
		->join('project_user_relation','project_user_relation.project_id','=','projects.id')
		->join('departments','departments.id','=','projects.department_ids')
        ->select(
			'projects.id',
			'projects.project_title',
			'projects.start_date',
			'projects.status',
			'departments.department',
        )
		  ->where('project_user_relation.user_id','=',$userId)
		  ->where('project_user_relation.relation_status','=',1)
		  ->orderBy('projects.id', 'desc')
		  ->get()->toArray();
		
		return view('employee.emp-assignedProjects',compact('assignedProjects'));
    }
	
	public function viewproject($project_id)
    {
		$userId =  Auth::id();
		$project = Projects::findOrFail($project_id);
		
		$project = DB::table('projects')->leftjoin('users','users.id','=','projects.sales_executive')
		->select(
		'projects.*',
		'users.name',
		)
		->where('projects.id','=',$project_id)->first();
		
		$time_spent = DB::select(DB::raw("select (select sum(time_spent) from dsr where employee_id = $userId and project_id = $project_id) as time_by_me, sum(time_spent) as total_time_spent from dsr where project_id = $project_id"));
		
		return view('employee.emp-viewProject',compact('project','time_spent'));
    }
	 
	
}
