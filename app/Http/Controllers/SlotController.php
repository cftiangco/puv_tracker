<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slot;

class SlotController extends Controller
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
        $slots = Slot::where('schedule_id',$request->schedule_id)
            ->where('driver_id',$request->driver_id)->get();

        if(count($slots) > 0) {
            return redirect()->back()->with('fail','Schedule is already exists in this record.');
        }

        $model = new Slot;
        $model->driver_id = $request->driver_id;
        $model->schedule_id = $request->schedule_id;
        $model->status_id = 1;
        $model->save();
        return redirect("/dashboard/drivers/". $request->driver_id ."/view")->withSuccess('Record has been successfully added');
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
        $model = Slot::find($id);
        $model->delete();
        return redirect()->back()->with('fail','Record has been successfully deleted');
    }
}
