<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Role;

use Validator;
use Redirect;
use Session;

class UserSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users  = User::with('role')->get();
        $roles  = Role::all();
        return view('cms.pages.user_settings', compact('users','roles') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = [
            'user-name' => 'required|alpha_spaces',
            'user-email' => 'required|email|unique:users,email',
            'user-role' => 'required',
            'user-password' => array(
                                  'required',
                                  'min:8',
                                  'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$/',
                                  'different:user-email'
                            ),
            'user-cpassword' => 'required|same:user-password'
        ];

        $friendly_names = [
            'user-name' => 'name',
            'user-email' => 'email',
            'user-role' => 'role',
            'user-password' => 'password',
            'user-cpassword' => 'confirm password'
        ];

        $validator = Validator::make($request->all(), $rule);
        $validator->setAttributeNames($friendly_names);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput($request->all());
        }

        $user = new User();
        $user->name = trim($request['user-name']);
        $user->email = trim($request['user-email']);
        $user->role_id = $request['user-role'];
        $user->password = bcrypt($request['user-password']);
        $user->save();

        Session::flash('success_create', '1');
        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('id','=',$id)->with('role')->first();
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rule = [
            'user-name' => 'required|alpha_spaces',
            'user-role' => 'required',
            'user-password' => array(
                                  'min:8',
                                  'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$/',
                                  'different:user-email',
                            ),
            'user-cpassword' => 'required_with:user-password|same:user-password'
        ];

        $friendly_names = [
            'user-name' => 'name',
            'user-email' => 'email',
            'user-role' => 'role',
            'user-password' => 'password',
            'user-cpassword' => 'confirm password'
        ];

        $update_data = [
            'name' => trim($request['user-name']),
            'role_id' => $request['user-role']
        ];

        if(! is_null( $request['user-password'] ) ){
            $validator = Validator::make($request->all(), $rule);
            $validator->setAttributeNames($friendly_names);
            if($validator->fails()){
                return Redirect::back()->withErrors($validator)->withInput($request->all());
            }
            $update_data['password'] = bcrypt($request['user-password']);
        }

        User::find($request->input('user-id'))->update($update_data);
        Session::flash('success', '1');
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        User::find($request->input('user-id'))->delete();
        Session::flash('success', '1');
    }

    public function unlock(Request $request){
        $user = User::where('id','=', $request->input('user-id'))->first();
        // $this->resetAttempts($user);
        Session::flash('success', '1');
        return $request->all();
    }
}
