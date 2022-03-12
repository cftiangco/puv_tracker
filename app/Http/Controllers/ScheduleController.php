<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = SChedule::join('schedule_statuses','schedules.status_id','=','schedule_statuses.id')
            ->get(['schedules.*','schedule_statuses.description']);
        return view('dashboard/schedules/list',['schedules' => $schedules]);
    }

    public function new()
    {
        return view('dashboard/schedules/new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new Schedule;
        $model->location_from = $request->location_from;
        $model->location_to = $request->location_to;
        $model->departing_time = $request->departing_time;
        $model->fee = $request->fee;
        $model->number_of_seats = $request->number_of_seats;
        $model->status_id = $request->status_id ?? 2;
        $model->save();
        return redirect('/dashboard/schedules')->withSuccess('Record has been successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $schedule = Schedule::find($id);
        return view('dashboard/schedules/edit',['schedule' => $schedule]);
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
        $model = Schedule::find($id);
        $model->location_from = $request->location_from;
        $model->location_to = $request->location_to;
        $model->departing_time = $request->departing_time;
        $model->fee = $request->fee;
        $model->number_of_seats = $request->number_of_seats;
        $model->status_id = $request->status_id ?? 2;
        $model->update();
        return redirect('/dashboard/schedules')->withSuccess('Record has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Schedule::find($id);
        $model->delete();
        return redirect('/dashboard/schedules')->withFail('Record has been successfully deleted');
    }
}
