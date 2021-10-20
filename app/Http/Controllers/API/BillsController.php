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

    /**
     * @Params
     * q = Bill Number
     */
    public function getBillDetails(Request $request) {
        $bill = DB::connection('sqlsrv2')
                    ->table('Bills')
                    ->where('Bills.BillNumber', $request['q'])
                    ->select('Bills.ServicePeriodEnd',
                            'Bills.AccountNumber',
                            'Bills.BillNumber',
                            'Bills.ConsumerType',
                            'Bills.NetAmount',
                            'Bills.DueDate',
                            'Bills.ServiceDateFrom',
                            'Bills.ServiceDateTo',
                            'Bills.GenerationSystemAmt',
                            'Bills.TransmissionSystemAmt',
                            'Bills.SystemLossAmt',
                            'Bills.DistributionSystemAmt',
                            'Bills.DistributionDemandAmt',
                            'Bills.SupplySystemAmt as RetailElectricServiceAmount',
                            'Bills.SupplyRetailCustomerAmt as RetailElectricServiceAmountKW',
                            'Bills.MeteringSystemAmt',
                            'Bills.MeteringRetailCustomerAmt',)
                    ->first();

        if ($bill == null) {
            return response()->json(['error' => 'No bill found'], 404);
        } else {
            $billsExtension = DB::connection('sqlsrv2')
                    ->table('BillsExtension')
                    ->where('AccountNumber', $bill->AccountNumber)
                    ->where('ServicePeriodEnd', $bill->ServicePeriodEnd)
                    ->select('BillsExtension.Item18 as OtherGenerationAdj',
                        'BillsExtension.Item19 as OtherTransmissionAdj',
                        'BillsExtension.Item20 as OtherSystemLossAdj',)
                    ->first();

            $rates = DB::connection('sqlsrv2')
                    ->table('UnbundledRates')
                    ->where('ConsumerType', $bill->ConsumerType)
                    ->where('ServicePeriodEnd', $bill->ServicePeriodEnd)
                    ->select('UnbundledRates.GenerationSystemCharge',
                        'UnbundledRates.TransmissionSystemCharge',
                        'UnbundledRates.SystemLossCharge',
                        'UnbundledRates.DistributionSystemCharge',
                        'UnbundledRates.DistributionDemandCharge',
                        'UnbundledRates.SupplySystemCharge as RetailElectricServiceRate',
                        'UnbundledRates.SupplyRetailCustomerCharge as RetailElectricServiceRateKW',
                        'UnbundledRates.MeteringSystemCharge',
                        'UnbundledRates.MeteringRetailCustomerCharge',)
                    ->first();

            $ratesExtension = DB::connection('sqlsrv2')
                    ->table('UnbundledRatesExtension')
                    ->where('ConsumerType', $bill->ConsumerType)
                    ->where('ServicePeriodEnd', $bill->ServicePeriodEnd)
                    ->select('UnbundledRatesExtension.Item2',
                        'UnbundledRatesExtension.Item7 as OtherGenerationAdjRate',
                        'UnbundledRatesExtension.Item8 as OtherTransmissionRate',
                        'UnbundledRatesExtension.Item9 as OtherSystemLossRate')
                    ->first();

            return response()->json((object)array_merge((array)$bill, (array)$rates, (array)$ratesExtension,  (array)$billsExtension), $this-> successStatus); 
        }
    }

}