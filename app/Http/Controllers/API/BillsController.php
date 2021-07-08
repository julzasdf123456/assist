<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Models\AccountLinks; 
use App\Models\Bills;
use App\Models\PaidBills;
use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Support\Facades\DB;

class BillsController extends Controller 
{
    public $successStatus = 200;

    public function getLatestBills(Request $request) {
        $bills = DB::connection('sqlsrv2')
                    ->table('Bills')
                    ->leftJoin('PaidBills', 'Bills.BillNumber', '=', 'PaidBills.BillNumber')
                    ->select('Bills.BillNumber', 'Bills.ServicePeriodEnd', 'Bills.PowerKWH', 'Bills.NetAmount', 'PaidBills.NetAmount as NetAmountPaid')
                    ->where('Bills.AccountNumber', $request['q'])
                    ->orderByDesc('Bills.ServicePeriodEnd')
                    ->take(5)
                    ->get();

        if ($bills == null) {
            return response()->json(['error' => 'No bills found'], 404);
        } else {
            return response()->json($bills, $this-> successStatus); 
        }
    }

    public function getUnpaidBills(Request $request) {
        $bills = DB::connection('sqlsrv2')
                    ->table('Bills')
                    ->leftJoin('PaidBills', 'Bills.BillNumber', '=', 'PaidBills.BillNumber')
                    ->select('Bills.BillNumber', 'Bills.ServicePeriodEnd', 'Bills.PowerKWH', 'Bills.NetAmount', 'PaidBills.NetAmount as NetAmountPaid')
                    ->where('Bills.AccountNumber', $request['q'])
                    ->whereNull('PaidBills.NetAmount')
                    ->orderByDesc('Bills.ServicePeriodEnd')
                    ->take(5)
                    ->get();

        if ($bills == null) {
            return response()->json(['error' => 'No bills found'], 404);
        } else {
            return response()->json($bills, $this-> successStatus); 
        }
    }

}