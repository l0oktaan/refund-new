<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;
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
        
        sleep(1);
        $credentials = $request->only('username', 'password');


        if (Auth::attempt($credentials)) {
            Log::channel('abuse')->info('LOGIN SUCCESS ',[
                'username' => $request->username,
                'ip' => $request->ip()
            ]);
            $user = Auth::user();
            $success = $user->createToken(config('app.name'))->accessToken;
            return response([
                'data' => $user,
                'success' => $success,
                'status' => Auth::check()
            ],Response::HTTP_CREATED);
        }else{
            Log::channel('abuse')->error('LOGIN FAILED ',[
                'username' => $request->username,
                'ip' => $request->ip()
            ]);
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
            
            Log::channel('abuse')->info('LOGOUT ',[
                'username' => Auth::user()->username,
                'ip' => $request->ip()
            ]);
            if (Auth::check()) {
                $user = Auth::user()->token();
                $user->revoke();
                     
            }
        }catch (\Throwable $th) {
            return $th;
        }
        
        
        
    }
}
