<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Models\Bills;
use App\Models\BillsExtension;
use App\Models\PaidBills;
use App\Models\ThirdPartyTokens;
use Illuminate\Support\Facades\Auth; 
use App\Models\UserAppLogs;
use Validator;
use Illuminate\Support\Facades\DB;

class ThirdPartyAPI extends Controller {
    public $success = 200;
    public $forbidden = 403;
    public $unauthorized = 401;
    public $badRequest = 400;

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
                    $bill = DB::connection('sqlsrv2')
                        ->table('Bills')
                        ->leftJoin('AccountMaster', 'Bills.AccountNumber', '=', 'AccountMaster.AccountNumber')
                        ->where('Bills.ServicePeriodEnd', $period)
                        ->where('Bills.AccountNumber', $accountNo)
                        ->select('AccountMaster.ConsumerName',
                            'AccountMaster.ConsumerAddress',
                            'AccountMaster.AccountStatus',
                            'Bills.*')
                        ->first();
                    
                    $billExtension = BillsExtension::where('ServicePeriodEnd', $period)
                        ->where('AccountNumber', $accountNo)
                        ->first();

                    if ($bill != null && $billExtension != null) {
                        $data = [];

                        $data['ConsumerName'] = $bill->ConsumerName;
                        $data['AccountNumber'] = $bill->AccountNumber;
                        $data['ConsumerAddress'] = $bill->ConsumerAddress;
                        $data['AccountStatus'] = $bill->AccountStatus;
                        $data['ConsumerType'] = $bill->ConsumerType;
                        $data['BillNumber'] = $bill->BillNumber;
                        $data['BillingMonth'] = $bill->ServicePeriodEnd;
                        $data['DueDate'] = $bill->DueDate;
                        $data['KwhUsed'] = $bill->PowerKWH;
                        $data['SubTotal'] = floatval($bill->NetAmount);
                        $data['Surcharge'] = round(Bills::getSurcharge($bill, $billExtension), 2);
                        $data['AmountDue'] = round(floatval($bill->NetAmount) + Bills::getSurcharge($bill, $billExtension), 2);

                        return response()->json($data, $this->success);
                    } else {
                        return response()->json('No bill found', $this->success);
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
}