<?php

namespace TMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use TMS\BAWorkSheet;
use TMS\User;

class BAWorkSheetAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
		
    }
	
	public function baWorksheets()
	{
		$employee = (!empty($_GET["employee"])) ? ($_GET["employee"]) : ('');
		$status = (!empty($_GET["status"])) ? ($_GET["status"]) : ('');
		$date = (!empty($_GET["date"])) ? (date('Y-m-d', strtotime($_GET["date"]))) : ('');
		$to_date = (!empty($_GET["to_date"])) ? (date('Y-m-d', strtotime($_GET["to_date"]))) : ('');
		
		$allLeads = DB::table('business_analyst_work_sheet')
					->join('users','users.id', '=', 'business_analyst_work_sheet.employee_id')
					->select('business_analyst_work_sheet.*','users.name');
					if($employee){
						$allLeads = $allLeads->where('users.id','=',$employee);
					}
					if($status){
						$allLeads = $allLeads->where('business_analyst_work_sheet.status','=',$status);
					}
					if($date && $to_date){
						// $allLeads = $allLeads->whereRaw('business_analyst_work_sheet.date BETWEEN CAST('.$date.' as date) AND CAST('.$to_date.' as date)');
						$allLeads = $allLeads->whereBetween('business_analyst_work_sheet.date',[$date,$to_date]);
					}elseif($date){
						$allLeads = $allLeads->where('business_analyst_work_sheet.date','=',$date);
					}
					//->where('date',date('Y-m-d'))
					$allLeads->orderBy('business_analyst_work_sheet.date', 'desc');
					$allLeads->orderBy('users.id','ASC');
					$allLeads = $allLeads->get();	
		
		$sales_executives = User::select('id','name')->where('department_id','4')->where('status','=','1')->where('id','!=','30')->orderBy('users.name', 'ASC')->get();
		return view('BAWorksheetAdmin.viewBAWorkSheetAdmin',compact('allLeads','sales_executives'));
	}
}
