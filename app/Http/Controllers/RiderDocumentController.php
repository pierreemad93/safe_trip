<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiderDocument;
use App\Notifications\CommonNotification;
use App\DataTables\RiderDocumentDataTable;

class RiderDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RiderDocumentDataTable $dataTable)
    {
        //
        $pageTitle = __('message.list_form_title', ['form' => __('message.rider_document')]);
        $auth_user = authSession();
        $assets = ['datatable'];
        $button = $auth_user->can('driverdocument add') ? '<a href="' . route('riderdocument.create') . '" class="float-right btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> ' . __('message.add_form_title', ['form' => __('message.rider_document')]) . '</a>' : '';
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
        $pageTitle = __('message.add_form_title', ['form' => __('message.rider_document')]);

        return view('rider_document.form', compact('pageTitle'));
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
        $data = $request->all();
        // dd($data) ;
        $data['expire_date'] = request('expire_date') != null ? date('Y-m-d', strtotime(request('expire_date'))) : null;
        $data['is_verified'] = request('is_verified') != null ? request('is_verified') : 0;
        $data['rider_id'] = request('rider_id') == null && auth()->user()->hasRole('rider') ? auth()->user()->id : request('rider_id');
        $rider_document = RiderDocument::create($data);

        uploadMediaFile($rider_document, $request->rider_document, 'rider_document');

        $message = __('message.save_form', ['form' => __('message.rider_document')]);
        $is_verified = $rider_document->is_verified;
        // if (in_array($is_verified, [0, 1, 2])  || $rider_document->rider->is_verified_rider == 0) {
        //     $is_verified_rider = (int) $rider_document->verifyRiderDocument($rider_document->rider->id);
        //     $rider_document->rider->update(['is_verified_rider' => $is_verified_rider]);
        // }

        if (in_array($is_verified, [1, 2])) {
            $type = 'document_approved';
            $status = __('message.approved');
            if ($is_verified == 0) {
                $type = 'document_pending';
                $status = __('message.pending');
            }

            if ($is_verified == 2) {
                $type = 'document_rejected';
                $status = __('message.rejected');
            }
            $notification_data = [
                'id'   => $rider_document->rider->id,
                'is_verified_rider' => (int) $rider_document->rider->is_verified_rider,
                'type' => $type,
                'subject' => __('message.' . $type),
                'message' => __('message.approved_reject_form', ['form' => $rider_document->document->name, 'status' => $status]),
            ];

            $rider_document->rider->notify(new CommonNotification($notification_data['type'], $notification_data));
        }

        if (request()->is('api/*')) {
            return json_message_response($message);
        }

        return redirect()->route('riderdocument.index')->withSuccess($message);
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
        $pageTitle = __('message.add_form_title', ['form' => __('message.rider_document')]);
        $data = RiderDocument::findOrFail($id);

        return view('rider_document.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $pageTitle = __('message.update_form_title', ['form' => __('message.rider_document')]);
        $data = RiderDocument::findOrFail($id);

        return view('rider_document.form', compact('data', 'pageTitle', 'id'));
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
        $rider_document = RiderDocument::find($id);

        if ($rider_document == '') {
            $message = __('message.not_found_entry', ['name' => __('message.rider_document')]);

            if (request()->is('api/*')) {
                return json_message_response($message);
            }

            return redirect()->route('riderdocument.index')->withErrors($message);
        }
        $old_is_verified = $rider_document->is_verified;
        // RiderDocument data...
        $rider_document->fill($request->all())->update();

        if (isset($request->rider_document) && $request->rider_document != null) {
            $rider_document->clearMediaCollection('rider_document');
            $rider_document->addMediaFromRequest('rider_document')->toMediaCollection('rider_document');
        }

        $message = __('message.update_form', ['form' => __('message.rider_document')]);

        $is_verified = $rider_document->is_verified;
        // if (in_array($is_verified, [0, 1, 2])  || $rider_document->rider->is_verified_rider == 0) {
        //     $is_verified_rider = (int) $rider_document->verifyRiderDocument($rider_document->rider->id);
        //     $rider_document->rider->update(['is_verified_rider' => $is_verified_rider]);
        // }

        if ($old_is_verified != $is_verified && in_array($is_verified, [0, 1, 2])) {

            $type = 'document_approved';
            $status = __('message.approved');
            if ($is_verified == 0) {
                $type = 'document_pending';
                $status = __('message.pending');
            }

            if ($is_verified == 2) {
                $type = 'document_rejected';
                $status = __('message.rejected');
            }
            $notification_data = [
                'id'   => $rider_document->rider->id,
                'is_verified_rider' => (int) $rider_document->rider->is_verified_rider,
                'type' => $type,
                'subject' => __('message.' . $type),
                'message' => __('message.approved_reject_form', ['form' => $rider_document->document->name, 'status' => $status]),
            ];

            $rider_document->rider->notify(new CommonNotification($notification_data['type'], $notification_data));
        }
        if (request()->is('api/*')) {
            return json_message_response($message);
        }

        if (auth()->check()) {
            return redirect()->route('riderdocument.index')->withSuccess($message);
        }
        return redirect()->back()->withSuccess($message);
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
        if (env('APP_DEMO')) {
            $message = __('message.demo_permission_denied');
            if (request()->ajax()) {
                return response()->json(['status' => true, 'message' => $message]);
            }
            return redirect()->route('riderdocument.index')->withErrors($message);
        }
        $rider_document = RiderDocument::find($id);
        $status = 'errors';
        $message = __('message.not_found_entry', ['name' => __('message.rider_document')]);

        if ($rider_document != '') {
            $rider_document->delete();
            $status = 'success';
            $message = __('message.delete_form', ['form' => __('message.rider_document')]);
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
