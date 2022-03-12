<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TripPassenger;
use App\Models\Trip;
use App\Models\Topup;
use App\Models\Balance;
use Illuminate\Support\Facades\DB;

class PassengerTripAPIController extends Controller
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
    {
        // $fare = Trip::where('trips.id','=',$request->trip_id)
        // ->join('slots','slots.id','=','trips.slot_id')
        // ->join('schedules','schedules.id','=','slots.schedule_id')
        // ->first(['schedules.fee']);

        $request->validate([
            'trip_id' => 'required',
            'passenger_id' => 'required',
            'location' => 'required',
        ]);

        $model = new TripPassenger;
        $model->trip_id = $request->trip_id;
        $model->passenger_id = $request->passenger_id;
        $model->location = $request->location;
        $model->fare = $request->fare;
        $model->status_id = 1;
        $model->save();
        return $model;
    }

    public function checkinInfo(Request $request,$passengerId,$tripId) {
      $balance =  $this->getBalance($passengerId);
      $result = Trip::where('trips.id',$tripId)
      ->select(DB::raw("
        trips.id,
        schedules.fee,
        CONCAT(schedules.location_from,' To ',schedules.location_to) AS destination,
        TIME_FORMAT(schedules.departing_time,'%h:%i %p') as arrived,
        IFNULL((SELECT CONCAT(cards.discount,'% - ',cards.type) FROM discounts INNER JOIN cards ON cards.id = discounts.card_id WHERE discounts.passenger_id = $passengerId AND discounts.status_id = 1),0) AS discount,
        IFNULL(TRUNCATE((schedules.fee - ((schedules.fee * (SELECT cards.discount FROM discounts INNER JOIN cards ON cards.id = discounts.card_id WHERE discounts.passenger_id = $passengerId AND discounts.status_id = 1)) / 100)),2),schedules.fee) AS total
      "))
      ->join('slots','slots.id','=','trips.slot_id')
      ->join('schedules','schedules.id','=','slots.schedule_id')
      ->first();

      return response([
          'success' => true,
          'data' => $result,
          'balance' => $balance,
          'message' => 'Info has been successfully retured',
      ], 201);
    }

    private function getBalance($id) {
      return Topup::whereIn('balance_id',Balance::where('passenger_id',$id)->get(['id']))
      ->select(DB::raw("
          IFNULL((SUM(amount) - (SELECT SUM(fare) FROM trip_passengers WHERE passenger_id = $id)),SUM(amount)) as balance
        "))
      ->pluck('balance')->first();
    }

    /* param int passenger_id */
    public function activeTrip($id) {
      $trip = TripPassenger::where('trip_passengers.passenger_id','=',$id)
      ->select(DB::raw("
        trip_passengers.id,
        trip_passengers.location, 
        schedules.location_to,
        TIME_FORMAT(schedules.departing_time,'%h:%i %p') as departing,
        trip_passengers.fare
      "))
      ->where('trip_passengers.status_id','=',1)
      ->join('trips','trips.id','=','trip_passengers.trip_id')
      ->join('slots','slots.id','=','trips.slot_id')
      ->join('schedules','schedules.id','=','slots.schedule_id')
      ->first();

      if($trip) {
        return response([
            'success' => true,
            'data' => $trip,
            'message' => 'You have an active session',
        ], 201);
      }

      return response([
          'success' => false,
          'data' => [],
          'message' => 'No active session',
      ], 201);
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
