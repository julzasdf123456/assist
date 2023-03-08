<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Models\Bills;
use App\Models\BillsExtension;
use App\Models\IDGenerator;
use App\Models\PaidBills;
use App\Models\AccountMaster;
use App\Models\ThirdPartyTokens;
use App\Models\ThirdPartyTransactions;
use Illuminate\Support\Facades\Auth; 
use App\Models\UserAppLogs;
use Validator;
use Illuminate\Support\Facades\DB;

class ThirdPartyAPI extends Controller {
    public $success = 200;
    public $forbidden = 403;
    public $notFound = 404;
    public $unauthorized = 401;
    public $badRequest = 400;
    public $notAllowed = 405;

    /**
     * 
     */
    public function getBillsByAccountAndPeriod(Request $request) {
        $token = $request['_token'];
        $accountNo = $request['acct_no'];
        $period = $request['period'];

        if ($token != null) {
            $tokenData = ThirdPartyTokens::where('Token', $token)->first();

            // IF TOKEN IS NOT FOUND IN THE SYSTEM
            if ($tokenData != null) {

                // IF REQUEST PARAMETERS ARE NOT COMPLETE
                if ($accountNo != null && $period != null) {
                    // VALIDATE IF ACCOUNT EXISTS
                    $account = AccountMaster::where('AccountNumber', $accountNo)->first();

                    if ($account != null) {
                        $bill = DB::connection('sqlsrv2')
                            ->table('Bills')
                            ->leftJoin('AccountMaster', 'Bills.AccountNumber', '=', 'AccountMaster.AccountNumber')
                            ->leftJoin('BillsExtension', function($join) {
                                $join->on('Bills.AccountNumber', '=', 'BillsExtension.AccountNumber')
                                    ->on('Bills.ServicePeriodEnd', '=', 'BillsExtension.ServicePeriodEnd');
                            })
                            ->where('Bills.AccountNumber', $accountNo)
                            ->whereRaw("Bills.ServicePeriodEnd <= '" . $period . "' AND Bills.AccountNumber NOT IN (SELECT p.AccountNumber FROM PaidBills p WHERE p.AccountNumber=Bills.AccountNumber AND p.ServicePeriodEnd=Bills.ServicePeriodEnd)")
                            ->select('AccountMaster.ConsumerName',
                                'AccountMaster.ConsumerAddress',
                                'AccountMaster.AccountStatus',
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
                            )
                            ->orderBy('Bills.ServicePeriodEnd')
                            ->get(); 
                            
                            
                        $data = [];
                        $data['ConsumerName'] = $account->ConsumerName;
                        $data['AccountNumber'] = $account->AccountNumber;
                        $data['ConsumerAddress'] = $account->ConsumerAddress;
                        $data['AccountStatus'] = $account->AccountStatus;
                        $data['ConsumerType'] = $account->ConsumerType;

                        $billData = [];
                        $totalSurcharge = 0;
                        $totalSubtotal = 0;
                        $totalAmountDue = 0;

                        foreach($bill as $item) {
                            array_push($billData, [
                                'BillNumber' => $item->BillNumber,
                                'BillingMonth' => date('Y-m-d', strtotime($item->ServicePeriodEnd)),
                                'DueDate' => date('Y-m-d', strtotime($item->DueDate)),
                                'KwhUsed' => $item->PowerKWH,
                                'SubTotal' => floatval($item->NetAmount),
                                'Surcharge' => round(Bills::getSurcharge($item), 2),
                                'AmountDue' => round(floatval($item->NetAmount) + Bills::getSurcharge($item), 2),
                            ]);

                            $totalSurcharge += round(Bills::getSurcharge($item), 2);
                            $totalSubtotal += floatval($item->NetAmount);
                            $totalAmountDue += round(floatval($item->NetAmount) + Bills::getSurcharge($item), 2);
                        }

                        $data['OverallSubTotal'] = round($totalSubtotal, 2);
                        $data['OverallSurcharge'] = round($totalSurcharge, 2);
                        $data['OverallAmountDue'] = round($totalAmountDue, 2);
                        $data['UnpaidBills'] = $billData;

                        return response()->json($data, $this->success);
                    } else {
                        return response()->json('Account not found!', $this->notFound);
                    }
                } else {
                    return response()->json('Incomplete parameters!', $this->badRequest);
                }
            } else {
                return response()->json('Token not found!', $this->unauthorized);
            }
        } else {
            return response()->json('No token provided!', $this->badRequest);
        }
    }

    public function transact(Request $request) {
        $token = $request['_token'];
        $accountNo = $request['acct_no'];
        $period = $request['period'];
        $amount = $request['amount'];
        $teller = $request['teller'];
        $company = $request['company'];
        $ornumber = $request['ornumber'];

        if ($token != null) {
            $tokenData = ThirdPartyTokens::where('Token', $token)->first();

            // IF TOKEN IS NOT FOUND IN THE SYSTEM
            if ($tokenData != null) {
                // VALIDATE IF ACCOUNT NUMBER IS SUPPLIED
                if ($accountNo != null) {
                    // VALIDATE IF ACCOUNT EXISTS
                    $account = AccountMaster::where('AccountNumber', $accountNo)->first();

                    if ($account != null) {
                        // VALIDATE IF ALL PARAMETERS ARE SUPPLIED
                        if ($period != null && $amount != null && $teller != null && $company != null) {           
                            /**
                             * ===================================
                             * START TRANSACTION
                             * ===================================
                             */

                            // GET BILL DATA
                            $bill = DB::connection('sqlsrv2')
                                ->table('Bills')
                                ->leftJoin('AccountMaster', 'Bills.AccountNumber', '=', 'AccountMaster.AccountNumber')
                                ->leftJoin('BillsExtension', function($join) {
                                    $join->on('Bills.AccountNumber', '=', 'BillsExtension.AccountNumber')
                                        ->on('Bills.ServicePeriodEnd', '=', 'BillsExtension.ServicePeriodEnd');
                                })
                                ->where('Bills.ServicePeriodEnd', $period)
                                ->where('Bills.AccountNumber', $account->AccountNumber)
                                ->select('AccountMaster.ConsumerName',
                                    'AccountMaster.ConsumerAddress',
                                    'AccountMaster.AccountStatus',
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
                                    'Bills.ServicePeriodEnd',
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
                                    'BillsExtension.Item24',)
                                ->first();

                            if ($bill != null) {
                                // CHECK IF ACCOUNT HAS PAID
                                $checkPaidBills = PaidBills::where('ServicePeriodEnd', $period)
                                    ->where('AccountNumber', $accountNo)
                                    ->first();

                                $checkThirdPartyTransactions = ThirdPartyTransactions::where('ServicePeriodEnd', $period)
                                    ->where('AccountNumber', $accountNo)
                                    ->first();

                                if ($checkPaidBills == null && $checkThirdPartyTransactions == null) {
                                    // VALIDATE AMOUNT
                                    if (is_numeric($amount)) {
                                        $amnt = round(floatval($amount), 2);
                                        $billAmnt = round(floatval($bill->NetAmount) + Bills::getSurcharge($bill), 2);

                                        if ($amnt < $billAmnt) {
                                            return response()->json('Amount to be transacted should always be greater than or equal to bill amount', $this->notAllowed);
                                        } else {
                                            $transaction = new ThirdPartyTransactions;
                                            $transaction->id = IDGenerator::generateIDandRandString();
                                            $transaction->ServicePeriodEnd = $period;
                                            $transaction->AccountNumber = $account->AccountNumber;
                                            $transaction->BillNumber = $bill->BillNumber;
                                            $transaction->KwhUsed = $bill->PowerKWH;
                                            $transaction->Amount = $bill->NetAmount;
                                            $transaction->Surcharge = round(Bills::getSurcharge($bill), 2);
                                            $transaction->TotalAmount = $billAmnt;
                                            $transaction->Company = $company;
                                            $transaction->Teller = $teller;
                                            $transaction->ORNumber = $ornumber;
                                            $transaction->save();

                                            return response()->json($transaction, $this->success);
                                        }
                                    } else {
                                        return response()->json('Amount provided is not numeric!', $this->badRequest);
                                    }      
                                } else {
                                    return response()->json('This bill is already paid!', $this->notAllowed);
                                }                       
                            } else {
                                return response()->json('Bill Not Found!', $this->notFound);
                            }                            
                        } else {
                            return response()->json('Incomplete data supplied!', $this->badRequest);
                        }
                    } else {
                        return response()->json('Account not found!', $this->notFound);
                    }
                } else {
                    return response()->json('Account number not supplied!', $this->badRequest);
                }                
            } else {
                return response()->json('Token not found!', $this->unauthorized);
            }
        } else {
            return response()->json('No token provided!', $this->badRequest);
        }
    }
}