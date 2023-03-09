<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            "id"=> $this->id,
            "image" => env("APP_URL").'/storage/images/'.$this->image,
            'TEST' => $this->image,
            "email" => $this->email,
            "address" => $this->address,
            "phone" => $this->phone,
            "bio" => $this->bio,
            "user" => isset($this->user) ? new UserJson($this->user) : null

        ];
    }
}
