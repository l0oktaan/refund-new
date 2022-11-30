<?php

namespace App\Http\Controllers\Auth;

use session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    protected $maxAttempts = 1;
    protected $decayMinutes = 1;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        try {
            sleep(1);
            $credentials = $request->only('username', 'password');
            //$request->session()->regenerate();
            
            if (Auth::attempt($credentials)) {
                // $request->session()->regenerate();
                Log::channel('auth')->info('LOGIN SUCCESS ',[
                    'username' => $request->username,
                    'ip' => $request->header('X-Forwarded-For') ? $request->header('X-Forwarded-For') : $request->ip()
                ]);
                $user = Auth::user();
                $success = $user->createToken(config('app.name'))->accessToken;
                return response([
                    'data' => $user,
                    'success' => $success,
                    'status' => Auth::check()
                ],Response::HTTP_CREATED);
            }else{
                Log::channel('auth')->error('LOGIN FAILED ',[
                    'username' => $request->username,
                    'ip' => $request->header('HTTP_X_FORWARDED_FOR') ? $request->header('HTTP_X_FORWARDED_FOR') : $request->ip()
                ]);
            }
        } catch (\Throwable $th) {
            return $th;
        }
        
        
    }

    protected function guard()
    {
        return Auth::guard('api');
    }

    public function username()
    {
        return 'username';
    }


    public function logout(Request $request){
        
        
        
        try{
            
            Log::channel('auth')->info('LOGOUT ',[
                'username' => Auth::user()->username,
                'ip' => $request->header('X-Forwarded-For') ? $request->header('X-Forwarded-For') : $request->ip()
            ]);
            if (Auth::check()) {
                // $request->session()->regenerate();
                $user = Auth::user()->token();
                $user->revoke();
                return "success";     
            }
        }catch (\Throwable $th) {
            return "error";
        }
        
        
        
    }
}
