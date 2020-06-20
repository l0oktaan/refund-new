<?php

namespace App\Http\Controllers\Auth;
use App\Office;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

            // User::create([
            //     'username' => $data['code'],
            //     'password' => Hash::make($data['code']),
            //     'type' => 'user',
            //     'office_id' => $data['office_id'],
            //     'status' => 1
            // ]);

        for ($i = 0; $i < count($data); $i++){
            User::create([
                'name' => $data[$i]['name'],
                'username' => $data[$i]['code'],
                'password' => Hash::make($data[$i]['code']),
                'type' => 'user',
                'office_id' => $data[$i]['id'],
                'status' => 1
            ]);
        }
        // return User::create([
        //     'username' => $data['code'],
        //     'password' => Hash::make($data['code']),
        //     'type' => 'user',
        //     'office_id' => $data['office_id'],
        //     'status' => 1
        // ]);
    }
    protected function createUsers(){
        // return 'create users';
        $office = new Office;
        $users = $office->all()->toArray();

        try {
            $this->create($users);
            return 'OK';
        } catch (\Throwable $th) {
            return 'error';
        }


    }
    protected function guard()
    {
        return Auth::guard('guard-name');
    }
}
