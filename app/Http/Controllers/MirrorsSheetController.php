<?php

namespace TMS\Http\Controllers;

use Auth;
use TMS\MirrorSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Datatables;

class MirrorsSheetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function checkAuthenticity(){
        $authentic_ids = config('app.authenticUsers');
        $current_user = Auth::user();
        return in_array($current_user->id, $authentic_ids);
    }

    public function index(){
    	$authenticityCheck = $this->checkAuthenticity();
    	if(!$authenticityCheck){
    		return back()->withErrors(['error' => 'You don\'t have access to this module.']);
    	}
        $mirrorSheet = MirrorSheet::all();
        $totalPaid = DB::table('mirrorsites_sheet')
                    ->select(DB::raw('sum(amount) as totatPaid'))
                    ->where('payment_status',1)
                    ->first();
		$totalUnpaid = DB::table('mirrorsites_sheet')
                    ->select(DB::raw('sum(amount) as totalUnpaid'))
                    ->where('payment_status',2)
                    ->first();
        return view('mirrorsheet.index',compact('mirrorSheet','totalPaid','totalUnpaid'));
    }

    public function addtask(){
    	$authenticityCheck = $this->checkAuthenticity();
    	if(!$authenticityCheck){
    		return back()->withErrors(['error' => 'You don\'t have access to this module.']);
    	}

        return view('mirrorsheet.addtask');
    }

    public function saveTask(Request $request){
        $authenticityCheck = $this->checkAuthenticity();
        if(!$authenticityCheck){
            return back()->withErrors(['error' => 'You don\'t have access to this module.']);
        }
        MirrorSheet::create($request->all());
        return redirect('mirror-sheet')->with(['status' => 'Task Added Successfully!']);
        // echo '<pre>';print_r($request->all());echo'</pre>';die;
    }

    public function taskList(){
        $website = (!empty($_GET["website"])) ? ($_GET["website"]) : ('');
        $status = (!empty($_GET["status"])) ? ($_GET["status"]) : ('');
        $payment_status = (!empty($_GET["payment_status"])) ? ($_GET["payment_status"]) : ('');

        $taskQuery = DB::table('mirrorsites_sheet');

        if($status){
            $taskQuery->whereRaw("status = '" . $status . "'");
        }
        if($payment_status){
            $taskQuery->whereRaw("payment_status = '" . $payment_status . "'");
        }else{
            $taskQuery->whereRaw("payment_status = '2'");
        }
        if($website){
            $taskQuery->whereRaw("website Like '%" . $website . "%'");
        }

        $tasks = $taskQuery->orderBy('mirrorsites_sheet.status', 'ASC')->orderBy('mirrorsites_sheet.payment_status', 'desc')->select('mirrorsites_sheet.*');

        $string_data['status'] = array(
            '1' => 'Not Started Yet',
            '2' => 'Working',
            '3' => 'Waiting for Feedback',
            '4' => 'Working on Bug Fixing',
            '5' => 'Working on Additional Changes',
            '6' => 'Done'
        );
        $string_data['payment_status'] = array(
            '1' => 'Paid',
            '2' => 'Unpaid'
        );

        return datatables()->of($tasks)->addIndexColumn()
				->editColumn('upwork_code', function ($tasks) {
					return $tasks->trello_url != '' ? "<a href='".$tasks->trello_url."' class='' target='_blank'>".$tasks->upwork_code."</a>" : $tasks->upwork_code;
				})
                ->editColumn('status', function ($tasks) use ($string_data) {
                    return $string_data['status'][$tasks->status];
                
                })->editColumn('payment_status', function ($tasks) use ($string_data) {
                    return $string_data['payment_status'][$tasks->payment_status];
                })->editColumn('date', function ($tasks) {
                    return date('d-m-Y',strtotime($tasks->date));
                })
				->editColumn('quote', function ($tasks) {
                    $hours = floor($tasks->quote/60);
                    $mins = $tasks->quote - $hours*60;
                    $mins .= " mins";
                    $hours .= $hours && $hours > 1 ? " hrs" : ($hours && $hours == 1 ? " hr"  : "");
                    $returnvalue = $hours > 0 ? $hours.' '.$mins : $mins ;
                    return $returnvalue;
                })
				->addColumn('action', function ($tasks) {
                    return '<a class="all_icons" href="'. route('view-task',$tasks->id) .'" class=""><img src="'.asset('custom/images/view-icon.svg').'" title="View"></a>   &nbsp<a class="all_icons" href="'. route('edit-task',$tasks->id) .'" class=""><img src="'.asset('custom/images/edit-icon.svg').'" title="Edit"></a> ';
                })
                ->rawColumns(['quote' => 'quote','status' => 'status','payment_status' => 'payment_status','action' => 'action','upwork_code' => 'upwork_code','date' => 'date'])->make(true);
    }

    public function viewtask(MirrorSheet $task){
        $authenticityCheck = $this->checkAuthenticity();
        if(!$authenticityCheck){
            return back()->withErrors(['error' => 'You don\'t have access to this module.']);
        }

        return view('mirrorsheet.viewtask',compact('task'));
    }

    public function edittask(MirrorSheet $task){
        $authenticityCheck = $this->checkAuthenticity();
        if(!$authenticityCheck){
            return back()->withErrors(['error' => 'You don\'t have access to this module.']);
        }

        return view('mirrorsheet.addtask',compact('task'));
    }

    public function saveEditedTask(Request $request,MirrorSheet $task){
        MirrorSheet::updateOrCreate(['id' => $task->id],$request->all());
        return redirect()->route('mirror-sheet')->withStatus('Task edited successfully!');
        // echo '<pre>';print_r($request->all());echo'</pre>';die;
    }
}
