<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'vehicle_model' => $this->vehicle_model,
            'vehicle_number' => $this->vehicle_number,
            'balance' => $this->balance == null ? 0.00 : $this->balance
        ];
    }
}
