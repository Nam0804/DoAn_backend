<?php
namespace App\Repository;

use App\Models\Category;
use App\Models\Invoice;
use App\Repository\interface\InvoiceRepositoryInterface;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function getAll()
    {
        $invoice = Invoice::all();
        return $invoice;
    }
    public function getById($id)
    {
        $invoice = Invoice::find($id);
        return $invoice;
    }
}