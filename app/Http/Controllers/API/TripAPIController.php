<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Slot;
use App\Models\TripPassenger;
use Illuminate\Support\Facades\DB;

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

        $request->validate([
            'slot_id' => 'required',
            'driver_id' => 'required',
        ]);

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
        $trip = Trip::where('trips.id',$id)
        ->where('trips.status_id',1)
        ->select(DB::raw("trip_passengers.*,concat(passengers.last_name,', ',passengers.first_name,' ',passengers.middle_name) as full_name,schedules.fee,trip_passenger_statuses.description as status"))
        ->join('trip_passengers','trips.id','=','trip_passengers.trip_id')
        ->join('passengers','trip_passengers.passenger_id','=','passengers.id')
        ->join('slots','trips.slot_id','=','slots.id')
        ->join('schedules','slots.schedule_id','=','schedules.id')
        ->join('trip_passenger_statuses','trip_passengers.status_id','=','trip_passenger_statuses.id')
        ->get();
        return response([
            'success' => true,
            'data' => $trip,
        ], 201);
    }

    public function active($id)
    {
        $trip = Trip::where('slots.driver_id',$id)
        ->whereIn('trips.status_id',[1,2])
        ->select(DB::raw("
        trip_passengers.*,
        concat(passengers.last_name,', ',passengers.first_name,' ',passengers.middle_name) as full_name,
        schedules.fee,
        trip_passenger_statuses.description as status,cards.type,
        TIME_FORMAT(trip_passengers.updated_at,'%h:%i %p') as arrived,
        trip_passengers.fare
        "))
        ->join('trip_passengers','trips.id','=','trip_passengers.trip_id')
        ->join('passengers','trip_passengers.passenger_id','=','passengers.id')
        ->join('slots','trips.slot_id','=','slots.id')
        ->join('schedules','slots.schedule_id','=','schedules.id')
        ->join('trip_passenger_statuses','trip_passengers.status_id','=','trip_passenger_statuses.id')
        ->leftJoin('discounts','passengers.id','=','discounts.passenger_id')
        ->leftJoin('cards','discounts.card_id','=','cards.id')
        ->get();

        $status = Trip::where('slots.driver_id','=',$id)
        ->join('slots','slots.id','=','trips.slot_id')
        ->first(['trips.status_id']);


        return response([
            'status_id' => $status->status_id ?? 0,
            'success' => true,
            'data' => $trip,
        ], 201);
    }

    public function drop(Request $request, $id) {
      $model = TripPassenger::find($id);
      $model->status_id = 2;
      $model->update();
      return response([
          'success' => true,
          'data' => $model,
      ], 201);
    }

    public function cancel(Request $request, $id) {
      $model = TripPassenger::find($id);
      $model->status_id = 3;
      $model->update();
      return response([
          'success' => true,
          'data' => $model,
      ], 201);
    }

    public function end($id) {
      $results = TripPassenger::where('trip_passengers.status_id','=',1)
      ->where('slots.driver_id','=',$id)
      ->join('trips','trip_passengers.trip_id','=','trips.id')
      ->join('slots','trips.slot_id','=','slots.id')
      ->get();
      if(count($results) > 0) {
        return response([
            'success' => false,
            'message' => "Sorry there's one or more passengers has not yet reaches their destination.",
        ], 201);
      }

      $affacted = Trip::whereIn('slot_id',Slot::where('driver_id',$id)->get(['id']))->update(['status_id' => 3]);

      return response([
          'success' => true,
          'message' => "Trip has been successfully completed",
      ], 201);

    }

    public function drive($id) {
      $affacted = Trip::whereIn('slot_id',Slot::where('driver_id',$id)->get(['id']))
      ->where('status_id',1)
      ->update(['status_id' => 2]);

      return response([
          'success' => true,
          'message' => "Driver has now driving",
      ], 201);

    }

    public function available() {
      $trips = Trip::where('trips.status_id',1)
      ->select(DB::raw("
      trips.id,
      drivers.puv_platenumber,
      schedules.number_of_seats,
      schedules.fee,
      schedules.location_from,
      schedules.location_to,
      schedules.departing_time,
      (SELECT COUNT(*) FROM trip_passengers tp WHERE tp.trip_id = trips.id AND tp.status_id = 1) AS `passengers`,
      trip_statuses.description AS `status`,
      TIME_FORMAT(schedules.departing_time,'%h:%i %p') as 'arrival'
      "))
      ->join('slots','slots.id','=','trips.slot_id')
      ->join('schedules','schedules.id','=','slots.schedule_id')
      ->join('drivers','drivers.id','=','slots.driver_id')
      ->join('trip_statuses','trip_statuses.id','=','trips.status_id')
      ->get();
      return response([
          'success' => true,
          'data' => $trips,
      ], 201);
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
