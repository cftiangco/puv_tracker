<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Passenger;
use App\Models\Balance;
use Illuminate\Support\Facades\Hash;
use App\Models\Topup;
use Illuminate\Support\Facades\DB;

class PassengerAPIController extends Controller
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
        return Passenger::find($id);
    }

    public function register(Request $request) {

      $request->validate([
          'last_name' => 'required',
          'first_name' => 'required',
          'mobileno' => 'required',
          'birthday' => 'required',
          'gender' => 'required',
          'username' => 'required|unique:passengers',
          'password' => 'required',
      ]);

      $passenger = new Passenger;
      $passenger->last_name = $request->last_name;
      $passenger->first_name = $request->first_name;
      $passenger->middle_name = $request->middle_name;
      $passenger->mobileno = $request->mobileno;
      $passenger->birthday = $request->birthday;
      $passenger->gender = $request->gender;
      $passenger->status_id = 1;
      $passenger->username = $request->username;
      $passenger->password = Hash::make($request->password);
      $passenger->save();

      $balance = new Balance;
      $balance->passenger_id = $passenger->id;
      $balance->save();

      return response([
        'success' => true,
        'type' => 1,
        'data' => $passenger,
        'token' => $passenger->createToken('MyAuthApp')->plainTextToken,
        'message' => 'Login success',
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
        $request->validate([
            'last_name' => 'required',
            'first_name' => 'required',
            'mobileno' => 'required',
        ]);
        $passenger = Passenger::find($id);
        $passenger->last_name = $request->last_name;
        $passenger->first_name = $request->first_name;
        $passenger->middle_name = $request->middle_name;
        $passenger->update();
        return response([
          'success' => true,
          'data' => $passenger,
          'message' => 'Your info has been successfully updated',
        ], 201);
    }

    public function balance($id) {
      $balance = $this->getBalance($id);
      return response([
        'success' => true,
        'data' => $balance,
        'message' => 'Passenger balance',
      ], 201);
    }

    private function getBalance($id) {
      return Topup::whereIn('balance_id',Balance::where('passenger_id',$id)->get(['id']))
      ->select(DB::raw("
          IFNULL((SUM(amount) - (SELECT SUM(fare) FROM trip_passengers WHERE passenger_id = $id)),SUM(amount)) as balance
        "))
      ->pluck('balance')->first();
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
