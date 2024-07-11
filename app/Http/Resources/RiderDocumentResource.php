<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RiderDocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'rider_id'         => $this->rider_id,
            'document_id'       => $this->document_id,
            'document_name'     => optional($this->document)->name,
            'rider_name'       => optional($this->rider)->display_name,
            'is_verified'       => $this->is_verified,
            'expire_date'       => $this->expire_date,
            'rider_document'   => getSingleMedia($this, 'rider_document', null),
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at
        ];
    }
}
