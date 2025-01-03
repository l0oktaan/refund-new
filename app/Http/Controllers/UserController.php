<?php

namespace App\Http\Controllers;
use App\User;
use App\Office;
use App\UserTemp;
use App\Mail\customMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Notifications\Messages\MailMessage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function via($notifiable)
    {
        return ['mail'];
    }
    public function index()
    {
        // $user = Auth::user();
        // return $user->type;
        $user = Auth::user();
        if ($user->type != 'admin'){
            return response(null,Response::HTTP_NOT_FOUND);
        }
        return UserResource::collection(User::where('status','<>',0)->orderBy('office_id','asc')->get());
        //return Office::all();
    }
    protected function register(Request $request)
    {
        // try {
        //     User::create([
        //         'name' => $request->name,
        //         'username' => $request->username,
        //         'password' => Hash::make($request->password),
        //         'type' => $request->type,
        //         'office_id' => $request->office_id,
        //         'status' => 1
        //     ]);
        // } catch (\Throwable $th) {
        //     return $th;
        // }        
    }
    private function getUsername($office_id){
        $office = Office::where('id',$office_id)->first();
        $num = $office->users->count()+1;
        $uname = "U" . $office->code . "-" . sprintf("%02d", $num);
        return $uname;
        
    }
    private function getPassword(){
        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890');
        return substr($random, 0, 10);
    }
    public function send($user)
    {
        // $objDemo = new \stdClass();
        // $objDemo->demo_one = 'Demo One Value';
        // $objDemo->demo_two = 'Demo Two Value';
        // $objDemo->sender = 'SenderUserName';
        // $objDemo->receiver = 'ReceiverUserName';
        $content = new \stdClass();
        $content->subject = "แจ้งส่งข้อมูลการใช้งานระบบถอนคืนเงินรายได้แผ่นดิน ประเภทค่าปรับ";
        $content->user = $user;
  
        Mail::to($user->email)->send(new customMail($content));
    }
    public function sendEmail($user,$pass)
    {
        try {
            $content = new \stdClass();
            $content->subject = "แจ้งส่งข้อมูลการใช้งานระบบถอนคืนเงินรายได้แผ่นดิน ประเภทค่าปรับ";
            $content->user = $user;
            $content->password = $pass;
    
            Mail::to($user->email)->send(new customMail($content));
    
            // Mail::to("looktaan.tc3@gmail.com")->send(new customMail($content));
            // return response()->json((new MailSendUser())
            //         ->toMail("songwut.saj@cgd.go.th"));
        } catch (\Throwable $th) {
            return "error2";
        }        
    }
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user->type != 'admin'){
                return response(null,Response::HTTP_NOT_FOUND);
            }
            // return response($this->getUsername($request->office_id));
            $user = new User;
            $user->name = $request->name;
            $password = $this->getPassword();        
            $user->password = Hash::make($password);
            $user->email = $request->email;
            $user->type = $request->office_id == 1 ? "admin" : "user";
            
            $user->office_id = $request->office_id;
            $user->sub_office_name = $request->sub_office_name;
            $user->level = $request->office_id == 2 ? "1" : ($request->sub_office_name && $request->sub_office_name != "" ? "3" : "2");
            $user->position = $request->position;
            $user->phone = $request->phone;
            $user->username = $this->getUsername($request->office_id);
            $user->status = 1;
            $user->save();
            Log::channel('auth')->info('Create User Success: ',[
                'name' => $user->name,
                'username' => $user->username,            
                'office_id' => $user->office_id
            ]);
            $this->sendEmail($user,$password);
            Log::channel('auth')->info('Sent Email Success: ',[
                'username' => $user->username,
                'email' => $user->email,
                'office_id' => $user->office_id
            ]);

            if ($request->has('order')){
                DB::table('user_temp')
                    ->where('order', $request->order)
                    ->update(['status' => 1]);
            }
            
            return response([
                'data' => new UserResource($user)            
            ],Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::channel('auth')->error('Create User Fail',[
                'name' => $request->name,
                'office_id' => $request->office_id,
                'username' => $user->username,
                'error' => preg_split('#\r?\n#', $th, 0)[0]
            ]);
            return response(null,Response::HTTP_NOT_FOUND);
        }         
    }
    public function update(Request $request, User $user)
    {
        $iuser = Auth::user();
        if ($iuser->type != 'admin'){
            return response(null,Response::HTTP_NOT_FOUND);
        }
        $user->name = $request->name;
        $user->sub_office_name = $request->sub_office_name;
        $user->level = $request->sub_office_name && $request->sub_office_name != "" ? "3" : "2";

        $user->position = $request->position;
        $user->phone = $request->phone;
        $user->save();
        return response([
            'data' => new UserResource($user)
        ],Response::HTTP_CREATED);

    }
    public function destroy(User $user)
    {
        $iuser = Auth::user();
        if ($iuser->type != 'admin'){
            return response(null,Response::HTTP_NOT_FOUND);
        }
        $user->status = 0;
        $user->save();
        return response([
            'data' => null
        ],Response::HTTP_CREATED);
    }

}
