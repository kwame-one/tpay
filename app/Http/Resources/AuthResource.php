<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $role = "";
        if($this->role_id == 2)
            $role = "driver";
        else if($this->role_id == 3)
            $role = "normal";

        return [
            'id' => $this->id,
            'surname' => $this->surname,
            'othernames' => $this->other_names,
            'contact' => $this->contact,
            // 'verified' => $this->verified == 1 ? "yes" : "no",
            'role' => $role,
            'wallet' => $this->userWallet ? new UserWalletResource($this->userWallet): null,
            'driver' => $this->driver ? new DriverResource($this->driver) : null,
            'access_token' => $this->token,
            'type' => 'bearer'
        ];
    }
}
