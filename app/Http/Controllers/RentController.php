<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Type;
use Illuminate\Http\Request;
use App\DataTables\RentDataTable;
use App\Models\Notification;
use App\Models\Rent;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RentDataTable $dataTable)
    {
        //
        $pageTitle = __('message.list_form_title', ['form' => __('message.rent')]);
        $auth_user = authSession();
        $assets = ['dataTable'];
        $button = '';
        return $dataTable->render('global.datatable', compact('pageTitle', 'button', 'auth_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
        $pageTitle = __('message.rent', ['form' => __('message.drive')]);
        $types  = Type::all();
        return view("rent.form", compact('pageTitle', 'types'));
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
        $request->validate([
            'plate_number' => 'unique:items,plate_number'

        ]);
        $selling_price = $request->price - ($request->price * ($request->discount / 100));
        $data = [
            'name' => $request->name,
            'brand' => $request->brand,
            'model' => $request->model,
            'color' => $request->color,
            'plate_number' => $request->plate_number,
            'production_date' => $request->production_date,
            'type_id' => $request->type,
            'price' => $request->price,
            'discount' => $request->discount,
            'price_after_discount' => $selling_price
        ];
        $rent = Item::create($data);
        $rent->addMedia($request->vehcile_image)->toMediaCollection("rent");
        $message = __('message.save_form', ['form' => __('message.rent')]);
        return redirect()->route('rent.index')->withSuccess($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Item $rent)
    {
        // 
        $rent->load('type');
        $pageTitle = __('message.rent', ['form' => __('message.show')]);
        return view('rent.show', compact('pageTitle', 'rent'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $rent)
    {
        //
        $pageTitle = __('message.update_form_title', ['form' => __('message.rent')]);
        return view('rent.form', compact('pageTitle', 'rent'));
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
        if (env('APP_DEMO')) {
            $message = __('message.demo_permission_denied');
            if (request()->ajax()) {
                return response()->json(['status' => true, 'message' => $message]);
            }
            return redirect()->route('rent.index')->withErrors($message);
        }
        $rent = Item::find($id);
        $status = 'errors';
        $message = __('message.not_found_entry', ['name' => __('message.rent')]);

        if ($rent != '') {
            $search = "id" . '":' . $id;
            Notification::where('data', 'like', "%{$search}%")->delete();
            $rent->delete();
            $status = 'success';
            $message = __('message.delete_form', ['form' => __('message.rent')]);
        }

        if (request()->is('api/*')) {
            return json_message_response($message);
        }

        if (request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message]);
        }

        return redirect()->back()->with($status, $message);
    }
}
