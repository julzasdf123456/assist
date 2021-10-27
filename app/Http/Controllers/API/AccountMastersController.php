<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Models\AccountMaster; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use App\Models\User;

class AccountMastersController extends Controller 
{
    public $successStatus = 200;

    public function getAccountByAccountNumber(Request $request) {
        $account = AccountMaster::find($request['acctNo']);

        if ($account == null) {
            return response()->json(['error' => 'Account not found!'], 404); 
        } else {
            return response()->json($account, $this->successStatus); 
        }        
    }

    public function updateContactInfo(Request $request) {
        $account = AccountMaster::find($request['AccountNumber']);

        if ($account != null) {
            $account->timestamps = false;
            $account->ContactNumber = $request['ContactNumber'];
            $account->Email = $request['EmailAddress'];
            $account->save();

            $user = User::find($request['UserId']);
            $user->email = $request['EmailAddress']==null ? ' ' : $request['EmailAddress'];            
            $user->save();

            return response()->json(['response' => 'success'], $this->successStatus); 
        } else {
            return response()->json(['error' => 'Internal server error!'], 500); 
        }
    }

}