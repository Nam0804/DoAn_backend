<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Repository\InvoiceRepository;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class InvoiceApiController extends Controller
{
    protected $invoices;
    use HttpResponses;
    public function __construct(InvoiceRepository $invoices)
    {
        $this->invoices = $invoices;
    }
    public function index()
    {
        $invoicesList = $this->invoices->getAll();
        if($invoicesList){
            return $this->success(
                InvoiceResource::collection($invoicesList),
                200,
                'All Invoices Fetched Successfully'
            );
        }else{
            return $this->error(null,404,'No Invoices Found');
        }
    }
    public function show($id)
    {
        $invoice = $this->invoices->getById($id);
        if($invoice){
            return $this->success(
                new InvoiceResource($invoice),
                200,
                'Invoice Fetched Successfully'
            );
        }else{
            return $this->error(null,404,'Invoice Not Found');
        }
    }
}
