<?php

namespace App\Http\Controllers;
use App\Office;
use App\Refund;
use Carbon\Carbon;
use App\RefundFile;
use App\RefundCode;
use App\RefundStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\RefundFileResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RefundFileController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Office $office, Refund $refund)
    {
        $file = $refund->refund_files()->get();
        //return RefundFileResource::collection($file);
        return $file;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Office $office, Refund $refund, Request $request)
    {
        //return $refund;
        $file = Input::file('file');


        $description = Input::input('description');
        $upload_by = Input::input('upload_by');

        //$filename = $file->getClientOriginalName();
        $filename = $office->id . "_" . $refund->id . ".pdf";

        $path = hash( 'sha256', time());

        if(Storage::disk('uploads')->put($path.'/'.$filename,  File::get($file))) {
            $refund_file = new RefundFile;
            $refund_file->file_name = $filename;
            $refund_file->file_path = $path;
            $refund_file->description = $description;
            $refund_file->upload_by = $upload_by;
            $refund_file->status = 1;
            $refund->refund_files()->save($refund_file);
            if ($refund->status < 8 || $refund->status == 11){
                $refund->update([
                    'status' => 8,
                    'sent_date' => date('Y-m-d')
                ]);
                $status = new RefundStatus;
                $status->status_code = 8;
                $status->status_date = date('Y-m-d H:i:s');
                $status->status_by = Auth::user()->username;
                $refund->refund_status()->save($status);
            }
            return response([
                'data' => new RefundFileResource($refund_file)
            ],Response::HTTP_CREATED);
        }
        return response(null,Response::HTTP_NOT_FOUND);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RefundFile  $refundFile
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office, Refund $refund, RefundFile $refundFile)
    {

        $iRefundFile = new RefundFile;

        $iRefundFile = $office->refund_files()
                            ->where([
                                ['refund_id',"=",$refund->id],

                            ])->findOrFail($refundFile->id);
        //return $iRefundFile;
        if ($iRefundFile == null){
            return response(null,Response::HTTP_NOT_FOUND);
        }else{
            $exists = Storage::disk('uploads')->exists($iRefundFile->file_path . '/' . $iRefundFile->file_name);

            if($exists) {
                $path = storage_path('uploads') . "/" . $iRefundFile->file_path . "/" . $iRefundFile->file_name;
                // $path = storage_path() . "/uploads/" . $iRefundFile->file_path . '/' . $iRefundFile->file_name;
                // $path = storage_path('app/public/uploads/') . $iRefundFile->file_path . '/' . $iRefundFile->file_name;
                // $path = '../storage/uploads/'.  $iRefundFile->file_path . "/" . $iRefundFile->file_name;
                $headers = [
                    'Content-Type: application/*'
                ];
                $filename = 'withdraw.pdf'; // $iRefundFile->file_name;


                // return response()->download($path);
                return response()->download($path, $filename, $headers);



                //return Storage::download($path, $iRefundFile->file_name, $headers);

                // return Storage::download($path, $filename, $headers);
            }else{
                return "NO";
            }
        }
    }
    public function user_manual()
    {

        
                $path = storage_path('uploads') . "/e-withdraw_user_manual_v_1.2.pdf";
                
                $headers = [
                    'Content-Type: application/pdf'
                ];
                $filename = 'e-withdraw_user_manual.pdf'; // $iRefundFile->file_name;


                
                return response()->download($path, $filename, $headers);



                
           
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RefundFile  $refundFile
     * @return \Illuminate\Http\Response
     */
    public function edit(RefundFile $refundFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RefundFile  $refundFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RefundFile $refundFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RefundFile  $refundFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(RefundFile $refundFile)
    {
        //
    }
}
