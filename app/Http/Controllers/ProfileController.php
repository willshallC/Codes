<?php

namespace TMS\Http\Controllers;

use Auth;
use TMS\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use TMS\Http\Requests\ProfileRequest;
use TMS\Http\Requests\PasswordRequest;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        $userId =  Auth::id();
        if($request->hasFile('photo'))
        {
            $allowedfileExtension=['jpg','png','jpeg','svg'];
            $files = $request->file('photo');
            foreach($files as $file)
            {
                //$filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check=in_array($extension,$allowedfileExtension);
                //dd($check);
                if($check){
                    //$items= Item::create($request->all());
                    //foreach ($request->photo as $photo) {
                    $filename = $file->store('public');
                    $filename = explode("public/",$filename);
                    echo $filename = $filename[1];
                
                    DB::table('users')->where('id', $userId)->update(array('profile_pic' =>$filename));
                }else{
                    return redirect()->route('profile.edit')->withErrors(['error'=>'Sorry upload only png,jpg files.']);
                }
            }
        }
        auth()->user()->update($request->all());

        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }

    // To view Admin profile
    public function view(){
        $adminId =  Auth::id();
        $admin = User::findOrFail($adminId);
        
        $admin = DB::table('users')->leftjoin('employee_profile','employee_profile.emp_id','=','users.id')
                ->select(
                    'users.name',
                    'users.email',
                    'employee_profile.gender'
                )->where('users.id','=',$adminId)->first();
        return view('profile.view',compact('admin'));
    }
}
