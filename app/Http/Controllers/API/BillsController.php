<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Models\AccountLinks; 
use App\Models\Bills;
use App\Models\PaidBills;
use Illuminate\Support\Facades\Auth; 
use App\Models\UserAppLogs;
use Validator;
use Illuminate\Support\Facades\DB;

class BillsController extends Controller 
{
    public $successStatus = 200;

    public function getLatestBills(Request $request) {
        $bills = DB::connection('sqlsrv2')
                    ->table('Bills')
                    ->leftJoin('BillsExtension', function($join) {
                        $join->on('Bills.AccountNumber', '=', 'BillsExtension.AccountNumber')
                            ->on('Bills.ServicePeriodEnd', '=', 'BillsExtension.ServicePeriodEnd');
                    })
                    ->leftJoin('PaidBills', 'Bills.BillNumber', '=', 'PaidBills.BillNumber')
                    ->select(
                        'Bills.AccountNumber',
                        'Bills.PowerPreviousReading',
                        'Bills.PowerPresentReading',
                        'Bills.DemandPreviousReading',
                        'Bills.DemandPresentReading',
                        'Bills.NetMeteringNetAmount',
                        'Bills.ReferenceNo',
                        'Bills.DAA_GRAM',
                        'Bills.DAA_ICERA',
                        'Bills.ACRM_TAFPPCA',
                        'Bills.ACRM_TAFxA',
                        'Bills.DAA_VAT',
                        'Bills.ACRM_VAT',
                        'Bills.NetPresReading',
                        'Bills.NetPowerKWH',
                        'Bills.NetGenerationAmount',
                        'Bills.CreditKWH',
                        'Bills.CreditAmount',
                        'Bills.NetMeteringSystemAmt',
                        'Bills.Item3',
                        'Bills.Item4',
                        'Bills.SeniorCitizenDiscount',
                        'Bills.SeniorCitizenSubsidy',
                        'Bills.UCMERefund',
                        'Bills.NetPrevReading',
                        'Bills.CrossSubsidyCreditAmt',
                        'Bills.MissionaryElectrificationAmt',
                        'Bills.EnvironmentalAmt',
                        'Bills.LifelineSubsidyAmt',
                        'Bills.Item1',
                        'Bills.Item2',
                        'Bills.DistributionSystemAmt',
                        'Bills.SupplyRetailCustomerAmt',
                        'Bills.SupplySystemAmt',
                        'Bills.MeteringRetailCustomerAmt',
                        'Bills.MeteringSystemAmt',
                        'Bills.SystemLossAmt',
                        'Bills.FBHCAmt',
                        'Bills.FPCAAdjustmentAmt',
                        'Bills.ForexAdjustmentAmt',
                        'Bills.TransmissionDemandAmt',
                        'Bills.TransmissionSystemAmt',
                        'Bills.DistributionDemandAmt',
                        'Bills.EPAmount',
                        'Bills.PCAmount',
                        'Bills.LoanCondonation',
                        'Bills.BillingPeriod',
                        'Bills.UnbundledTag',
                        'Bills.GenerationSystemAmt',
                        'Bills.PPCAAmount',
                        'Bills.UCAmount',
                        'Bills.MeterNumber',
                        'Bills.ConsumerType',
                        'Bills.BillType',
                        'Bills.QCAmount',
                        'Bills.PPA',
                        'Bills.PPAAmount',
                        'Bills.BasicAmount',
                        'Bills.PRADiscount',
                        'Bills.PRAAmount',
                        'Bills.PPCADiscount',
                        'Bills.AverageKWDemand',
                        'Bills.CoreLoss',
                        'Bills.Meter',
                        'Bills.PR',
                        'Bills.SDW',
                        'Bills.Others',
                        'Bills.ServiceDateFrom',
                        'Bills.ServiceDateTo',
                        'Bills.DueDate',
                        'Bills.BillNumber',
                        'Bills.Remarks',
                        'Bills.AverageKWH',
                        'Bills.Charges',
                        'Bills.Deductions',
                        'Bills.NetAmount',
                        'Bills.PowerRate',
                        'Bills.DemandRate',
                        'Bills.BillingDate',
                        'Bills.AdditionalKWH',
                        'Bills.AdditionalKWDemand',
                        'Bills.PowerKWH',
                        'Bills.KWHAmount',
                        'Bills.DemandKW',
                        'Bills.KWAmount',
                        'BillsExtension.GenerationVAT',
                        'BillsExtension.TransmissionVAT',
                        'BillsExtension.SLVAT',
                        'BillsExtension.DistributionVAT',
                        'BillsExtension.OthersVAT',
                        'BillsExtension.Item5',
                        'BillsExtension.Item6',
                        'BillsExtension.Item7',
                        'BillsExtension.Item8',
                        'BillsExtension.Item9',
                        'BillsExtension.Item10',
                        'BillsExtension.Item11',
                        'BillsExtension.Item12',
                        'BillsExtension.Item13',
                        'BillsExtension.Item14',
                        'BillsExtension.Item15',
                        'BillsExtension.Item16',
                        'BillsExtension.Item17',
                        'BillsExtension.Item18',
                        'BillsExtension.Item19',
                        'BillsExtension.Item20',
                        'BillsExtension.Item21',
                        'BillsExtension.Item22',
                        'BillsExtension.Item23',
                        'BillsExtension.Item24',
                        'Bills.ServicePeriodEnd',
                        'PaidBills.NetAmount as NetAmountPaid')
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
     * GET FULL BILL DETAILS
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
                            'Bills.PowerPreviousReading',
                            'Bills.PowerPresentReading',
                            'Bills.PowerKWH',
                            'Bills.GenerationSystemAmt',
                            'Bills.TransmissionSystemAmt',
                            'Bills.SystemLossAmt',
                            'Bills.DistributionSystemAmt',
                            'Bills.DistributionDemandAmt',
                            'Bills.SupplySystemAmt as RetailElectricServiceAmount',
                            'Bills.SupplyRetailCustomerAmt as RetailElectricServiceAmountKW',
                            'Bills.MeteringSystemAmt',
                            'Bills.MeteringRetailCustomerAmt',
                            'Bills.MissionaryElectrificationAmt',
                            'Bills.FPCAAdjustmentAmt as NPCStraindedDebtsAmount',
                            'Bills.ForexAdjustmentAmt as NPCStrandedCostAmount',
                            'Bills.EnvironmentalAmt',
                            'Bills.ACRM_TAFPPCA',
                            'Bills.ACRM_TAFxA',
                            'Bills.DAA_GRAM',
                            'Bills.DAA_ICERA',
                            'Bills.FBHCAmt as FranchiseTaxAmount',
                            'Bills.LifelineSubsidyAmt',
                            'Bills.Item4 as FitAllAmount',
                            'Bills.Others as OtherChargesAmount',
                            'Bills.DAA_VAT as DaaVatAmount',
                            'Bills.ACRM_VAT as AcrmVatAmount',
                            'Bills.PR as TransformerRental',
                            'Bills.SeniorCitizenSubsidy',
                            'Bills.Remarks as SubscriberNo',)
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
                        'BillsExtension.Item20 as OtherSystemLossAdj',
                        'BillsExtension.Item16 as BusinessTaxAmount',
                        'BillsExtension.Item17 as RealPropertyTaxAmount',
                        'BillsExtension.Item21 as OtherLifelineAmount',
                        'BillsExtension.Item10 as RFSCAmount',
                        'BillsExtension.Item22 as OtherSeniorAdjAmount',
                        'BillsExtension.GenerationVAT',
                        'BillsExtension.TransmissionVAT',
                        'BillsExtension.SLVAT as SystemsLossVat',
                        'BillsExtension.DistributionVAT',
                        'BillsExtension.OthersVAT',
                        'BillsExtension.Item5 as MandatoryReducAmount',)
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
                        'UnbundledRates.MeteringRetailCustomerCharge',
                        'UnbundledRates.MissionaryElectrificationCharge',
                        'UnbundledRates.FPCAAdjustmentCharge as NPCStrandedDebtsRate',
                        'UnbundledRates.ForexAdjustmentCharge as NPCStrandedCostRate',
                        'UnbundledRates.EnvironmentalCharge',
                        'UnbundledRates.ACRM_TAFPPCACharge',
                        'UnbundledRates.ACRM_TAFxACharge',
                        'UnbundledRates.DAA_GRAMCharge',
                        'UnbundledRates.DAA_ICERACharge',
                        'UnbundledRates.FBHCCharge as FranchiseTaxRate',
                        'UnbundledRates.ACRM_TAFxACharge as RealPropertyTaxRate',
                        'UnbundledRates.LifelineSubsidyCharge',
                        'UnbundledRates.MCC as RFSCRate',
                        'UnbundledRates.PPARefund as FitAllRate',
                        'UnbundledRates.CrossSubsidyCreditCharge as SystemLossVatRate',
                        'UnbundledRates.DAA_VAT as DaaVatRate',
                        'UnbundledRates.ACRM_VAT as AcrmVatRate',
                        'UnbundledRates.SeniorCitizenSubsidyCharge',)
                    ->first();

            $ratesExtension = DB::connection('sqlsrv2')
                    ->table('UnbundledRatesExtension')
                    ->where('ConsumerType', $bill->ConsumerType)
                    ->where('ServicePeriodEnd', $bill->ServicePeriodEnd)
                    ->select('UnbundledRatesExtension.Item2',
                        'UnbundledRatesExtension.Item7 as OtherGenerationAdjRate',
                        'UnbundledRatesExtension.Item8 as OtherTransmissionRate',
                        'UnbundledRatesExtension.Item9 as OtherSystemLossRate',
                        'UnbundledRatesExtension.Item6 as BusinessTaxRate',
                        'UnbundledRatesExtension.Item10 as OtherLifelineRate',                        
                        'UnbundledRatesExtension.Item11 as OtherSeniorAdjRate',                       
                        'UnbundledRatesExtension.Item3 as GenerationVatRate',                     
                        'UnbundledRatesExtension.Item4 as TransmissionVatRate',                   
                        'UnbundledRatesExtension.Item2 as DistributionVatRate',                
                        'UnbundledRatesExtension.Item2 as OthersVatRate',              
                        'UnbundledRatesExtension.Item5 as MandatoryReducRate',)
                    ->first();

            // REGISTER LOG
            $log = new UserAppLogs;
            $log->UserId = $request['u'];
            $log->Type = "Queried Bill";
            $log->Details = "Queried bill with bill number " . $bill->BillNumber;
            $log->save();

            return response()->json((object)array_merge((array)$bill, (array)$rates, (array)$ratesExtension,  (array)$billsExtension), $this-> successStatus); 
        }
    }

    /**
     * GET FULL ACCOUNT INFO
     * @Params
     * q = Account Number
     */
    public function getAccountInformation(Request $request) {
        $accountMaster = DB::connection('sqlsrv2')
                    ->table('AccountMaster')
                    ->where('AccountNumber', $request['q'])
                    ->select('AccountNumber',
                            'ConsumerName',
                            'ConsumerAddress',
                            'ConsumerType',
                            'AccountStatus',
                            'MeterNumber',
                            'Transformer',
                            'Pole',
                            'ComputeMode',
                            'Email',
                            'ContactNumber')
                    ->first();

        if ($accountMaster != null) {
            $accountMasterExtension = DB::connection('sqlsrv2')
                    ->table('AccountMasterExtension')
                    ->where('AccountNumber', $request['q'])
                    ->select('ServiceVoltage')
                    ->first();

            return response()->json((object)array_merge((array)$accountMaster, (array)$accountMasterExtension), $this-> successStatus); 
        } else {
            return response()->json(['error' => 'Account not found'], 404);
        }
    }

    /**
     * GET PREVIOUS CONSUMPTION FOR GRAPH
     * @ PARAMS
     * q = Account Number
     */
    public function getPreviousForGraph(Request $request) {
        $bills = DB::connection('sqlsrv2')
            ->table('Bills')
            ->where('AccountNumber', $request['q'])
            ->select('NetAmount', 'PowerKWH', 'ServicePeriodEnd')
            ->orderByDesc('ServicePeriodEnd')
            ->limit(12)
            ->get();

        if ($bills != null) {
            return response()->json($bills, $this-> successStatus); 
        } else {
            return response()->json(['error' => 'Bills not found'], 404);
        }
    }

    public function getAllBillByYear(Request $request) {
        $bills = DB::connection('sqlsrv2')
                    ->table('Bills')
                    ->leftJoin('PaidBills', 'Bills.BillNumber', '=', 'PaidBills.BillNumber')
                    ->select('Bills.BillNumber', 'Bills.ServicePeriodEnd', 'Bills.PowerKWH', 'Bills.NetAmount', 'PaidBills.NetAmount as NetAmountPaid')
                    ->where('Bills.AccountNumber', $request['q'])
                    ->whereBetween('Bills.ServicePeriodEnd', [date('Y-m-d', strtotime($request['y'] . '-01-01')), date('Y-m-d', strtotime($request['y'] . '-12-30'))])
                    ->orderByDesc('Bills.ServicePeriodEnd')
                    ->get();

        if ($bills == null) {
            return response()->json(['error' => 'No bills found'], 404);
        } else {
            return response()->json($bills, $this-> successStatus); 
        }
    }
}