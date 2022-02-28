<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Driver;
use App\Models\Passenger;
use Illuminate\Support\Facades\Hash;

class LoginAPIController extends Controller
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

    private function driverAuth(Request $request) {
        $driver = Driver::where('username',$request->username)->first();

        if(!$driver || !Hash::check($request->password,$driver->password)) {
            return false;
        }

        return $driver;
    }

    
    public function login(Request $request) {
        $passenger = Passenger::where('username',$request->username)->first();

        if(!$passenger || !Hash::check($request->password,$passenger->password)) {

            $driver = $this->driverAuth($request);

            if($driver) {
                return response([
                    'success' => true,
                    'type' => 2,
                    'data' => $driver,
                    'token' => $driver->createToken('MyAuthApp')->plainTextToken,
                    'message' => 'Login success',
                ], 201);
            }

            return response([
                'success' => false,
                'data' => [],
                'message' => 'Bad credentials',
            ], 403);
        }

        return response([
            'success' => true,
            'type' => 1,
            'data' => $passenger,
            'token' => $passenger->createToken('MyAuthApp')->plainTextToken,
            'message' => 'Login success',
        ], 201);
    }

    public function test() {
        return response([
            'success' => true,
            'data' => ['msg' => 'Hello, World'],
            'message' => 'API test',
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
