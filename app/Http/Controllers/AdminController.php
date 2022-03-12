<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource. test only
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::join('roles','admins.role_id','=','roles.id')
            ->join('user_statuses','admins.status_id','=','user_statuses.id')
            ->get(['admins.*','roles.description as role','user_statuses.description as status']);

        return view('dashboard/admins/list',['admins'=>$admins]);
    }

    public function register() {

        return view('dashboard/admins/register', [
            'roles' => $roles = Role::all()
        ]);
    }


    public function login() {
        return view('dashboard/admins/login');
    }

    public function loggedin(Request $request) {
        $user = Admin::where('username',$request->username)->first();

        if(!$user || !Hash::check($request->password,$user->password)) {
            return redirect()->back()->with('fail','Invalid credentials, Please try again!');
        }
        $request->session()->put('user', $user);
        return redirect('/dashboard');
    }

    public function logout(Request $request) {
        $request->session()->forget('user');
        $request->session()->flush();
        return redirect('/login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
            'username' => 'required|unique:admins,username'
        ]);

        $model = new Admin;
        $model->last_name = $request->last_name;
        $model->first_name = $request->first_name;
        $model->middle_name = $request->middle_name;
        $model->role_id = $request->role_id;
        $model->status_id = $request->status_id ?? 2;
        $model->username = $request->username;
        $model->password = Hash::make($request->password);
        $model->save();
        return redirect('/dashboard/admins')->withSuccess('Record has been successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('dashboard/admins/edit', [
            'roles' => Role::all(),
            'user' => Admin::find($id)
        ]);
    }

    public function showPassword($id) {
        return view('dashboard/admins/newpassword',['id' => $id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model = Admin::find($id);
        $model->last_name = $request->last_name;
        $model->first_name = $request->first_name;
        $model->middle_name = $request->middle_name;
        $model->role_id = $request->role_id;
        $model->status_id = $request->status_id ?? 2;
        $model->update();
        return redirect('/dashboard/admins')->withSuccess('Record has been successfully updated');
    }

    public function updatePassword(Request $request, $id) {
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $model = Admin::find($id);
        $model->password = Hash::make($request->password);
        $model->update();
        return redirect('/dashboard/admins/'.$id)->withSuccess('Password has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
