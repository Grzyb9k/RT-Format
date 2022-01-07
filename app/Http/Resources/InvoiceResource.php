<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource

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
            'id' => $this->id,
            'invoice_nr' => $this->invoice_nr,
            'seller' => new SellerResource($this->seller),
            'customer' => new CustomerResource($this->customer),
            'product' => ProductResource::collection($this->products)->first(),
            'amount' => $this->amount,
            'invoice_date' => $this->invoice_date,
            'updated_at' => $this->updated_at->format('Y-m-d'),
        ];
    }

}
