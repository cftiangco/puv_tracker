<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Discount;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cards = Card::join('card_statuses','cards.status_id','=','card_statuses.id')
            ->get(['cards.*','card_statuses.description']);
        return view('dashboard/discounts/list',['cards' => $cards]);
    }

    public function new()
    {
        return view('dashboard/discounts/new');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new Card;
        $model->type = $request->type;
        $model->discount = $request->discount;
        $model->status_id = $request->status_id ?? 2;
        $model->save();
        return redirect('/dashboard/discounts')->withSuccess('Record has been successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $card = Card::find($id);
        return view('dashboard/discounts/edit',['card' => $card]);
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
        $model = Card::find($id);
        $model->type = $request->type;
        $model->discount = $request->discount;
        $model->status_id = $request->status_id ?? 2;
        $model->update();
        return redirect('/dashboard/discounts')->withSuccess('Record has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Card::find($id);
        $model->delete();
        return redirect('/dashboard/discounts')->withFail('Record has been successfully deleted');
    }

    public function approvals()
    {
        $discounts =  Discount::join('passengers','discounts.passenger_id','=','passengers.id')
          ->join('cards','discounts.card_id','=','cards.id')
          ->where('discounts.status_id',2)
          ->get(['discounts.id','passengers.last_name','passengers.first_name','passengers.middle_name','passengers.username','cards.type','discounts.created_at']);

        return view('/dashboard/approvals/list',['discounts' => $discounts]);
    }

    public function approved($id)
    {
        $model = Discount::find($id);
        $model->status_id = 1;
        $model->update();
        return redirect('/dashboard/approvals')->withSuccess('Request has been successfully approved');
    }

    public function viewDiscount($id)
    {
      $discount =  Discount::join('passengers','discounts.passenger_id','=','passengers.id')
        ->join('cards','discounts.card_id','=','cards.id')
        ->where('discounts.id',$id)
        ->first(['discounts.id','passengers.last_name','passengers.first_name','passengers.gender','passengers.birthday','passengers.username','passengers.mobileno','passengers.middle_name','passengers.username','cards.type','discounts.created_at','discounts.image','discounts.idno']);
      return view('/dashboard/approvals/view',['discount' => $discount]);
    }

}
