<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;
    protected $table = 'invoices_detail';
    protected $guarded = [];
    //relation 1-1 to cart
    // public function cart()
    // {
    //     return $this->hasOne(Cart::class);
    // }
    
}
