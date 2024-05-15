<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceDetailResource;
use App\Http\Resources\InvoiceResource;
use App\Repository\InvoiceDetailRepository;
use App\Repository\InvoiceRepository;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class InvoiceDetailApiController extends Controller
{
    protected $invoicesDetail;
    use HttpResponses;
    public function __construct(InvoiceDetailRepository $invoicesDetail)
    {
        $this->invoicesDetail = $invoicesDetail;
    }
    public function invoiceDetailById($id)
    {
        
        $invoiceInformation = $this->invoicesDetail->getInvoiceDetailById($id);
        //dd($invoiceInformation);
        return $invoiceInformation;
    }
}
