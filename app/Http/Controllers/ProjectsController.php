<?php

namespace TMS\Http\Controllers;

use Illuminate\Http\Request;
use TMS\Projects;
use TMS\Departments;
use TMS\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Config;
use Datatables;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ProjectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $departments = Departments::all();
        $sales_executive = User::select('id','name')->where('department_id','4')->where('status','=','1')->orderBy('users.name', 'ASC')->get();
        $employees = User::select('id','name')->where('access_level','!=','1')->where('status','=','1')->where('id','!=','30')->orderBy('name', 'ASC')->get();

        $designProjects = Projects::where('department_ids',2)->where('status',1)->where('is_deleted','0')->count();
        $devProjects = Projects::where('department_ids',1)->where('status',1)->where('is_deleted','0')->count();
        $seoProjects = Projects::where('department_ids',3)->where('status',1)->where('is_deleted','0')->count();
        // echo "Design = ".$designProjects."<br>Dev = ".$devProjects."<br>Seo = ".$seoProjects;
        // die;

        return view('projects.projects', ['departments' => $departments, 'salesExecutive' => $sales_executive, 'employees' => $employees, 'designProjects' => $designProjects, 'devProjects' => $devProjects, 'seoProjects' => $seoProjects]);
    }

    public function filterprojects(){


        $start_date = (!empty($_GET["start_date"])) ? ($_GET["start_date"]) : ('');
        $end_date = (!empty($_GET["end_date"])) ? ($_GET["end_date"]) : ('');
        $searchedDepartment = (!empty($_GET["department"])) ? ($_GET["department"]) : ('');
       // $searchedstatus = (!empty($_GET["status"])) ? ($_GET["status"]) : ('');
        $inactiveStatus = (!empty($_GET["inactive"])) ? ($_GET["inactive"]) : ('');
        $salesExecutive = (!empty($_GET["salesExecutive"])) ? ($_GET["salesExecutive"]) : ('');
        $employees = (!empty($_GET["employees"])) ? ($_GET["employees"]) : ('');
        $searchdata = (!empty($_GET["searchdata"])) ? ($_GET["searchdata"]) : ('');

        $projectsQuery = DB::table('projects')->join('departments', 'projects.department_ids', '=', 'departments.id')->where('projects.status','=','1');

        if($employees){
            $projectsQuery->leftJoin('project_user_relation', 'projects.id', '=', 'project_user_relation.project_id');
        }
        
        //if($inactiveStatus == '1'){
           $before30Days = date('Y-m-d', strtotime('-30 days'));
          // $currentdate = date('Y-m-d');

           // $dataQuery = $projectsQuery->join('dsr', 'projects.id', '=', 'dsr.project_id')
           //            ->select('project_id', DB::raw('MAX(dsr.dsr_date) AS date_updated'))
           //            ->whereRaw('projects.status = 1 AND dsr.project_id = projects.id')
           //            ->groupBy('dsr.project_id')
           //            ->havingRaw('MAX(dsr.dsr_date) < "'.$before30Days.'"');

           $dataQuery = DB::table('projects')
                        ->join('departments', 'projects.department_ids', '=', 'departments.id')
                        ->where('projects.status','=','1')
                        ->join('dsr', 'projects.id', '=', 'dsr.project_id')
                        ->select('project_id')
                        ->whereRaw('dsr.project_id = projects.id')
                        ->groupBy('dsr.project_id')
                        ->havingRaw('MAX(dsr.dsr_date) < "'.$before30Days.'"')->get(); 
                  
                        $invalidID = array(); 

	                    	foreach ($dataQuery as $value) {
	                           $invalidID[] = $value->project_id; 
	                        }

                        $invalidID_array = implode(',', $invalidID);  

       //}
       
        if($start_date && $end_date){
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));
            $projectsQuery->whereRaw("date(projects.start_date) >= '" . $start_date . "' AND date(projects.end_date) <= '" . $end_date . "'");
        }
        if($searchedDepartment){
            $projectsQuery->whereRaw("departments.id = '" . $searchedDepartment . "'");
        }
        // if($searchedstatus){
        //     $projectsQuery->whereRaw("projects.status = '" . $searchedstatus . "'");
        // }
        if($salesExecutive){
            $projectsQuery->whereRaw("projects.sales_executive = '" . $salesExecutive . "'");
        }
        if($employees){
            $projectsQuery->whereRaw("project_user_relation.user_id = '" . $employees . "'");
        }


	      if (empty($invalidID_array)) {
	      	 $projects = $projectsQuery->where('is_deleted','0')->orderBy('projects.id', 'desc')->select('projects.*','departments.department');
	      }else{
	      	 $projects = $projectsQuery->where('is_deleted','0')->orderByRaw(DB::raw("FIELD(projects.id, $invalidID_array) DESC"))->orderBy('projects.id', 'desc')->select('projects.*','departments.department');
	      } 

        // $projects = $projectsQuery->where('is_deleted','0')->orderByRaw(DB::raw("FIELD(projects.id, $invalidID_array) DESC"))->select('projects.*','departments.department');

        if($searchdata){
            $projects = DB::table('projects')->join('departments', 'projects.department_ids', '=', 'departments.id')->where('is_deleted','0')->select('projects.*','departments.department');
        }

        session(['serial' => 0]);

        return datatables()->of($projects)->addIndexColumn()->editColumn('status', function ($projects) use ($invalidID) {
                    $status = array(
                        '1' => 'Active',
                        '2' => 'Completed',
                        '3' => 'Paused',
                        '4' => 'Canceled',
                        '5' => 'Dispute'
                    );
                    return '<span class="st-'.$status[$projects->status].'"></span>';
                })->addColumn('serial', function ($projects) {
                    $serial = session('serial');
                    session(['serial' => $serial+1]);
                    return $serial+1;
                })->editColumn('start_date', function ($projects) {
					return $projects->start_date != "" ? date('d-m-Y', strtotime($projects->start_date)) : "N/A";
                })->editColumn('project_title', function ($projects) {
                    return '<a href="'. route('view-project',$projects->id) .'" class = "">'.$projects->project_title.'</a>';

                })->addColumn('action', function ($projects) {
                    return '<a class="all_icons" href="'. route('view-project',$projects->id) .'" class=""><img src="'.asset('custom/images/view-icon.svg').'" title="View"></a> <a class="all_icons" href="'. route('edit-project',$projects->id) .'" class=""><img src="'.asset('custom/images/edit-icon.svg').'" title="Edit"></a> ';
                })->addColumn('class', function ($projects) use ($invalidID) {
                    $abc = in_array($projects->id, $invalidID) ? "highlighted" : "lighted";
                    return $abc;
                })->rawColumns(['project_title' => 'project_title','status' => 'status','action' => 'action'])->make(true);
    }

    public function addproject(){
    	$departments = Departments::all();
        $users = User::where('access_level','!=', '1')->where('status','=','1')->where('id','!=','30')->orderBy('name', 'ASC')->get();
        $sales = User::where('department_id', '4')->where('access_level','!=', '1')->where('status','=','1')->orderBy('name', 'ASC')->get();
    	return view('projects.addproject',['users' => $users, 'sales' => $sales, 'departments' => $departments]);
    }

    public function saveproject(Request $request){
         // echo '<pre>';print_r($request->all());echo'</pre>';die;

		$validator = Validator::make($request->all(), [
				            'project_title' => 'required',
					        'department_ids' => 'required',
                            'billing_type' => 'required',
                            'platform' => 'required',
                            'client_name' => 'required',
                            'status' => 'required',
                            'project_cost' => Rule::requiredIf(function () use ($request) {
                                        return ($request->billing_type == 1) ? TRUE : FALSE ;
                                    }).'|numeric|nullable',
                            'hourly_rate' => Rule::requiredIf(function () use ($request) {
                                        return ($request->billing_type == 2) ? TRUE : FALSE ;
                                    }).'|nullable',
                            'time_allocated_hours' => 'required|numeric',
                            'sales_executive' => 'required'
                            // 'time_allocated_mins' => 'required|numeric',
                            // 'client_country' => 'required',
                            // 'priority' => 'required',
                            // 'start_date' => 'required',
				        ],
				        $messages = [
						    'project_title.required' => 'Project title field is required.',
					        'start_date.required' => 'Start date field is required.',
					        'priority.required' => 'Priority field is required.',
					        'department_ids.required' => 'Department field is required.',
                            'billing_type.required' => 'Billing type field is required',
                            'platform.required' => 'Platform field is required',
                            'time_allocated.required' => 'Time Allocated field is required',
                            'client_name.required' => 'Client name field is required',
                            'client_country.required' => 'Client country field is required',
                            'status.required' => 'Status field is required',
                            'project_cost.numeric' => 'Project Cost field must be numeric',
                            'hourly_rate.numeric' => 'Hourly Rate field must be numeric',
                            'time_allocated_hours.required' => 'Time allocated hours field is required',
                            'time_allocated_hours.numeric' => 'Time allocated hours field must be numeric',
                            'sales_executive.required' => 'Sales Executive field is required'
                            // 'time_allocated_mins.required' => 'Time allocated minutes field is required',
                            // 'time_allocated_mins.numeric' => 'Time allocated minutes field must be numeric'
						]
			    	);

        if ($validator->fails()) {
            return redirect('add-project')
                        ->withErrors($validator)
                        ->withInput();
        }

        $alldata = $request->all();
        $alldata['time_allocated'] = ($alldata['time_allocated_hours']*60) + $alldata['time_allocated_mins'];

        unset($alldata['_token']);
        unset($alldata['assigned_users']);
        unset($alldata['time_allocated_hours']);
        unset($alldata['time_allocated_mins']);
        if($request->project_cost){
            $pc = str_replace('$', '', $alldata['project_cost']);
            $alldata['project_cost'] = '$'.$pc;
        }else if($request->hourly_rate){
            $hrate = str_replace('$', '', $alldata['hourly_rate']);
            $alldata['hourly_rate'] = '$'.$hrate;
        }

        $projects = Projects::create($alldata);

		if(isset($request->assigned_users))	
		{
			foreach($request->assigned_users as $assgnd_user){
				DB::insert('insert into project_user_relation (project_id, user_id, relation_status) values (?, ?, ?)', [$projects->id, $assgnd_user, '1']);
			}
		}

        return redirect('add-project')->with('status', 'Project added successfully!');
    }

    public function viewproject($id){
		$project = Projects::findOrFail($id);
        $project = DB::table('projects')
		->leftJoin('users','users.id','=','projects.sales_executive')
		->leftJoin('departments','departments.id','=','projects.department_ids')
        ->select(
            'projects.*',
            'users.name',
            'departments.department',
          )
          ->where('projects.id','=',$id)->where('is_deleted','0')->first();

        $employee_time_spent = DB::table('dsr')
            ->join('users','users.id','=','dsr.employee_id')
            ->select(
                'users.id',
                'users.name',
                'dsr.project_id as projectid',
                DB::raw("(SELECT SUM(dsr.time_spent) FROM dsr WHERE dsr.employee_id = users.id AND dsr.project_id = projectid GROUP BY dsr.employee_id) as time_spent"),
                DB::raw("(SELECT SUM(dsr.time_spent) FROM dsr WHERE dsr.project_id = projectid) as total_time")
            )
            ->where('dsr.project_id',$id)
            ->distinct('users.id')
            ->orderBy('users.id','desc')->get();

        $employees_assigned = DB::table('projects')
            ->join('project_user_relation','project_user_relation.project_id','=','projects.id')
            ->join('users','users.id','=','project_user_relation.user_id')
            ->select(
                'users.name',
                'users.id'
            )->where('projects.id',$id)->where('is_deleted','0')->orderBy('users.name','ASC')->get();

		return view('projects.viewproject',compact('project','employee_time_spent','employees_assigned'));
    }

    public function editproject($project_id){
        $project = Projects::findOrFail($project_id);
        $project = DB::table('projects')->where('projects.id','=',$project_id)->where('is_deleted','0')->first();
        $project_user_relation = DB::table('project_user_relation')->where('project_id','=',$project_id)->pluck('user_id')->toArray();
        $departments = Departments::all();
        $users = User::where('access_level','!=', '1')->where('status','=','1')->where('id','!=','30')->orderBy('name', 'ASC')->get();
        $sales = User::where('department_id', '4')->where('access_level','!=', '1')->where('status','=','1')->orderBy('name', 'desc')->get();
        return view('projects.addproject',['users' => $users, 'sales' => $sales, 'departments' => $departments, 'project' => $project, 'project_user_relation' => $project_user_relation]);
    }

    public function saveEditedProject(Request $request){
        //echo'<pre>';print_r($request->all());echo'</pre>';die;

        $validator = Validator::make($request->all(), [
                            'id' => 'required',
                            'project_title' => 'required',
                            'department_ids' => 'required',
                            'billing_type' => 'required',
                            'platform' => 'required',
                            'client_name' => 'required',
                            'status' => 'required',
                            'project_cost' => Rule::requiredIf(function () use ($request) {
                                        return ($request->billing_type == 1) ? TRUE : FALSE ;
                                    }).'|numeric|nullable',
                            'hourly_rate' => Rule::requiredIf(function () use ($request) {
                                        return ($request->billing_type == 2) ? TRUE : FALSE ;
                                    }).'|nullable',
                            'time_allocated_hours' => 'required|numeric',
                            'sales_executive' => 'required'
                            // 'time_allocated_mins' => 'required|numeric',
                            // 'client_country' => 'required',
                            // 'priority' => 'required',
                            // 'start_date' => 'required',
                        ],
                        $messages = [
                            'id.required' => 'Id field is required',
                            'project_title.required' => 'Project title field is required',
                            'url.required' => 'Project URL field is required',
                            'start_date.required' => 'Start date field is required',
                            'priority.required' => 'Priority field is required',
                            'department_ids.required' => 'Department field is required',
                            'assigned_users.required' => 'Related employees field is required',
                            'description.required' => 'Description field is required',
                            'end_date.required' => 'End Date field is required',
                            'billing_type.required' => 'Billing type field is required',
                            'platform.required' => 'Platform field is required',
                            'time_allocated.required' => 'Time Allocated field is required',
                            'client_name.required' => 'Client name field is required',
                            'client_email.required' => 'Client email field isrequired',
                            'client_skype.required' => 'Client skype id field is required',
                            'client_country.required' => 'Client country field is required',
                            'sales_executive.required' => 'Sales executive field is required',
                            'status.required' => 'Status field is required',
                            'project_cost.required' => 'Project Cost field is required',
                            'hourly_rate.required' => 'Hourly Rate field is required',
                            'project_cost.numeric' => 'Project Cost field must be numeric',
                            'time_allocated_hours.required' => 'Time allocated hours field is required',
                            'time_allocated_hours.numeric' => 'Time allocated hours field must be numeric',
                            'sales_executive.required' => 'Sales Executive field is required'
                            // 'time_allocated_mins.required' => 'Time allocated minutes field is required',
                            // 'time_allocated_mins.numeric' => 'Time allocated minutes field must be numeric'
                        ]
                    );

        if ($validator->fails()) {
            return redirect('edit-project/'.$request->id)
                        ->withErrors($validator)
                        ->withInput();
        }
        $alldata = $request->all();
        $alldata['time_allocated'] = ($alldata['time_allocated_hours']*60) + $alldata['time_allocated_mins'];

        unset($alldata['_token']);
        unset($alldata['assigned_users']);
        unset($alldata['id']);
        unset($alldata['time_allocated_hours']);
        unset($alldata['time_allocated_mins']);
        if($request->project_cost){
            $alldata['project_cost'] = '$'.$alldata['project_cost'];
        }else if($request->hourly_rate){
            $alldata['hourly_rate'] = '$'.$alldata['hourly_rate'];
        }

        try {
            Projects::where('id', $request->id)->update($alldata);
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('projects')->withErrors(['error' => $e->errorInfo]);
        }

        try {
            DB::table('project_user_relation')->where('project_id',$request->id)->delete();
            if(isset($request->assigned_users)){
                foreach($request->assigned_users as $assgnd_user){
                    DB::insert('insert into project_user_relation (project_id, user_id, relation_status) values (?, ?, ?)', [$request->id, $assgnd_user, '1']);
                }
            }
            return redirect('projects')->with('status', 'Project updated successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('projects')->withErrors(['error' => $e->errorInfo]);
        }
    }

    public function deleteproject(Projects $project){
        $project->is_deleted = '1';
        $project->save();
        return redirect()->route('projects')->with('status','Project deleted successfully');
    }

    /************************ Inactive Project tab*************************/
    public function inactiveProject(){


        $designProjects = Projects::where('department_ids',2)->where('status','=',1)->where('is_deleted','0')->count();
        $devProjects = Projects::where('department_ids',1)->where('status','=',1)->where('is_deleted','0')->count();
        $seoProjects = Projects::where('department_ids',3)->where('status','=',1)->where('is_deleted','0')->count();
       
        return view('projects.inactiveproject', ['designProjects' => $designProjects, 'devProjects' => $devProjects, 'seoProjects' => $seoProjects]);
    }

    public function inactivefilterprojects(){ 

        $searchedstatus = (!empty($_GET["status"])) ? ($_GET["status"]) : ('');
      //  $before30Days = date('Y-m-d', strtotime('-30 days'));
        $projectsQuery = DB::table('projects')
                        ->join('departments', 'projects.department_ids', '=', 'departments.id')->where('projects.status', '!=' , '1' );

        if($searchedstatus == '2' || $searchedstatus == '3' || $searchedstatus == '4' ){
            $projectsQuery->Where('projects.status','=',$searchedstatus);
        }


        $projects = $projectsQuery->where('is_deleted','0')->orderBy('projects.status', 'ASC')->orderBy('projects.id', 'desc')->select('projects.*','departments.department');
        session(['serial' => 0]);

        return datatables()->of($projects)->addIndexColumn()->editColumn('status', function ($projects) {
                    $status = array(
                        '1' => 'Active',
                        '2' => 'Completed',
                        '3' => 'Paused',
                        '4' => 'Canceled',
                        '5' => 'Dispute'
                    );
                    return '<span class="st-'.$status[$projects->status].'"></span>';
                })->addColumn('serial', function ($projects) {
                    $serial = session('serial');
                    session(['serial' => $serial+1]);
                    return $serial+1;
                })->editColumn('start_date', function ($projects) {
                    return $projects->start_date != "" ? date('d-m-Y', strtotime($projects->start_date)) : "N/A";
                })->editColumn('project_title', function ($projects) {
                    return '<a href="'. route('view-project',$projects->id) .'" class="">'.$projects->project_title.'</a>';
                })->addColumn('action', function ($projects) {
                    return '<a class="all_icons" href="'. route('view-project',$projects->id) .'" class=""><img src="'.asset('custom/images/view-icon.svg').'" title="View"></a> <a class="all_icons" href="'. route('edit-project',$projects->id) .'" class=""><img src="'.asset('custom/images/edit-icon.svg').'" title="Edit"></a> ';
                })->rawColumns(['project_title' => 'project_title','status' => 'status','action' => 'action'])->make(true);
    }
}
