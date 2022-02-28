<?php

namespace App\Http\Controllers;
use App\Models\Passenger;
use App\Models\Balance;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class PassengerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $passengers = Passenger::join('passenger_statuses','passengers.status_id','=','passenger_statuses.id')
            ->leftJoin('discounts','passengers.id','=','discounts.passenger_id')
            ->leftJoin('cards','discounts.card_id','=','cards.id')
            ->get(['passengers.*','passenger_statuses.description','cards.type as discount']);
        return view('dashboard/passengers/list',['passengers' => $passengers]);
    }

    public function new()
    {
        return view('dashboard/passengers/register');
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

        $model = new Passenger;
        $model->last_name = $request->last_name;
        $model->first_name = $request->first_name;
        $model->middle_name = $request->middle_name;
        $model->mobileno = $request->mobileno;
        $model->birthday = $request->birthday;
        $model->gender = $request->gender;
        $model->status_id = $request->status_id ?? 2;
        $model->username = $default;
        $model->password = Hash::make($default);
        $model->save();

        $balance = new Balance;
        $balance->passenger_id = $model->id;
        $balance->save();
        
        return redirect('/dashboard/passengers')->withSuccess('Record has been successfully added');
    }

    public function view($id) {
        $passenger = Passenger::join('passenger_statuses','passengers.status_id','=','passenger_statuses.id')
            ->join('balances','passengers.id','=','balances.passenger_id')
            ->leftJoin('discounts','passengers.id','=','discounts.passenger_id')
            ->leftJoin('cards','discounts.card_id','=','cards.id')
            ->where('passengers.id',$id)
            ->first([
                'passengers.*','passenger_statuses.description','cards.type as discount','balances.id as balance_id'
            ]);

            $balance = DB::select("SELECT SUM(topups.amount) AS `balance` FROM balances 
            INNER JOIN topups ON topups.balance_id = balances.id WHERE passenger_id = ?",[$id]);

        return view('dashboard/passengers/view',[
            'passenger' => $passenger,
            'balance' => $balance[0]->balance
        ]);
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
