<?php

namespace App\Http\Controllers\API;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RentRequest;
use App\Models\Rent;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{

    /**
     * Display a listing of the resource vehcile.
     *
     * @return \Illuminate\Http\Response
     */
    public function listTypes()
    {
        $types = Type::with("items")->get();
        return json_custom_response($types);
    }

    /**
     * Display a listing of the resource vehcile.
     *
     * @return \Illuminate\Http\Response
     */
    public function listVehcile()
    {
        //
        $vehicleItems = Item::with("type")->paginate(4);
        return json_custom_response($vehicleItems);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\RentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function rentVehcile(RentRequest $request)
    {
        //
        $rent = Rent::create([
            'name' => $request->name,
            'contact_number' => $request->name,
            'item_id' => $request->item_id
        ]);
        $rent->addMedia($request->ID)->toMediaCollection("rent");
        $rent->addMedia($request->personal_license)->toMediaCollection("rent");
        $rent->addMedia($request->passport)->toMediaCollection("rent");


        $message = __('message.save_form', ['form' => __('message.rent')]);
        $response = [
            'message' => $message,
            'data' =>    $rent
        ];
        return json_custom_response($response);
    }
}
