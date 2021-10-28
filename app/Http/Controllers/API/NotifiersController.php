<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Models\User; 
use App\Models\Tokens;
use Illuminate\Support\Facades\Auth; 
use App\Models\UserAppLogs;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Notifiers;

class NotifiersController extends Controller {
    public $successStatus = 200;

    public function getNotifications(Request $request) {
        $notifications = Notifiers::whereBetween('created_at', [date('Y-m-d', strtotime('-30 days')), date('Y-m-d', strtotime('+1 day'))])
                    ->where(function ($query) use ($request) {
                        $query->where('ToUser', $request['u'])
                            ->orWhereNull('ToUser');
                    })
                    ->orderByDesc('created_at')
                    ->get();

        if ($notifications != null) {
            return response()->json($notifications, $this->successStatus);
        } else {
            return response()->json(['error' => 'Notifications not found!'], 404);
        }
    }
} 