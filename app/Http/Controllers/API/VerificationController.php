<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 
use Nexmo\Laravel\Facade\Nexmo;
use Illuminate\Support\Facades\DB;
use App\Models\UserAppLogs;
use Validator;

class VerificationController extends Controller {

    public $successStatus = 200;
    
    public function sendSmsTest() {
        Nexmo::message()->send([
            'to'   => '+639075181814',
            'from' => '+639075181814',
            'text' => 'Using the facade to send a message.'
        ]);
    }

    public function getEmailFromUser(Request $request) {
        $userDetails = DB::connection('sqlsrv')
                ->table('users')
                ->leftJoin('AccountLinks', 'users.id', '=', 'AccountLinks.UserId')
                ->where('users.email', $request['email'])
                ->orWhere('users.contactno', $request['email'])
                ->select('users.id',
                        'users.name',
                        'users.email',
                        'users.contactno',
                        'AccountLinks.AccountNumber',
                        'AccountLinks.ConsumerName')
                ->first();

        // REGISTER LOG
        $log = new UserAppLogs;
        $log->UserId = $userDetails->id;
        $log->Type = "Password Reset Attempted";
        $log->Details = "Tried to retrieve email to be used on resetting password.";
        $log->save();
        
        if ($userDetails != null) {
            return response()->json($userDetails, $this->successStatus);
        } else {
            return response()->json(['result' => 'No account found'], 400);
        }
    }
}