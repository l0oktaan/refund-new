<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PdfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //return $request;

        $pdf = App::make('dompdf.wrapper');
        $pdf->setOptions(['dpi' => 150, 'defaultFont' => 'Trirong']);
        $pdf->loadHTML($request->report);
        // return $pdf->stream();
        $file = $pdf->stream();
        $filename = "refport.pdf";

        //return $refund;
        // $file = Input::file('file');


        // $description = Input::input('description');
        // $upload_by = Input::input('upload_by');

        //$filename = $file->getClientOriginalName();
        // $filename = $office->id . "_" . $refund->id . ".pdf";
        try {
            $path = hash( 'sha256', time());

            Storage::disk('uploads')->put($path.'/'.$filename,  $file);
            $path = storage_path('uploads') . "/" . $path . "/" . $filename;
            //$path = storage_path() . "/uploads/" . $iRefundFile->file_path . '/' . $iRefundFile->file_name;
            $headers = [
                'Content-Type' => 'application/pdf',
            ];

            //return $path;
            return response()->download($path, $filename, $headers);
        } catch (\Throwable $th) {
            return $th;
        }





    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
