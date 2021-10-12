<?php

namespace TMS\Http\Controllers\Employee;

use Auth;
use TMS\User;
use TMS\Dsr;
use Mail;
use TMS\DsrEditRequestToken;
use Illuminate\Http\Request;
use TMS\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class DsrController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // To display Form to add task in Dsr
    public function index()
    {
		$userId =  Auth::id();
		$user = User::findOrFail($userId);
		$department_id = $user->department_id;
		
		$assignedProjects = DB::table('projects')
					->join('project_user_relation','project_user_relation.project_id','=','projects.id')
					->join('departments','departments.id','=','projects.department_ids')
			        ->select('projects.id','projects.project_title')
					->where('projects.status','1')
					->where('project_user_relation.user_id','=',$userId)
					->where('project_user_relation.relation_status','=',1)
					->where('projects.is_deleted','0')
					->get()->toArray();
		
		$categories = DB::table('categories')
					->select('id','category')
					->where('department_id','=',$department_id)
					->get()->toArray();
		
		$subcategories = DB::table('subcategories')
					->join('categories','categories.id','=','subcategories.category_id')
					->select('subcategories.subcategory','subcategories.id as subcategories_id','categories.id as categories_id')
					->where('categories.department_id','=',$department_id)
					->get()->toArray();
		
		// To get todays filled DSR list
		$todaysDsr = DB::table('dsr')
						->join('projects', 'projects.id', '=', 'dsr.project_id')
						->join('categories', 'categories.id', '=', 'dsr.category_id')
						->leftjoin('subcategories', 'subcategories.id', '=', 'dsr.subcategory_id')
						->where('employee_id',$userId)
						->whereRaw("date(dsr_date) = '" . date('Y-m-d') . "'")
						->where('projects.is_deleted','0')
						->select('categories.category', 'subcategories.subcategory','projects.project_title','dsr.dsr_date','dsr.time_spent','dsr.description','dsr.id')
						->get();

        return view('employee.dsr.filldsr',compact('assignedProjects','categories','subcategories','todaysDsr'));
    }

    // To save task in current day Dsr
    public function saveDsr(Request $request){
    	$validator = Validator::make($request->all(), [
				            'project_id' => 'required',
					        'category_id' => 'required',
					        'description' => 'required',
					        'hours_spent' => 'required',
					        'minutes_spent' => 'required'
				        ],
				        $messages = [
						    'project_id.required' => 'Project ID field is required.',
						    'category_id.required' => 'Category ID field is required.',
					        'description.required' => 'Description field is required.',
					        'hours_spent.required' => 'Hours Spent field is required.',
					        'minutes_spent.required' => 'Minutes spent field is required.'
						]
			    	);

        if ($validator->fails()) {
            return redirect('fill-dsr')
                        ->withErrors($validator)
                        ->withInput();
        }
        $alldata = $request->all();
        $total_time = ($alldata['hours_spent'] * 60) + $alldata['minutes_spent'];
        $alldata['time_spent'] = $total_time;
        $alldata['employee_id'] = Auth::id();
        $alldata['dsr_date'] = date('Y-m-d');

        unset($alldata['hours_spent']);
        unset($alldata['minutes_spent']);

        $projects = Dsr::create($alldata);
        if($projects->id){
        	return redirect('fill-dsr')->with('status', 'DSR added successfully!');
        }else{
        	return redirect('fill-dsr')->withErrors(['error' => "Can't save the DSR at this moment. Please try again."]);
        }
    	//echo'<pre>';print_r($alldata);echo'</pre>';die;
    }

    // To display Form to edit a DSR task
    public function editDsr($id)
    {
		$userId =  Auth::id();
		$user = User::findOrFail($userId);
		$department_id = $user->department_id;
		
		$assignedProjects = DB::table('projects')
					->join('project_user_relation','project_user_relation.project_id','=','projects.id')
					->join('departments','departments.id','=','projects.department_ids')
			        ->select('projects.id','projects.project_title')
					->where('project_user_relation.user_id','=',$userId)
					->where('projects.status','1')
					->where('project_user_relation.relation_status','=',1)
					->where('projects.is_deleted','0')
					->get()->toArray();
		
		$categories = DB::table('categories')
					->select('id','category')
					->where('department_id','=',$department_id)
					->get()->toArray();
		
		$subcategories = DB::table('subcategories')
					->join('categories','categories.id','=','subcategories.category_id')
					->select('subcategories.subcategory','subcategories.id as subcategories_id','categories.id as categories_id')
					->where('categories.department_id','=',$department_id)
					->get()->toArray();

		$todaysDsr = DB::table('dsr')
					->join('projects', 'projects.id', '=', 'dsr.project_id')
					->join('categories', 'categories.id', '=', 'dsr.category_id')
					->leftjoin('subcategories', 'subcategories.id', '=', 'dsr.subcategory_id')
					->where('employee_id',$userId)
					->whereRaw("date(dsr_date) = '" . date('Y-m-d') . "'")
					->where('dsr.id',$id)
					->where('projects.is_deleted','0')
					->select('categories.id as cat_id', 'subcategories.id as subcat_id','projects.id as project_id','dsr.time_spent','dsr.description','dsr.id')
					->first();

    	return view('employee.dsr.editdsr',compact('assignedProjects','categories','subcategories','todaysDsr'));
    }
	
	// Delete DSR entry
	
	public function deleteDsr($id)
	{
		try 
		{
			DB::table('dsr')->where('id',$id)->where('employee_id',Auth::id())->delete();
			return redirect('fill-dsr')->with('status', 'DSR row deleted successfully!');
		} 
		catch (\Illuminate\Database\QueryException $e) 
		{
			return redirect('fill-dsr')->withErrors(['error' => $e->errorInfo]);
		}
	}

    // To save edited Dsr
    public function saveEditedDsr(Request $request)
    {
    	$validator = Validator::make($request->all(), [
		            'id' => 'required',
		            'project_id' => 'required',
			        'category_id' => 'required',
			        'description' => 'required',
			        'hours_spent' => 'required',
			        'minutes_spent' => 'required'
		        ],
		        $messages = [
				    'id.required' => 'ID field is required.',
				    'project_id.required' => 'Project ID field is required.',
				    'category_id.required' => 'Category ID field is required.',
			        'description.required' => 'Description field is required.',
			        'hours_spent.required' => 'Hours Spent field is required.',
			        'minutes_spent.required' => 'Minutes spent field is required.'
				]
	    	);

		if ($validator->fails()) {
		    return redirect('fill-dsr')
	                ->withErrors($validator)
	                ->withInput();
		}

		$alldata = $request->all();
		$alldata['time_spent'] = ($alldata['hours_spent'] * 60) + $alldata['minutes_spent'];
		unset($alldata['id']);
		unset($alldata['hours_spent']);
		unset($alldata['minutes_spent']);
		unset($alldata['_token']);
		$alldata['subcategory_id'] = isset($alldata['subcategory_id']) && !empty($alldata['subcategory_id']) ? $alldata['subcategory_id'] : NULL;

		try {
		    Dsr::where('id', $request->id)->where('dsr_date',date('Y-m-d'))->update($alldata);
		    return redirect('fill-dsr')->with('status', 'DSR updated successfully!');
		} catch (\Illuminate\Database\QueryException $e) {
			return redirect('fill-dsr')->withErrors(['error' => $e->errorInfo]);
		}
    }
	
	// To show old days DSR to employee
    public function viewOldDsr()
    {
		$last15days = date('Y-m-d', strtotime('-15 days', strtotime('today')));
		
		
    	$userId = Auth::id();
    	$viewOldDsr = DB::table('dsr')
    	->join('users', 'users.id', '=', 'dsr.employee_id')
    	->join('departments', 'departments.id', '=', 'users.department_id')
    	->join('projects', 'projects.id', '=', 'dsr.project_id')
    	->join('categories', 'categories.id', '=', 'dsr.category_id')
    	->leftjoin('subcategories', 'subcategories.id', '=', 'dsr.subcategory_id')
    	->select('categories.category', 'subcategories.subcategory',
    		'users.id as user_id','users.name','departments.department','projects.project_title',
    		'dsr.id as dsr_id','dsr.dsr_date','dsr.time_spent','dsr.description');	$viewOldDsr->where('users.id',$userId);
    	$viewOldDsr->where('projects.is_deleted','0');
    	$viewOldDsr->where('dsr.dsr_date','>',$last15days);
    	$viewOldDsr->orderBy('dsr_date','DESC');
    	$viewOldDsr->orderBy('departments.id','ASC');
    	$viewOldDsr->orderBy('users.id','ASC');
    	$viewOldDsr = $viewOldDsr->get();
		return view('employee.dsr.viewOldDsr',compact('viewOldDsr'));
    }

    public function sendEmail()
    {
        $data['title'] = "This is Test Mail";
 
        Mail::send('email', $data, function($message) {
            $message->to('deepak.kumar@willshall.com', 'Deepak')->subject('First');
        });
 
        if (Mail::failures()) {
         	echo "fail";
         	die;
     	}else{
         	echo "done";
         	die;
     	}
    }

    // To display backdate request form and all requested dates
    public function BackDateRequest(){
    	$allbackdates = DsrEditRequestToken::where('employee_id',Auth::id())->orderBy('valid_till_date','DESC')->orderBy('updated_at','DESC')->get();
    	return view('employee.dsr.backdateRequest',compact('allbackdates'));
    }

    // To save backdate request
    public function saveBackDateRequest(Request $request){
    	$validator = Validator::make($request->all(), [
    				'issued_for_date' => 'required'
				], [
					'issued_for_date.required' => 'Backdate field is required.',
				]);

    	if($validator->fails()){
    		return redirect('backdate-request')->withErrors($validator)->withInput();
    	}

    	$alldata = $request->all();
    	$alldata['issued_for_date'] = date('Y-m-d',strtotime($alldata['issued_for_date']));
		$alldata['employee_id'] =  Auth::id();
		$alldata['requested_at'] = Carbon::now();

		$justForCheck = date('Y-m-d');
		if(!DsrEditRequestToken::where('employee_id',$alldata['employee_id'])->where('issued_for_date',$alldata['issued_for_date'])->where('valid_till_date',$justForCheck)->count()){
			DsrEditRequestToken::create($alldata);

			$emailsRecipients = ['sachin@willshall.com', 'manoj@willshall.com'];
	        $data['username'] = Auth::user()->name;
	        Mail::send('emailTemplates/backdateEntry', $data, function($message)  use ($emailsRecipients) {
	            $message->to($emailsRecipients)->subject('New Backdate Entry Request on PMS');
	        });

    		return redirect('backdate-request')->with('status', 'Request submitted successfully!');
		}else{
			return redirect('backdate-request')->withErrors(['error' => 'A Request is already present for the date.']);
		}
    }

    // To display add old day DSR form 
    public function addOldDayDSR($token){
    	$dsrData = DsrEditRequestToken::where('token_number',$token)->first();
    	$current_date = date('Y-m-d');

    	if(!isset($dsrData)){
    		return redirect('backdate-request')->withErrors(['error' => 'Not a valid request']);
    	}elseif(Auth::id() != $dsrData->employee_id){
    		return redirect('backdate-request')->withErrors(['error' => 'Not a valid request']);
    	}elseif(strtotime($current_date) > strtotime($dsrData->valid_till_date)){
    		return redirect('backdate-request')->withErrors(['error' => 'Requested token invalid']);
    	}

    	$userId =  Auth::id();
		$user = User::findOrFail($userId);
		$department_id = $user->department_id;
		
		$assignedProjects = DB::table('projects')
					->join('project_user_relation','project_user_relation.project_id','=','projects.id')
					->join('departments','departments.id','=','projects.department_ids')
			        ->select('projects.id','projects.project_title')
					->where('projects.status','1')
					->where('project_user_relation.user_id','=',$userId)
					->where('project_user_relation.relation_status','=',1)
					->where('projects.is_deleted','0')
					->get()->toArray();
		
		$categories = DB::table('categories')
					->select('id','category')
					->where('department_id','=',$department_id)
					->get()->toArray();
		
		$subcategories = DB::table('subcategories')
					->join('categories','categories.id','=','subcategories.category_id')
					->select('subcategories.subcategory','subcategories.id as subcategories_id','categories.id as categories_id')
					->where('categories.department_id','=',$department_id)
					->get()->toArray();
		
		// To get token related old day filled DSR list
		$todaysDsr = DB::table('dsr')
						->join('projects', 'projects.id', '=', 'dsr.project_id')
						->join('categories', 'categories.id', '=', 'dsr.category_id')
						->leftjoin('subcategories', 'subcategories.id', '=', 'dsr.subcategory_id')
						->where('employee_id',$userId)
						->whereRaw("date(dsr_date) = '" . $dsrData->issued_for_date . "'")
						->where('projects.is_deleted','0')
						->select('categories.category', 'subcategories.subcategory','projects.project_title','dsr.dsr_date','dsr.time_spent','dsr.description','dsr.id')
						->get();

        return view('employee.dsr.filldsr',compact('assignedProjects','categories','subcategories','todaysDsr','dsrData'));
    }

    // To save old date DSR
    public function saveOldDateDsr(Request $request,$token){
    	$dsrData = DsrEditRequestToken::where('token_number',$token)->first();
    	$current_date = date('Y-m-d');

    	if(!isset($dsrData)){
    		return redirect('backdate-request')->withErrors(['error' => 'Not a valid request']);
    	}elseif(Auth::id() != $dsrData->employee_id){
    		return redirect('backdate-request')->withErrors(['error' => 'Not a valid request']);
    	}elseif(strtotime($current_date) > strtotime($dsrData->valid_till_date)){
    		return redirect('backdate-request')->withErrors(['error' => 'Requested token invalid']);
    	}

    	$validator = Validator::make($request->all(), [
		            'project_id' => 'required',
			        'category_id' => 'required',
			        'description' => 'required',
			        'hours_spent' => 'required',
			        'minutes_spent' => 'required'
		        ],
		        $messages = [
				    'project_id.required' => 'Project ID field is required.',
				    'category_id.required' => 'Category ID field is required.',
			        'description.required' => 'Description field is required.',
			        'hours_spent.required' => 'Hours Spent field is required.',
			        'minutes_spent.required' => 'Minutes spent field is required.'
				]
	    	);

        if ($validator->fails()) {
            return redirect()->route('add-old-date-dsr',$dsrData->token_number)
                        ->withErrors($validator)
                        ->withInput();
        }

        $alldata = $request->all();
        $total_time = ($alldata['hours_spent'] * 60) + $alldata['minutes_spent'];
        $alldata['time_spent'] = $total_time;
        $alldata['employee_id'] = Auth::id();
        $alldata['dsr_date'] = $dsrData->issued_for_date;

        unset($alldata['hours_spent']);
        unset($alldata['minutes_spent']);

        $dsr = Dsr::create($alldata);
        if($dsr->id){
        	return redirect()->route('add-old-date-dsr',$dsrData->token_number)->with('status', 'DSR added successfully!');
        }else{
        	return redirect()->route('add-old-date-dsr',$dsrData->token_number)->withErrors(['error' => "Can't save the DSR at this moment. Please try again."]);
        }
    }

    // To display edit old day DSR form
    public function editOldDayDSR($dsrId,$token){
    	$dsrData = DsrEditRequestToken::where('token_number',$token)->first();
    	$current_date = date('Y-m-d');

    	if(!isset($dsrData)){
    		return redirect('backdate-request')->withErrors(['error' => 'Not a valid request']);
    	}elseif(Auth::id() != $dsrData->employee_id){
    		return redirect('backdate-request')->withErrors(['error' => 'Not a valid request']);
    	}elseif(strtotime($current_date) > strtotime($dsrData->valid_till_date)){
    		return redirect('backdate-request')->withErrors(['error' => 'Requested token invalid']);
    	}

    	$userId =  Auth::id();
		$user = User::findOrFail($userId);
		$department_id = $user->department_id;
		
		$assignedProjects = DB::table('projects')
					->join('project_user_relation','project_user_relation.project_id','=','projects.id')
					->join('departments','departments.id','=','projects.department_ids')
			        ->select('projects.id','projects.project_title')
					->where('project_user_relation.user_id','=',$userId)
					->where('projects.status','1')
					->where('project_user_relation.relation_status','=',1)
					->where('projects.is_deleted','0')
					->get()->toArray();
		
		$categories = DB::table('categories')
					->select('id','category')
					->where('department_id','=',$department_id)
					->get()->toArray();
		
		$subcategories = DB::table('subcategories')
					->join('categories','categories.id','=','subcategories.category_id')
					->select('subcategories.subcategory','subcategories.id as subcategories_id','categories.id as categories_id')
					->where('categories.department_id','=',$department_id)
					->get()->toArray();

		$todaysDsr = DB::table('dsr')
					->join('projects', 'projects.id', '=', 'dsr.project_id')
					->join('categories', 'categories.id', '=', 'dsr.category_id')
					->leftjoin('subcategories', 'subcategories.id', '=', 'dsr.subcategory_id')
					->where('employee_id',$userId)
					->whereRaw("date(dsr_date) = '" . $dsrData->issued_for_date . "'")
					->where('dsr.id',$dsrId)
					->where('projects.is_deleted','0')
					->select('categories.id as cat_id', 'subcategories.id as subcat_id','projects.id as project_id','dsr.time_spent','dsr.description','dsr.id')
					->first();

    	return view('employee.dsr.editOldDateDsr',compact('assignedProjects','categories','subcategories','todaysDsr','dsrData'));
    }

    // To save edited old date DSR
    public function saveEditedOldDateDsr(Request $request,$token)
    {
    	$dsrData = DsrEditRequestToken::where('token_number',$token)->first();
    	$current_date = date('Y-m-d');

    	if(!isset($dsrData)){
    		return redirect('backdate-request')->withErrors(['error' => 'Not a valid request']);
    	}elseif(Auth::id() != $dsrData->employee_id){
    		return redirect('backdate-request')->withErrors(['error' => 'Not a valid request']);
    	}elseif(strtotime($current_date) > strtotime($dsrData->valid_till_date)){
    		return redirect('backdate-request')->withErrors(['error' => 'Requested token invalid']);
    	}

    	$validator = Validator::make($request->all(), [
		            'id' => 'required',
		            'project_id' => 'required',
			        'category_id' => 'required',
			        'description' => 'required',
			        'hours_spent' => 'required',
			        'minutes_spent' => 'required'
		        ],
		        $messages = [
				    'id.required' => 'ID field is required.',
				    'project_id.required' => 'Project ID field is required.',
				    'category_id.required' => 'Category ID field is required.',
			        'description.required' => 'Description field is required.',
			        'hours_spent.required' => 'Hours Spent field is required.',
			        'minutes_spent.required' => 'Minutes spent field is required.'
				]
	    	);

		if ($validator->fails()) {
		    return redirect()->route('edit-old-date-dsr',[$dsrData->id,$dsrData->token_number])->withErrors($validator)->withInput();
		}

		$alldata = $request->all();
		$alldata['time_spent'] = ($alldata['hours_spent'] * 60) + $alldata['minutes_spent'];
		unset($alldata['id']);
		unset($alldata['hours_spent']);
		unset($alldata['minutes_spent']);
		unset($alldata['_token']);
		$alldata['subcategory_id'] = isset($alldata['subcategory_id']) && !empty($alldata['subcategory_id']) ? $alldata['subcategory_id'] : NULL;

		try {
		    Dsr::where('id', $request->id)->update($alldata);
		    return redirect()->route('add-old-date-dsr',$dsrData->token_number)->with('status', 'DSR updated successfully!');
		} catch (\Illuminate\Database\QueryException $e) {
			return redirect()->route('edit-old-date-dsr',[$dsrData->id,$dsrData->token_number])->withErrors(['error' => $e->errorInfo]);
		}
    }
}
