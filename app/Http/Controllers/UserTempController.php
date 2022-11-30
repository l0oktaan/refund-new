<?php

namespace App\Http\Controllers;

use App\UserTemp;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserTempResource;

class UserTempController extends Controller
{
    public function index()
    {
        
        $user = Auth::user();
        if ($user->type != 'admin'){
            return response(null,Response::HTTP_NOT_FOUND);
        }
        return UserTempResource::collection(UserTemp::where('status','=',0)->get());
    }
}
