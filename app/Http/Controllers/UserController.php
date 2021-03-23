<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Support\Facades\Cache;
use App\User;
use Illuminate\Http\Request;
use App\Mail\customMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function userOnlineStatus()
    {
        // $users = User::all();
        // foreach($users as $user){
        //     if (Cache::has('user-is-online-' . $user->id))
        //         echo "User " . $user->name . " is online.";
        //     else
        //         echo "User " . $user->name . " is offline.";
        // }
        // return Cache::get('');

        // $t= "be8ebd72cc42ec3464e5684f22d489522a6c8374d6c0ca4e0a8bbfe8664847043490ead6b41067b9";
        // $email = Auth::user()->email;
        // return $email;
        // $email = $user->email;
        // $token = $user->token()->id;
        // $ีtemp = $user->token()
        //         ->where('id','=',$t)
        //         ->get();
        // return $temp->id;
        // Mail::to($email)->send(new customMail());
        
        // if( count(Mail::failures()) > 0 ){
        //     session::flash('message','There seems to be a problem. Please try again in a while'); 
        //    return redirect()->back(); 
        // }else{                      
        //     session::flash('message','Thanks for your message. Please check your mail for more details!'); 
        //     return redirect()->back();  
        // }
    }

}
