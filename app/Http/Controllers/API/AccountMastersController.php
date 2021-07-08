<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Models\AccountMaster; 
use Illuminate\Support\Facades\Auth; 
use Validator;
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

}