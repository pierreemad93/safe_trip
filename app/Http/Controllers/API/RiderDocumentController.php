<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\RiderDocument;
use App\Http\Controllers\Controller;
use App\Http\Resources\RiderDocumentResource;

class RiderDocumentController extends Controller
{
    //
    public function getList(Request $request)
    {
        $rider_document = RiderDocument::myDocument();

        $rider_document->when(request('rider_id'), function ($q) {
            return $q->where('rider_id', request('rider_id'));
        });
        
        $per_page = config('constant.PER_PAGE_LIMIT');
        
        if( $request->has('per_page') && !empty($request->per_page)){
            if(is_numeric($request->per_page))
            {
                $per_page = $request->per_page;
            }
            if($request->per_page == -1 ){
                $per_page = $rider_document->count();
            }
        }

        $rider_document = $rider_document->orderBy('id','desc')->paginate($per_page);
        $items = RiderDocumentResource::collection($rider_document);

        $response = [
            'pagination' => json_pagination_response($items),
            'data' => $items,
        ];
        
        return json_custom_response($response);
    }
}
