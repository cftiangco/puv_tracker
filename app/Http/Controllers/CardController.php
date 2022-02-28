<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;

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
}
