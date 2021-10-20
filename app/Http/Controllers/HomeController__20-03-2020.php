<?php

namespace TMS\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        if($user['access_level'] == 1 && $user['status'] == 1){
            return view('dashboard');
        }else if($user['access_level'] != 1 && $user['status'] == 1){
            return view('employee.emp-dashboard');
        }else{
            Auth::logout();
            return redirect('login')->withErrors(['error' => 'Please ask Admin to approve your account.']);
        }
    }
}
