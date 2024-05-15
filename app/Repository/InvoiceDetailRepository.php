<?php
namespace App\Repository;

use App\Models\Base;
use App\Models\Border;
use App\Models\InvoiceDetail;
use App\Models\Product;
use App\Models\Size;
use App\Models\Topping;
use App\Repository\interface\InvoiceDetailRepositoryInterface;

class InvoiceDetailRepository implements InvoiceDetailRepositoryInterface
{
    public function getInvoiceDetailById($id)
    {
        $invoiceDetail = InvoiceDetail::where('invoice_id',$id)->get();
        $invoiceInformation = [];
        foreach ($invoiceDetail as $invoice) {
            $product = Product::find($invoice->product_id);
            if($product->category_id == 1){
                $size = Size::find($invoice->size_id);
                $base = Base::find($invoice->base);
            }else{
                $size = null;
                $base = null;
            }        
            $topping = Topping::find($invoice->topping_id);
            $border = Border::find($invoice->border_id);
            $invoiceInformation[] = [
                'id' => $invoice->id,
                'invoice_id' => $invoice->invoice_id,
                'product_id' => $invoice->product_id,
                'product_name' => $product->name,
                'quantity' => $invoice->quantity,
                'base_name' => $base->name ?? null,
                'size_name' => $size->name ?? null,
                'topping_name' => $topping->name ?? null,
                'border_name' => $border->name ?? null,
                'price' => $invoice->price,
                'border' => $invoice->border,
                'topping' => $invoice->topping,
                'size' => $invoice->size ?? null, 
                'sub_total' => $invoice->sub_total,
            ];
            
        }
        return $invoiceInformation;
    }

}
