<?php 

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RevenueController extends Controller
{
    public function getRevenue()
    {
        $currentweekStartDate = Carbon::now()->startOfWeek();
        $currentweekEndDate = Carbon::now()->endOfWeek();
        $currentYear = Carbon::now()->year;

        $productSellByCategory = DB::table('invoices_detail')
            ->join('products','invoices_detail.product_id','=','products.id')
            ->join('categories','products.category_id','=','categories.id')
            ->select('categories.name as category','products.name as product',DB::raw('sum(invoices_detail.quantity) as total'))
            ->groupBy('categories.name','products.name')
            ->get();

        $orderLastWeek = DB::table('invoices')
            ->whereBetween('invoice_date',[$currentweekStartDate->copy()->subWeek(),$currentweekEndDate->copy()->subWeek()])
            ->count();
        $revenueLastMonth = DB::table('invoices')
            ->whereMonth('invoice_date',Carbon::now()->subMonth()->month)
            ->sum('total_amount');
        $revenueLastWeek = DB::table('invoices')
            ->whereBetween('invoice_date',[$currentweekStartDate->copy()->subWeek(),$currentweekEndDate->copy()->subWeek()])
            ->sum('total_amount');
        $revenueThisWeek = DB::table('invoices')
            ->whereBetween('invoice_date',[$currentweekStartDate,$currentweekEndDate])
            ->sum('total_amount');
        $orderthisweek = DB::table('invoices')
            ->whereBetween('invoice_date',[$currentweekStartDate,$currentweekEndDate])
            ->count();
        $revenueThisYear = DB::table('invoices')
            ->whereYear('invoice_date',$currentYear)
            ->sum('total_amount');
        $revenueByYear = DB::table('invoices')
            ->select(DB::raw('sum(total_amount) as total'), DB::raw('YEAR(invoice_date) as year'))  
            ->groupBy('year')
            ->get();
        $revenueByMonth = DB::table('invoices')
            ->select(DB::raw('sum(total_amount) as total'), DB::raw('MONTH(invoice_date) as month'),Db::raw('YEAR(invoice_date) as year'))  
            ->groupBy('month','year')
            ->get();
        $revenueThisMonth = DB::table('invoices')
            ->whereMonth('invoice_date',Carbon::now()->month)
            ->sum('total_amount');

        return response()->json([
            'productSellByCategory' => $productSellByCategory,
            'orderLastWeek' => $orderLastWeek,
            'revenueLastMonth' => $revenueLastMonth,
            'revenueThisMonth' => $revenueThisMonth,
            'revenueLastWeek' => $revenueLastWeek,
            'revenueThisWeek' => $revenueThisWeek,
            'orderthisweek' => $orderthisweek,
            'revenueByMonth' => $revenueByMonth,
            'revenueThisYear' => $revenueThisYear,
            'revenueByYear' => $revenueByYear,
        ]); 
    }
}