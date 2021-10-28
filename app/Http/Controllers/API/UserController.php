<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Models\User; 
use App\Models\Tokens;
use Illuminate\Support\Facades\Auth; 
use App\Models\UserAppLogs;
use Validator;
class UserController extends Controller 
{
    public $successStatus = 200;
    /** 
         * login api 
         * 
         * @return \Illuminate\Http\Response 
         */ 
    public function login(){ 
        if(Auth::attempt(['username' => request('username'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('assist')-> accessToken; 
            $success['username'] = request('username');
            $success['id'] = $user->id;

            // SET ACTIVITY
            $userM = User::find($user->id);
            $userM->activity = 'active';
            // $userM->remember_token = $success['token'];
            $userM->save();

            // REGISTER LOG
            $log = new UserAppLogs;
            $log->UserId = $user->id;
            $log->Type = "Logged in";
            $log->save();

            return response()->json($success, $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    /**
     * LOGOUT API
     */
    public function logout(Request $request) {
        $user = User::find($request['id']);

        $user->activity = 'inactive';
        $user->save();

        // REGISTER LOG
        $log = new UserAppLogs;
        $log->UserId = $user->id;
        $log->Type = "Logged out";
        $log->save();

        return response()->json(['ok', $this->success]);
    }

    public function insertToken(Request $request) {
        $checkToken = Tokens::where('userid', $request['userid'])->first();
        
        if ($checkToken != null) {
            // UPDATE TOKEN
            $checkToken->update($request->all());
            return response()->json(['message' => 'token updated'], $this->successStatus);
        } else {
            // INSERT TOKEN
            $input = $request->all();
            $token = Tokens::create($input);
            return response()->json(['message' => 'token created'], $this->successStatus);
        }
    }

    /** 
         * Register api 
         * 
         * @return \Illuminate\Http\Response 
         */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'username' => 'required', 
            'email' => 'required|email',
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all(); 
        if (User::where('email', '=', $input['email'])->exists()) {
            return response()->json(['message'=> "Email Exists"], 409); 
        } elseif(User::where('username', '=', $input['username'])->exists()) {
            return response()->json(['message'=> "Username Exists"], 406); 
        } else {            
            $input['password'] = bcrypt($input['password']); 
            $user = User::create($input); 
            $success['token'] =  $user->createToken('assist')-> accessToken; 
            $success['name'] =  $user->name;
            $success['username'] =  $user->username;
            $success['email'] =  $user->email;
            $success['message'] = 'OK';
            $success['id'] = $user->id;

            return response()->json($success, $this->successStatus); 
        }
        
    }

    public function resetPassword(Request $request) {
        $user = User::find($request['id']);

        $user->password = bcrypt($request['password']); 

        if ($user->save()) {
            // REGISTER LOG
            $log = new UserAppLogs;
            $log->UserId = $user->id;
            $log->Type = "Resetted Password";
            $log->save();

            return response()->json(['response' => 'ok'], $this->successStatus);
        } else {
            return response()->json(['response' => 'error'], 400);
        }
    }

    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json($user, $this-> successStatus); 
    } 
}