<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slot;
use Illuminate\Support\Facades\DB;

class DriverAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function schedules($id) {
        /* get all driver active schedule, required parameter driver_id*/
        $slots = Slot::where('driver_id',$id)
        ->select(
          DB::raw("
          slots.id,
          slots.schedule_id,
          schedules.location_from,
          schedules.location_to,
          schedules.departing_time,
          schedules.fee,
          schedules.number_of_seats,
          concat(schedules.location_from,' To ',schedules.location_to,' (',TIME_FORMAT(schedules.departing_time,'%h:%i %p'),')') as `description`
          "))->join('schedules','slots.schedule_id','=','schedules.id')->get();

        return response([
            'success' => true,
            'data' => $slots,
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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
