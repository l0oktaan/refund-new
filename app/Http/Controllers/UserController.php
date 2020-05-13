<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Support\Facades\Cache;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userOnlineStatus()
    {
        $users = User::all();
        foreach($users as $user){
            if (Cache::has('user-is-online-' . $user->id))
                echo "User " . $user->name . " is online.";
            else
                echo "User " . $user->name . " is offline.";
        }
    }
}
