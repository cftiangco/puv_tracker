<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Slot;

class TripAPIController extends Controller
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

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   /* required parameter slot_id,driver_id */
        $trip = $this->getActiveTrip($request->driver_id);
        if(!$trip) {
            $model = new Trip;
            $model->slot_id = $request->slot_id;
            $model->status_id = 1;
            $model->save();
            return response([
                'success' => true,
                'data' => $model,
                'message' => 'New trip has been successfully created',
            ], 201);
        }

        return response([
            'success' => true,
            'data' => $trip,
            'message' => 'You still have active trip',
        ], 201);
    }

    private function getActiveTrip($driverId) {
        /* required parameter driver_id */
        return Trip::where('status_id',1)
        ->whereIn('slot_id',Slot::where('driver_id',$driverId)->get(['id']))->first();
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
