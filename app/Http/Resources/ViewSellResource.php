<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ViewSellResource extends JsonResource
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
        "price_sell" => $this->price_sell,
        "shares" => $this->shares,
        "phone_number" => $this->phone_number,
        "date_sell" => $this->date_sell,
    ];
    }
}
