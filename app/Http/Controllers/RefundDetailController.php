<?php

namespace App\Http\Controllers;

use App\Form;
use App\Office;
use App\Refund;
use App\Consider;
use Carbon\Carbon;

use App\RefundForm;
use App\RefundDetail;
use App\Http\Resources\FormResource;
use App\Http\Requests\RefundDetailRequest;
use App\Http\Resources\RefundFormResource;
use App\Http\Resources\RefundDetailResource;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RefundDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Office $office, Refund $refund, RefundForm $refund_form)
    {
        //return new RefundFormResource($refund_form);
        $detail = new RefundDetail();
        $detail = $refund_form->refund_details()->get();
        return RefundDetailResource::collection($detail);
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
    private function checkResult(Object $arrDetail)
    {

        for ($i=0; $i < count($arrDetail); $i++)
        {
            $detail = $arrDetail[$i];
            // if (intval($detail->selected) == 0){
            //     $this->UpdateDetail(intval($detail->id),0);
            // }
            $consider = Consider::find($detail->consider_id);

            switch (intval($consider->type))
            {
                case 1 :
                    if (intval($detail->value) == 1){
                        $this->UpdateDetail(intval($detail->id),1);
                    }else{
                        $this->UpdateDetail(intval($detail->id),0);
                    }
                break;
                case 2 :
                    if ((strval($detail->value) == '') || (strval($detail->value == '-'))){
                        $this->UpdateDetail(intval($detail->id),0);
                    }else{
                        $this->UpdateDetail(intval($detail->id),1);
                    }
                break;
                case 3 :  //ตรวจสอบข้อมูล
                    switch (intval($consider->oper))
                    {
                        case 1:
                            if ((intval($detail->value) <= intval($consider->var1)) && (intval($detail->value) > 0)){
                                $this->UpdateDetail(intval($detail->id),1);
                            }else{
                                $this->UpdateDetail(intval($detail->id),0);
                            }
                        break;
                        case 2: //ไม่เกินวันที่
                            //$date_var1 = Carbon::now();
                            try {
                                $var1 = explode("-",$consider->var1);

                                //$date_var1->setDate($var1[0],$var1[1],$var1[2]);
                                $date_var1 = Carbon::create($var1[0],$var1[1],$var1[2]);

                                //$date_detail = Carbon::now();
                                $value = explode("-",$detail->value);
                                $date_detail = Carbon::create($value[0],$value[1],$value[2]);
                                //$date_detail->setDate($value[0],$value[1],$value[2]);
                                if ($date_detail->lessThanOrEqualTo($date_var1)){
                                    $this->UpdateDetail(intval($detail->id),1);
                                }else{
                                    $this->UpdateDetail(intval($detail->id),0);
                                }
                            } catch (\Throwable $th) {
                                $this->UpdateDetail(intval($detail->id),0);
                            }



                        break;
                        case 3:
                            try {
                                $var1 = explode("-",$consider->var1);
                                array_walk( $var1, 'intval' );
                                $date_var1 = Carbon::create($var1[0],$var1[1],$var1[2]);

                                $var2 = explode("-",$consider->var2);
                                array_walk( $var2, 'intval' );
                                $date_var2 = Carbon::create($var2[0],$var2[1],$var2[2]);

                                $value = explode("-",$detail->value);
                                array_walk( $value, 'intval' );
                                $date_detail = Carbon::create($value[0],$value[1],$value[2]);

                                if ($date_detail->gte($date_var1) and $date_detail->lte($date_var2)){
                                    $this->UpdateDetail(intval($detail->id),1);
                                }else{
                                    $this->UpdateDetail(intval($detail->id),0);
                                }
                            } catch (\Throwable $th) {
                                $this->UpdateDetail(intval($detail->id),0);
                            }
                        break;
                        case 4: //หลังจากวันที่
                            //$date_var1 = Carbon::now();
                            try {
                                $var1 = explode("-",$consider->var1);

                                //$date_var1->setDate($var1[0],$var1[1],$var1[2]);
                                $date_var1 = Carbon::create($var1[0],$var1[1],$var1[2]);

                                //$date_detail = Carbon::now();
                                $value = explode("-",$detail->value);
                                $date_detail = Carbon::create($value[0],$value[1],$value[2]);
                                //$date_detail->setDate($value[0],$value[1],$value[2]);
                                if ($date_detail->greaterThan($date_var1)){
                                    $this->UpdateDetail(intval($detail->id),1);
                                }else{
                                    $this->UpdateDetail(intval($detail->id),0);
                                }
                            } catch (\Throwable $th) {
                                $this->UpdateDetail(intval($detail->id),0);
                            }
                        break;
                        case 5:
                            try {
                                if (strpos($consider->var1,$detail->value) !== false){
                                //if ($consider->var1 == $detail->value){
                                    $this->UpdateDetail(intval($detail->id),1);
                                }else{
                                    $this->UpdateDetail(intval($detail->id),0);
                                }
                            } catch (\Throwable $th) {
                                $this->UpdateDetail(intval($detail->id),0);
                            }
                        break;
                        case 6:
                            try {
                                $var = intval($consider->var1);
                                $value = explode("|",$detail->value);
                                $day1 = explode("-",$value[0]);
                                $day2 = explode("-",$value[1]);
                                $dateBegin = Carbon::create($day1[0],$day1[1],$day1[2]);
                                $dateEnd = Carbon::create($day2[0],$day2[1],$day2[2]);
                                $gap = $dateEnd->diffInDays($dateBegin);
                                
                                if ($gap > $var){
                                    $this->UpdateDetail(intval($detail->id),0);
                                }else{
                                    $this->UpdateDetail(intval($detail->id),1);
                                }


                            } catch (\Throwable $th) {
                                $this->UpdateDetail(intval($detail->id),0);
                            }
                        break;
                        default :
                            $this->UpdateDetail(intval($detail->id),0);
                    }
                break;
                case 4:  //ใส่วันที่
                    try {
                        $value = explode("-",$detail->value);
                        $date_detail = Carbon::create($value[0],$value[1],$value[2]);
                        $this->UpdateDetail(intval($detail->id),1);
                    } catch (\Throwable $th) {
                        $this->UpdateDetail(intval($detail->id),0);
                    }
                break;
                case 5:  //ใส่ตัวเลข
                    try {
                        if ((strval($detail->value) == '') || (intval($detail->value == 0))){
                            $this->UpdateDetail(intval($detail->id),0);
                        }else{
                            $this->UpdateDetail(intval($detail->id),1);
                        }
                    } catch (\Throwable $th) {
                        $this->UpdateDetail(intval($detail->id),0);
                    }
                break;
                default:
                    $this->UpdateDetail(intval($detail->id),0);
            }
        }
    }
    private function isNotBeforeDate(Object $date_detail,Object $date_var1)
    {

    }
    private function UpdateDetail(Int $detail_id,Int $status)
    {
        $detail = RefundDetail::find($detail_id);
        $detail->status = $status;
        $detail->save();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request, Office $office, Refund $refund, RefundForm $refund_form)
     {
        // return response([
        //     'data' => $request->state
        // ],Response::HTTP_CREATED);
        //if ($request->has('data')){
            // $data = $request->data();
            // return response([
            //     'data' => $data
            // ],Response::HTTP_CREATED);
        //}else{
            // return response(null,Response::HTTP_NO_CONTENT);
       // }

        // $detail = new RefundDetail($request->all());
        // $refund_form->refund_details()->save($detail);
        // return response([
        //     'data' => $detail
        // ],Response::HTTP_CREATED);
            if ($request->has('detail')){
                //$data = json_encode($request->data);
                $data = $request->detail;
                for ($i = 0; $i < count($data); $i++){
                    if ($request->state == "new"){
                        $detail = new RefundDetail;
                        $detail->consider_id = $data[$i]['consider_id'];
                        $detail->result_type = $data[$i]['result_type'];
                        $detail->selected = $data[$i]['selected'];
                        $detail->value = $data[$i]['value'];
                        $detail->status = $data[$i]['status'];
                        $refund_form->refund_details()->save($detail);
                    }else if ($request->state == "update" || $request->state == "update-2"){
                        $detail = RefundDetail::find($data[$i]['id']);
                        $detail->selected = $data[$i]['selected'];
                        $detail->value = $data[$i]['value'];
                        $detail->save();

                        $arrDetail = RefundDetail::orderBy('id')
                                    ->where('refund_form_id','=',$refund_form->id)
                                    ->where('id','=',$data[$i]['id'])
                                    ->get();
                        //return $arrDetail;
                        $this->checkResult($arrDetail);
                    }
                    $detail = null;
                }

                // $arrDetail = RefundDetail::orderBy('id')
                //             ->where('refund_form_id','=',$refund_form->id)
                //             ->get();
                // //return $arrDetail;
                // $this->checkResult($arrDetail);

                if ($request->state == "update-2"){
                    return $detail = RefundDetail::find($data[0]['id']);
                    // return response([
                    //     'data' => new RefundDetailResource($detail)
                    // ],Response::HTTP_CREATED);
                }

                return response([
                    'data' => new RefundFormResource($refund_form)
                ],Response::HTTP_CREATED);
            }

        // if ($request->has('data'))
        // {
        //     $details = $request->data;
        //     foreach($details as $item)
        //     {
        //         if (!empty($item))
        //         {

        //             $detail = new RefundDetail($item);
        //             $refund_form->refund_details()->save($detail);
        //         }
        //     }
        //     return $details;
        // }

        /* $iform = new FormResource(Form::find($refund_form->form_id));
        $forms = array($iform);
        return $forms[0]['rules'];
        return array($forms->rules);
        foreach($forms as $form)
        {
            $rules = array($form->rules);
            return $rules;
            foreach($rule->considers as $consider)
            {
                $refundDetail = new RefundDetail();
                $refundDetail->rule_id = $rule->id;
                $refundDetail->consider_id = $consider->id;
                $refundDetail->value = '';
                $refundDetail->status = 0;
                $refund_form->refund_details()->save($refundDetail);
            }

        }
        return $forms; */




    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RefundDetail  $refundDetail
     * @return \Illuminate\Http\Response
     */
    public function show(RefundDetail $refundDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RefundDetail  $refundDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(RefundDetail $refundDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RefundDetail  $refundDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Office $office, Refund $refund, RefundForm $refund_form)
    {
        if ($request->has('detail')){


            //$data = json_encode($request->data);
            $data = $request->detail;


            for ($i = 0; $i < count($data); $i++){

                if ($request->state == "new"){
                    $detail = new RefundDetail;
                    $detail->consider_id = $data[$i]['consider_id'];
                    $detail->result_type = $data[$i]['result_type'];
                    $detail->selected = $data[$i]['selected'];
                    $detail->value = $data[$i]['value'];
                    $detail->status = $data[$i]['status'];
                    $refund_form->refund_details()->save($detail);
                    //$this->CheckConsider($refund_form, $detail);
                }else if ($request->state == "update"){

                    $detail = RefundDetail::find($data[$i]['id']);
                    $detail->selected = $data[$i]['selected'];
                    $detail->value = $data[$i]['value'];
                    $detail->save();
                    //$this->CheckConsider($refund_form, $detail);

                }

                $detail = null;
            }
            $arrDetail = RefundDetail::orderBy('id')
                        ->where('refund_form_id','=',$refund_form->id)
                        ->get();
            $this->checkResult($arrDetail);

            return response([
                'data' => new RefundFormResource($refund_form)
            ],Response::HTTP_CREATED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RefundDetail  $refundDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(RefundDetail $refundDetail)
    {
        //
    }
}
