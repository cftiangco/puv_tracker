<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Schedule;
use App\Models\Slot;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers = Driver::join('driver_statuses','drivers.status_id','=','driver_statuses.id')
            ->get(['drivers.*','driver_statuses.description']);
        return view('dashboard/drivers/list',['drivers' => $drivers ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //default username and password
        $default = Str::substr(Str::lower($request->first_name),0,1) . Str::replace(' ','',Str::lower($request->last_name));

        $model = new Driver;
        $model->last_name = $request->last_name;
        $model->first_name = $request->first_name;
        $model->middle_name = $request->middle_name;
        $model->mobileno = $request->mobileno;
        $model->birthday = $request->birthday;
        $model->gender = $request->gender;
        $model->license_no = $request->license_no;
        $model->puv_platenumber = $request->puv_platenumber;
        $model->status_id = $request->status_id ?? 2;
        $model->username = 'driver_'.$default;
        $model->password = Hash::make('driver_'.$default);
        $model->save();
        return redirect('/dashboard/drivers')->withSuccess('Record has been successfully added');
    }

    public function register() {
        return view('dashboard/drivers/register');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $driver = Driver::find($id);
        return view('dashboard/drivers/edit',['driver' => $driver]);
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
        $model = Driver::find($id);
        $model->last_name = $request->last_name;
        $model->first_name = $request->first_name;
        $model->middle_name = $request->middle_name;
        $model->mobileno = $request->mobileno;
        $model->birthday = $request->birthday;
        $model->gender = $request->gender;
        $model->license_no = $request->license_no;
        $model->puv_platenumber = $request->puv_platenumber;
        $model->status_id = $request->status_id ?? 2;
        $model->update();
        return redirect('/dashboard/drivers')->withSuccess('Record has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Driver::find($id);
        $model->delete();
        return redirect('/dashboard/drivers')->withFail('Record has been successfully deleted');
    }

    public function view($id)
    {
        $driver = Driver::join('driver_statuses','drivers.status_id','=','driver_statuses.id')
            ->where('drivers.id',$id)
            ->first(['drivers.*','driver_statuses.description']);
        $schedules = Schedule::where('status_id',1)->get();

        $slots = Slot::join('schedules','slots.schedule_id','=','schedules.id')
            ->where('slots.driver_id',$id)->get(['schedules.*','slots.id AS slot_id']);

        return view('dashboard/drivers/view',[
            'driver' => $driver,
            'schedules' => $schedules,
            'slots' => $slots
        ]);
    }
}
