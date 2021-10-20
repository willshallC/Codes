<?php

namespace TMS\Http\Controllers\Auth;

use TMS\User;
use TMS\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users','regex:/willshall.com/'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \TMS\User
     */
    protected function create(array $data)
    {
        $data = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        DB::table('employee_profile')->insert(['emp_id' => $data->id]);
        $this->basic_email($data->id);

        return $data;
    }

    public function basic_email($userId) {
        $data = array('title'=>"Willshall",'userid'=>$userId);
   
        Mail::send('emailTemplates.newUserRegisterEmail', $data, function($message) {
            $message->to('sachin@willshall.com', 'Sachin')
            ->to('manoj@willshall.com', 'Manoj')
            ->bcc('neha.kumari@willshall.com', 'Neha')
            ->bcc('deepak.kumar@willshall.com', 'Deepak')
            ->subject('New User registered on willshall.churnings.com');
            $message->from('pms@willshall.com','Willshall');
        });
    }
}
