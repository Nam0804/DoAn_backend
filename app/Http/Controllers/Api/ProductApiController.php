<?php

namespace App\Http\Controllers\Api;

use App\Traits\HttpResponses;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Cart;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductBorder;
use App\Models\ProductSize;
use App\Models\ProductTopping;
use App\Repository\interface\ProductRepositoryInterface;
use App\Repository\ProductsRepository;

class ProductApiController extends Controller
{
    protected $product;
    use HttpResponses;
    public function __construct(ProductsRepository $product)
    {
        $this->product = $product;
    }
    public function index()
    {
        $products = $this->product->getAll();
        //$products = Product::all();
        if ($products) {
            return $this->success(
                ProductResource::collection($products),
                200,
                'All Products Fetched Successfully'
            );
        } else {
            return $this->error(null, 404, 'No Product Found');
        }
    }
    public function getAllById($id, Request $request,)
    {
        $product = $this->product->getAllProductById($id, $request);

        if ($product) {
            return $this->success(
                ProductResource::collection($product),
                200,
                'All Products Fetched Successfully'
            );
        } else {
            return $this->error(null, 404, 'No Product Found');
        }
    }
    public function showProductById($id)
    {
        $product = $this->product->getProductById($id);
        if ($product) {
            return $this->success(
                new ProductResource($product),
                200,
                'Product Fetched Successfully'
            );
        } else {
            return $this->error(null, 404, 'Product Not Found');
        }
    }
    public function store(Request $request)
    {
        $product = $this->product->storeProduct($request);
        if ($product) {
            return $this->success(
                new ProductResource($product),
                201,
                'Product Created Successfully'
            );
        } else {
            return $this->error(null, 404, 'Product Not Created');
        }
    }
    public function destroy($id)
    {
        $product = $this->product->deleteProduct($id);
        if ($product) {
            return $this->success(
                null,
                200,
                'Product Deleted Successfully'
            );
        } else {
            return $this->error(null, 404, 'Product Not Found');
        }
    }
    public function vnpayment(Request $request)
    {
        try {
            switch ($request->payment_method_id) {
                case '1':
                    $invoice = Cart::all();
                    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                    $vnp_Returnurl = 'http://localhost:3000/vnpayreturn';
                    $vnp_TxnRef = 2; //Mã giao dịch thanh toán tham chiếu của merchant
                    $vnp_Amount = 200000; // Số tiền thanh toán
                    $vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
                    $vnp_BankCode = ''; //Mã phương thức thanh toán
                    $vnp_IpAddr = '192.168.1.11'; //IP Khách hàng thanh toán $_SERVER['REMOTE_ADDR']
                    $vnp_TmnCode = '9Q9YJ2AM';
                    $vnp_HashSecret = 'QDAJQOGXUXYAUALFIGKQFDEDOUEJCDOK';
                    // Invoice
                    $inputData = array(
                        "vnp_Version" => "2.1.0",
                        "vnp_TmnCode" => $vnp_TmnCode,
                        "vnp_Amount" => $vnp_Amount * 100,
                        "vnp_Command" => "pay",
                        "vnp_CreateDate" => date('YmdHis'),
                        "vnp_CurrCode" => "VND",
                        "vnp_IpAddr" => $vnp_IpAddr,
                        "vnp_Locale" => $vnp_Locale,
                        "vnp_OrderInfo" => $vnp_TxnRef,
                        "vnp_OrderType" => "other",
                        "vnp_ReturnUrl" => $vnp_Returnurl,
                        "vnp_TxnRef" => $vnp_TxnRef,
                    );
                    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                        $inputData['vnp_BankCode'] = $vnp_BankCode;
                    }
                    ksort($inputData);
                    $query = "";
                    $i = 0;
                    $hashdata = "";
                    foreach ($inputData as $key => $value) {
                        if ($i == 1) {
                            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                        } else {
                            $hashdata .= urlencode($key) . "=" . urlencode($value);
                            $i = 1;
                        }
                        $query .= urlencode($key) . "=" . urlencode($value) . '&';
                    }
                    $vnp_Url = $vnp_Url . "?" . $query;
                    if (isset($vnp_HashSecret)) {
                        $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
                        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                    }

                    return redirect()->to($vnp_Url);
                    break;
                case '0':
                    try {
                        $cart = Cart::all();
                        $total_amount = 0;
                        $invoice = Invoice::create([
                            'payment_method' => $request->payment_method_id,
                            'name' => $request->name,
                            'email' => $request->email,
                            'phone' => $request->phone,
                            'invoice_date' => now(),
                            'user_id' => $request->user_id,
                            'total_amount' => $total_amount,
                        ]);
                        $invoice_id = $invoice->id;
                        foreach ($cart as $item) {
                            $size_price = ProductSize::where('product_id', $item->product_id)
                                ->where('size_id', $item->size)
                                ->pluck('price')
                                ->first();
                            $size_price = $size_price ? $size_price : 0;
                            $border_price = ProductBorder::where('product_id', $item->product_id)
                                ->where('border_id', $item->border)
                                ->pluck('price')
                                ->first();
                            $topping_price = ProductTopping::where('product_id', $item->product_id)
                                ->where('topping_id', $item->topping)
                                ->pluck('price')
                                ->first();
                            if($item->price)
                            {
                                $sub_total = $item->price * $item->quantity;
                            }else{
                            $sub_total = ($size_price + $border_price + $topping_price) * $item->quantity;
                            }
                            $total_amount += $sub_total;
                            InvoiceDetail::create([
                                'user_id' => $request->user_id,
                                'invoice_id' => $invoice_id,
                                'product_id' => $item->product_id,
                                'quantity' => $item->quantity,
                                'price' => $item->price,
                                'base' => $item->base,
                                'border' => $border_price,
                                'border_id' => $item->border,
                                'size_id' => $item->size,
                                'topping_id' => $item->topping,
                                'size' => $size_price,
                                'topping' => $topping_price,
                                'sub_total' => $sub_total
                            ]);
                        }
                        $invoice->total_amount = $total_amount;
                        $invoice->save();
                        Cart::truncate();
                        return response()->json(['message' => 'Đặt hàng thành công'], 200);
                    } catch (\Exception $e) {
                        return response()->json(['message' => $e->getMessage()], 500);
                    }
                    break;
                default:
                    echo 'Chức năng thanh toán này chưa được tích hợp vì ko có api ';
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
