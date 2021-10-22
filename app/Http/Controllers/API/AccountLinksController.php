<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Models\AccountLinks; 
use Illuminate\Support\Facades\Auth; 
use Validator;
class AccountLinksController extends Controller 
{
    public $successStatus = 200;

    /**
     * FETCH LINKED ACCOUNTS FOR A GIVEN USER ID
     * @param = userid - ID of user
     */
    public function getLinkedAccounts(Request $request) {
        $account = AccountLinks::where('UserId', $request['userid'])->get();

        if (count($account) == 0) {
            return response()->json(['error' => 'No linked accounts'], 404); 
        } else {
            return response()->json($account, $this->successStatus); 
        }        
    }

    public function linkAccount(Request $request) {
        $validator = Validator::make($request->all(), [ 
            'UserId' => 'required', 
            'AccountNumber' => 'required', 
            'ConsumerName' => 'required', 
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all(); 
        if (AccountLinks::where('AccountNumber', '=', $input['AccountNumber'])->exists()) {
            return response()->json(['message'=> "Account Number Exists"], 409); 
        } else {            
            $accountLink = AccountLinks::create($input); 
            $success['message'] = 'OK';
            $success['account_number'] = $accountLink->AccountNumber;
            $success['user_id'] = $accountLink->UserId;
            $success['id'] = $accountLink->id;

            return response()->json($success, $this->successStatus); 
        }
    }

    /**
     * REMOVE ACCOUNT LINK
     * @Params
     * q = account number
     * u = userid
     */
    public function removeLink(Request $request) {
        if (AccountLinks::where('UserId', $request['u'])->where('AccountNumber', $request['q'])->delete()) {
            return response()->json(['success' => 'Account Link Deleted'], $this->successStatus); 
        } else {
            return response()->json(['error' => 'No linked accounts'], 404); 
        }
    }
}