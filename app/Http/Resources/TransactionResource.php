<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'total' => $this->total,
            'code' => $this->code,
            'type' => ucwords($this->type), 
            'date' => $this->created_at->toFormattedDateString()
        ];
    }
}
