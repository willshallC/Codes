<?php

namespace TMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use TMS\BAWorkSheet;

class BAWorkSheetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	private function checkAuthenticity()
	{
		$user = auth()->user();
		if($user->department_id != 4)
		{
            return false;
        }
		else
		{
			return true;
		}
	}
	
	public function addLead()
	{
		if(!$this->checkAuthenticity()){
    		return back()->withErrors(['error' => 'You don\'t have access to this module.']);
    	}
		//$todaysLeads = BAWorkSheet::select('*')->where('date',date('Y-m-d'))->get();
		
		$todaysLeads = DB::table('business_analyst_work_sheet')
					->select('*')
					->where('employee_id', Auth::id())
					->where('date',date('Y-m-d'))
					->get();			
		return view('BAWorkSheet.addLead',compact('todaysLeads'));
	}
	
	public function saveJob(Request $request){
        if(!$this->checkAuthenticity()){
    		return back()->withErrors(['error' => 'You don\'t have access to this module.']);
    	}
		$validator = Validator::make($request->all(), [
				            'platform' => 'required',
					        'profile_id' => 'required',
                            'job_title' => 'required',
                            'job_url' => 'required',
                            'cost' => 'required'
				        ],
				        $messages = [
						    'platform.required' => 'Platform field is required.',
					        'profile_id.required' => 'Profile Name field is required.',
					        'job_title.required' => 'Job Title field is required.',
					        'job_url.required' => 'Job Url field is required.',
                            'cost.required' => 'Cost field is required',
						]
			    	);

        if ($validator->fails()) {
            return redirect('add-lead')
                        ->withErrors($validator)
                        ->withInput();
        }
		
		
		$alldata = $request->all();
		$alldata['employee_id'] = Auth::id();
		$alldata['date'] = date('Y-m-d');
		
		BAWorkSheet::create($alldata);
        return redirect('add-lead')->with(['status' => 'Lead Added Successfully!']);
    }
	
	public function editJob(BAWorkSheet $job){
		if(!$this->checkAuthenticity()){
    		return back()->withErrors(['error' => 'You don\'t have access to this module.']);
    	}
        return view('BAWorkSheet.addLead',compact('job'));
    }

    public function saveEditedJob(Request $request,BAWorkSheet $job){
        if(!$this->checkAuthenticity()){
    		return back()->withErrors(['error' => 'You don\'t have access to this module.']);
    	}
		$validator = Validator::make($request->all(), [
				            'platform' => 'required',
					        'profile_id' => 'required',
                            'job_title' => 'required',
                            'job_url' => 'required',
                            'cost' => 'required'
				        ],
				        $messages = [
						    'platform.required' => 'Platform field is required.',
					        'profile_id.required' => 'Profile Name field is required.',
					        'job_title.required' => 'Job Title field is required.',
					        'job_url.required' => 'Job Url field is required.',
                            'cost.required' => 'Cost field is required',
						]
			    	);

        if ($validator->fails()) {
            return redirect('add-lead')
                        ->withErrors($validator)
                        ->withInput();
        }
		
		$alldata = $request->all();
		$alldata['employee_id'] = Auth::id();
		$alldata['date'] = date('Y-m-d');
		BAWorkSheet::updateOrCreate(['id' => $job->id],$alldata);
        return redirect()->route('add-lead')->withStatus('Lead edited successfully!');
        // echo '<pre>';print_r($request->all());echo'</pre>';die;
    }
	
	public function editOldJob(BAWorkSheet $job){
		if(!$this->checkAuthenticity()){
    		return back()->withErrors(['error' => 'You don\'t have access to this module.']);
    	}
		$oldJob = 1;
        return view('BAWorkSheet.addLead',compact('job','oldJob'));
    }
	
	public function saveEditedOldJob(Request $request,$id){
        if(!$this->checkAuthenticity()){
    		return back()->withErrors(['error' => 'You don\'t have access to this module.']);
    	}
		$alldata = $request->all();
		
		$workSheetEntry = BAWorkSheet::findOrFail($id);
		// Make sure you've got the Page model
		if($workSheetEntry) {
			$workSheetEntry->status = $alldata['status'];
			$workSheetEntry->cost = $alldata['cost'];
			$workSheetEntry->cost_type = $alldata['cost_type'];
			$workSheetEntry->save();
		}
        return redirect()->route('old-work-sheets')->withStatus('Lead edited successfully!');
        // echo '<pre>';print_r($request->all());echo'</pre>';die;
    }
	
	public function deleteJob($id)
	{
		try 
		{
			DB::table('business_analyst_work_sheet')->where('id',$id)->where('employee_id',Auth::id())->where('date',date('Y-m-d'))->delete();
			return redirect('add-lead')->with('status', 'Lead row deleted successfully!');
		} 
		catch (\Illuminate\Database\QueryException $e) 
		{
			return redirect('add-lead')->withErrors(['error' => $e->errorInfo]);
		}
	}
	
	
	public function viewOldWorkSheets()
    {
		if(!$this->checkAuthenticity()){
    		return back()->withErrors(['error' => 'You don\'t have access to this module.']);
    	}
		$last15days = date('Y-m-d', strtotime('-30 days', strtotime('today')));
		
    	$userId = Auth::id();
    	$viewOldSheets = DB::table('business_analyst_work_sheet')
    	->select('*');	
		$viewOldSheets->where('employee_id',$userId);
    	$viewOldSheets->where('date','>',$last15days);
    	$viewOldSheets->orderBy('date','DESC');
    	$viewOldSheets = $viewOldSheets->get();
		return view('BAWorkSheet.oldWorkSheets',compact('viewOldSheets'));
    }
}
