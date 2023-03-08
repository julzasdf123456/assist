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
                    ->leftJoin('PaidBills', function($join) {
                        $join->on('Bills.AccountNumber', '=', 'PaidBills.AccountNumber')
                            ->on('Bills.ServicePeriodEnd', '=', 'PaidBills.ServicePeriodEnd');
                    })
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
                            'Bills.Remarks as SubscriberNo',
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
                            'PaidBills.NetAmount As NetAmountPaid')
                        ->where('Bills.AccountNumber', $request['q'])
                        ->orderByDesc('Bills.ServicePeriodEnd')
                        ->take(5)
                        ->get();

        $data = [];
        foreach($bills as $item) {
            array_push($data, [
                'ServicePeriodEnd' => $item->ServicePeriodEnd,
                'AccountNumber' => $item->AccountNumber,
                'BillNumber' => $item->BillNumber,
                'ConsumerType' => $item->ConsumerType,
                'NetAmount' => $item->NetAmount,
                'DueDate' => $item->DueDate,
                'ServiceDateFrom' => $item->ServiceDateFrom,
                'ServiceDateTo' => $item->ServiceDateTo,
                'PowerPreviousReading' => $item->PowerPreviousReading,
                'PowerPresentReading' => $item->PowerPresentReading,
                'PowerKWH' => $item->PowerKWH,
                'GenerationSystemAmt' => $item->GenerationSystemAmt,
                'TransmissionSystemAmt' => $item->TransmissionSystemAmt,
                'SystemLossAmt' => $item->SystemLossAmt,
                'DistributionSystemAmt' => $item->DistributionSystemAmt,
                'DistributionDemandAmt' => $item->DistributionDemandAmt,
                'RetailElectricServiceAmount' => $item->RetailElectricServiceAmount,
                'RetailElectricServiceAmountKW' => $item->RetailElectricServiceAmountKW,
                'MeteringSystemAmt' => $item->MeteringSystemAmt,
                'MeteringRetailCustomerAmt' => $item->MeteringRetailCustomerAmt,
                'MissionaryElectrificationAmt' => $item->MissionaryElectrificationAmt,
                'NPCStraindedDebtsAmount' => $item->NPCStraindedDebtsAmount,
                'NPCStrandedCostAmount' => $item->NPCStrandedCostAmount,
                'EnvironmentalAmt' => $item->EnvironmentalAmt,
                'ACRM_TAFPPCA' => $item->ACRM_TAFPPCA,
                'ACRM_TAFxA' => $item->ACRM_TAFxA,
                'DAA_GRAM' => $item->DAA_GRAM,
                'DAA_ICERA' => $item->DAA_ICERA,
                'FranchiseTaxAmount' => $item->FranchiseTaxAmount,
                'LifelineSubsidyAmt' => $item->LifelineSubsidyAmt,
                'FitAllAmount' => $item->FitAllAmount,
                'OtherChargesAmount' => $item->OtherChargesAmount,
                'DaaVatAmount' => $item->DaaVatAmount,
                'AcrmVatAmount' => $item->AcrmVatAmount,
                'TransformerRental' => $item->TransformerRental,
                'SeniorCitizenSubsidy' => $item->SeniorCitizenSubsidy,
                'SubscriberNo' => $item->SubscriberNo,
                'GenerationVAT' => $item->GenerationVAT,
                'TransmissionVAT' => $item->TransmissionVAT,
                'SLVAT' => $item->SLVAT,
                'DistributionVAT' => $item->DistributionVAT,
                'OthersVAT' => $item->OthersVAT,
                'Item5' => $item->Item5,
                'Item6' => $item->Item6,
                'Item7' => $item->Item7,
                'Item8' => $item->Item8,
                'Item9' => $item->Item9,
                'Item10' => $item->Item10,
                'Item11' => $item->Item11,
                'Item12' => $item->Item12,
                'Item13' => $item->Item13,
                'Item14' => $item->Item14,
                'Item15' => $item->Item15,
                'Item16' => $item->Item16,
                'Item17' => $item->Item17,
                'Item18' => $item->Item18,
                'Item19' => $item->Item19,
                'Item20' => $item->Item20,
                'Item21' => $item->Item21,
                'Item22' => $item->Item22,
                'Item23' => $item->Item23,
                'Item24' => $item->Item24,
                'NetAmountPaid' => $item->NetAmountPaid,
                'Surcharges' => Bills::getSurchargeMobApp($item),
            ]);
            
        }

        if ($bills == null) {
            return response()->json(['error' => 'No bills found'], 404);
        } else {

            return response()->json($data, $this-> successStatus); 
        }
    }

    public function getUnpaidBills(Request $request) {
        $bills = DB::connection('sqlsrv2')
                ->table('Bills')
                ->leftJoin('BillsExtension', function($join) {
                    $join->on('Bills.AccountNumber', '=', 'BillsExtension.AccountNumber')
                        ->on('Bills.ServicePeriodEnd', '=', 'BillsExtension.ServicePeriodEnd');
                })
                ->leftJoin('PaidBills', function($join) {
                    $join->on('Bills.AccountNumber', '=', 'PaidBills.AccountNumber')
                        ->on('Bills.ServicePeriodEnd', '=', 'PaidBills.ServicePeriodEnd');
                })
                ->whereRaw("PaidBills.NetAmount IS NULL")
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
                            'Bills.Remarks as SubscriberNo',
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
                            'PaidBills.NetAmount As NetAmountPaid')
                        ->where('Bills.AccountNumber', $request['q'])
                        ->orderByDesc('Bills.ServicePeriodEnd')
                        ->take(5)
                        ->get();

       
        $data = [];
        foreach($bills as $item) {
            array_push($data, [
                'ServicePeriodEnd' => $item->ServicePeriodEnd,
                'AccountNumber' => $item->AccountNumber,
                'BillNumber' => $item->BillNumber,
                'ConsumerType' => $item->ConsumerType,
                'DueDate' => $item->DueDate,
                'ServiceDateFrom' => $item->ServiceDateFrom,
                'ServiceDateTo' => $item->ServiceDateTo,
                'PowerPreviousReading' => $item->PowerPreviousReading,
                'PowerPresentReading' => $item->PowerPresentReading,
                'PowerKWH' => $item->PowerKWH,
                'GenerationSystemAmt' => $item->GenerationSystemAmt,
                'TransmissionSystemAmt' => $item->TransmissionSystemAmt,
                'SystemLossAmt' => $item->SystemLossAmt,
                'DistributionSystemAmt' => $item->DistributionSystemAmt,
                'DistributionDemandAmt' => $item->DistributionDemandAmt,
                'RetailElectricServiceAmount' => $item->RetailElectricServiceAmount,
                'RetailElectricServiceAmountKW' => $item->RetailElectricServiceAmountKW,
                'MeteringSystemAmt' => $item->MeteringSystemAmt,
                'MeteringRetailCustomerAmt' => $item->MeteringRetailCustomerAmt,
                'MissionaryElectrificationAmt' => $item->MissionaryElectrificationAmt,
                'NPCStraindedDebtsAmount' => $item->NPCStraindedDebtsAmount,
                'NPCStrandedCostAmount' => $item->NPCStrandedCostAmount,
                'EnvironmentalAmt' => $item->EnvironmentalAmt,
                'ACRM_TAFPPCA' => $item->ACRM_TAFPPCA,
                'ACRM_TAFxA' => $item->ACRM_TAFxA,
                'DAA_GRAM' => $item->DAA_GRAM,
                'DAA_ICERA' => $item->DAA_ICERA,
                'FranchiseTaxAmount' => $item->FranchiseTaxAmount,
                'LifelineSubsidyAmt' => $item->LifelineSubsidyAmt,
                'FitAllAmount' => $item->FitAllAmount,
                'OtherChargesAmount' => $item->OtherChargesAmount,
                'DaaVatAmount' => $item->DaaVatAmount,
                'AcrmVatAmount' => $item->AcrmVatAmount,
                'TransformerRental' => $item->TransformerRental,
                'SeniorCitizenSubsidy' => $item->SeniorCitizenSubsidy,
                'SubscriberNo' => $item->SubscriberNo,
                'GenerationVAT' => $item->GenerationVAT,
                'TransmissionVAT' => $item->TransmissionVAT,
                'SLVAT' => $item->SLVAT,
                'DistributionVAT' => $item->DistributionVAT,
                'OthersVAT' => $item->OthersVAT,
                'Item5' => $item->Item5,
                'Item6' => $item->Item6,
                'Item7' => $item->Item7,
                'Item8' => $item->Item8,
                'Item9' => $item->Item9,
                'Item10' => $item->Item10,
                'Item11' => $item->Item11,
                'Item12' => $item->Item12,
                'Item13' => $item->Item13,
                'Item14' => $item->Item14,
                'Item15' => $item->Item15,
                'Item16' => $item->Item16,
                'Item17' => $item->Item17,
                'Item18' => $item->Item18,
                'Item19' => $item->Item19,
                'Item20' => $item->Item20,
                'Item21' => $item->Item21,
                'Item22' => $item->Item22,
                'Item23' => $item->Item23,
                'Item24' => $item->Item24,
                'NetAmountPaid' => $item->NetAmountPaid,
                'Surcharges' => Bills::getSurchargeMobApp($item),
                'NetAmount' => round(floatval($item->NetAmount) + floatval(Bills::getSurchargeMobApp($item)), 2),
            ]);
            
        }

        if ($bills == null) {
            return response()->json(['error' => 'No bills found'], 404);
        } else {
            return response()->json($data, $this-> successStatus); 
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
                    ->leftJoin('BillsExtension', function($join) {
                        $join->on('Bills.AccountNumber', '=', 'BillsExtension.AccountNumber')
                            ->on('Bills.ServicePeriodEnd', '=', 'BillsExtension.ServicePeriodEnd');
                    })
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
                            'Bills.Remarks as SubscriberNo',
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
                            'BillsExtension.Item24',)
                    ->first();

        if ($bill == null) {
            return response()->json(['error' => 'No bill found'], 404);
        } else {
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

            $surcharge = [
                'Surcharges' => Bills::getSurchargeMobApp($bill),
            ];

            // REGISTER LOG
            $log = new UserAppLogs;
            $log->UserId = $request['u'];
            $log->Type = "Queried Bill";
            $log->Details = "Queried bill with bill number " . $bill->BillNumber;
            $log->save();

            return response()->json((object)array_merge((array)$bill, (array)$rates, (array)$ratesExtension,  (array)$surcharge), $this-> successStatus); 
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