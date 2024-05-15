<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class InvoiceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email'=> $this->email,
            'phone'=> $this->phone,
            'invoice_date' => $this->invoice_date,
            'shipping_address' => $this->shipping_address,
            'shipping_status' => $this->shipping_status,
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_status,
            'total_amount' => $this->total_amount,
        ];
    }
}