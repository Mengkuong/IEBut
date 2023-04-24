<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BuyResource extends JsonResource
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
            "name_seller" => $this->name_seller,
            "price_buy" => $this->price_buy,
            "shares" => $this->shares,
            "phone_number_buyer" => $this->phone_number_buyer,
            "phone_number_seller" => $this->phone_number_seller,
            "date_buy" => $this->date_buy,
            "buy_form" => $this->buy_form,
        ];
    }
}
