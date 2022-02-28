<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Passenger;
use App\Models\Discount;
use File;

class DiscountController extends Controller
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

    public function view($id)
    {
        $cards = Card::all();
        $passenger = Passenger::leftJoin('discounts','passengers.id','=','discounts.passenger_id')
            ->where('passengers.id',$id)
            ->first(['passengers.*','discounts.id as discount_id','discounts.image','discounts.status_id as discount_status_id']);

        return view('/dashboard/discount_cards/view',[
            'cards' => $cards,
            'passenger' => $passenger
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $imageName = uniqid('ID_').'.'.$request->image->extension();  
        $request->image->move(public_path('images'), $imageName);

        $discount = Discount::where('passenger_id',$request->passenger_id)->first();
        if($discount) {
            if(File::exists(public_path('images/'.$discount->image))){
                File::delete(public_path('images/'.$discount->image));
                $discount->delete();
            }
        }
        
        $model = new Discount;
        $model->passenger_id = $request->passenger_id;
        $model->card_id = $request->card_id;
        $model->image = $imageName;
        $model->status_id = 1;

        $model->save();
        return redirect()->back()->with('success','Discount card has been successfully updated');
    }

    public function status(Request $request) {
       //return $request->discount_id;
       $model = Discount::find($request->discount_id);
       $status = 1;

       if($request->discount_status_id == 1) {
           $status = 2;
       }

       $model->status_id = $status;
       $model->update();
       return redirect()->back()->with('success','Discount card has been successfully updated');
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
