<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserWalletResource extends JsonResource
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
            'qr_code' => $this->wallet->name,
            'status' => $this->status == 1 ? "activated" : "deactivated",
            'balance' => $this->balance == null ? 0 : $this->balance
        ];
    }
}
