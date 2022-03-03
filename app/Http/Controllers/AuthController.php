<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;
class AuthController extends Controller
{
    use SendsPasswordResetEmails, ResetsPasswords {
        SendsPasswordResetEmails::broker insteadof ResetsPasswords;
        ResetsPasswords::credentials insteadof SendsPasswordResetEmails;
        }
    public function index()
    {
        if (Auth::check()){
            return "OK";
        }else{
            return "NO";
        }
    }
    public function login(Request $request)
    {
        $http = new \GuzzleHttp\Client;
        try {
            $response = $http->post(url('oauth/token'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => '2',//config('services.passport.client_id'),
                    'client_secret' => 'R6PIquMQDbcAxknaqSUgMBkSEf4WIU1lCNUU4jfk',//config('services.passport.client_secret'),
                    'username' => $request->username,
                    'password' => $request->password,
                ]
            ]);
            return $response->getBody();
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            if ($e->getCode() === 400) {
                return response()->json('Invalid Request. Please enter a username or a password.', $e->getCode());
            } else if ($e->getCode() === 401) {
                return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
            }
            return response()->json('Something went wrong on the server.', $e->getCode());
        }
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }
    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response()->json('Logged out successfully', 200);
    }


    public function sendPasswordResetLink(Request $request)
    {
        // try {
            // return $request;
            return $this->sendResetLinkEmail($request);
        // } catch (\Throwable $th) {
            // return $th;
        // }
        
        // return $this->sendsPasswordResetEmail($request);
    }


    protected function sendResetLinkResponse(Request $request, $response)
    {
        return response()->json([
            'message' => 'OK'
            // 'data' => $response
        ]);
    }
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response()->json(['message' => 'FAIL']);
    }


    public function callResetPassword(Request $request)
    {
        return $this->reset($request);
    }


    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->save();
        event(new PasswordReset($user));
    }


}
