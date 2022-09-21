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
                                'Bills.*')
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
                            $paymentChecking = ThirdPartyTransactions::where('AccountNumber', $item->AccountNumber)
                                ->where('ServicePeriodEnd', $item->ServicePeriodEnd)
                                ->first();
                            
                            if ($paymentChecking != null) {
                                
                            } else {
                                array_push($billData, [
                                    'BillNumber' => trim($item->BillNumber),
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
                                ->where('Bills.ServicePeriodEnd', $period)
                                ->where('Bills.AccountNumber', $account->AccountNumber)
                                ->select('AccountMaster.ConsumerName',
                                    'AccountMaster.ConsumerAddress',
                                    'AccountMaster.AccountStatus',
                                    'Bills.*')
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