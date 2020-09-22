<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
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
        sleep(3);
        $credentials = $request->only('username', 'password');


        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $success = $user->createToken(config('app.name'))->accessToken;
            return response([
                'data' => $user,
                'success' => $success
            ],Response::HTTP_CREATED);
        }else{
            // return "NO";
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

        // $value = $request->bearerToken();
        // return $request->user()->token();
        //return $value;
        // if (Auth::check()) {
            // $user = Auth::user()->token();
            // $user->revoke();
        //     return 'logout';
        // }
        // $this->guard()->logout();
        // Auth::guard('api')->logout();
    }
}
