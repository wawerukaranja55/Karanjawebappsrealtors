<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use App\Models\Mpesapayment;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class Mpesapayments_controller extends Controller
{
    // generate lipa na mpesa password
    public function lipanampesapassword()
    {
        $timestamp=Carbon::rawParse('now')->format('YmdHms');

        $passkey="bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";

        $businessshortcode=174379;

        $mpesapassword=base64_encode($businessshortcode.$passkey.$timestamp);

        return $mpesapassword;
    }

    //generate access token for the transaction
    public function newaccesstoken()
    {
        $consumer_key="s0srY805Jf2N4TKITnGm3nBfxbZnPhDa";
        $consumer_secret="nKEtYpzmPbFlsL0L";
        $credentials = base64_encode($consumer_key.":".$consumer_secret);
        $url ="https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic ".$credentials,
                                                    "Content-Type:application/json"));
        curl_setopt($curl, CURLOPT_HEADER,false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        $access_token=json_decode($curl_response);
        return $access_token->access_token;
    }

    // push stk on the phone
    public function stkpush(Request $request)
    {
        $data=$request->all();
        
        $rules=[
            'phone'=>'required|regex:/(07)[0-9]/|digits:10'
        ];

        $custommessages=[
            'phone.regex'=>'Your Phone NUmber Should start with 07',
            'phone.digits:10'=>'The Phone NUmber Should not be less or more than 10 digits'
        ];

        $validator = Validator::make( $data,$rules,$custommessages );
        
        if($validator->fails())
        {
            return response()->json([
                'status'=>422,
                'message'=>$validator->errors()
            ]);
        }else{
            $phone=$request->phone;
            $getamount=$request->rent_amount;
            $amount=round($getamount);

            $formattednumber=Substr($phone,1);
            $code="254";
            $phonenumber=$code.$formattednumber;

            $url='https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

            $curl_post_data=[
                'BusinessShortCode'=>174379,
                'Password'=>$this->lipanampesapassword(),
                'Timestamp'=>Carbon::rawParse('now')->format('YmdHms'),

                'TransactionType'=> "CustomerPayBillOnline",
                'Amount'=>$amount,
                'PartyA'=>$phonenumber,
                'PartyB'=>174379,
                'PhoneNumber'=>$phonenumber,
                'CallBackURL'=>'https://c42c-154-159-237-64.ngrok-free.app/api/mpesa/stkpush/callbackurl',
                'AccountReference'=>'W.Karanja Web App Realtors ',
                'TransactionDesc'=>'Paying for Your House Rent'
            ];

            $data_string=json_encode($curl_post_data);

            $curl=curl_init();
            curl_setopt($curl,CURLOPT_URL,$url);
            curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type:application/json','Authorization:Bearer '.$this->newaccesstoken()));
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl,CURLOPT_POST,true);
            curl_setopt($curl,CURLOPT_POSTFIELDS,$data_string);

            $curl_response=curl_exec($curl);
            $res=json_decode($curl_response);

            // save the check out request id in to the mpesa checkout request id table then sync the id in the pivot
            $checkoutrequestid=$res->CheckoutRequestID;

            $checkoutrqstid=new Mpesapayment;
            $checkoutrqstid->callbackurlrequest_id=$checkoutrequestid;
            $checkoutrqstid->amount=$amount;
            $checkoutrqstid->phone=$phonenumber;
            $checkoutrqstid->tenant_name=$request->tenantname;
            $checkoutrqstid->user_id=$request->userid;
            // $checkoutrqstid->mpesatransaction_id=$mpesatransactionid,
            $checkoutrqstid->save();

            return response()->json([
                'status'=>200,
                'curl_response'=>$curl_response
            ]);
        }
    }

    // call back url
    public function mpesaresponse(Request $request)
    {
        $response=json_decode($request->getContent());
        Log::info(json_encode($response));
        dd($response);die();
        $responsedata=$response->Body->stkCallback->CallbackMetadata;
        $callbackurlrequest_id=$response->Body->stkCallback->CheckoutRequestID;
        // $responsecode=$response->Body->stkCallback->ResultCode;
        $responsemessage=$response->Body->stkCallback->ResultDesc;
        $mpesatransactionid=$responsedata->Item[1]->Value;
        Mpesapayment::where('callbackurlrequest_id',$callbackurlrequest_id)->update([
            'mpesatransaction_id'=>$mpesatransactionid
        ]);

        return response()->json($responsemessage);

    }

    // check if the transaction exists
    public function confirm_transaction(Request $request)
    {
        $mpesa_id=$request->input('transactionid');

        $mpesa_id_check=Mpesapayment::where('mpesatransaction_id',$mpesa_id)->count();

        if($mpesa_id_check>0)
        {
            // update the status of the mpesa payment to paid
            Mpesapayment::where('mpesatransaction_id',$mpesa_id)->update(['mpesastatus'=>'1']);

            // you have successfully paid your rent.check your details below in your transaction table
            return response()->json([
                'status'=>200,
                'message'=>'You have successfully paid your rent.Check your details below in your transaction table'
            ]);
        }
        else{
            // error the transaction id is incorrect.please check it again
            return response()->json([
                'status'=>404,
                'message'=>'The transaction id is incorrect.Please check it again.or Contact the admin'
            ]);
        }
    }

    // show mpesa payments for a specific user
    public function get_tenantmpesapayments(Request $request)
    {

        $tenantmpesapayments=Mpesapayment::where(['user_id'=>$request->id,'mpesastatus'=>1])->select('id','phone','mpesatransaction_id','created_at');

        if($request->ajax()){
            $tenantmpesapayments = DataTables::of ($tenantmpesapayments)

            ->addColumn ('created_at',function($row){
                return 
                    '<td>'.$row->created_at->timezone('EAT')->toDayDateTimeString().'</td>';
            })

            ->addColumn ('action',function($row){
                return 
                    '<a href="/viewmpesareceipt/'.$row->id.'" target="_blank" title="View The Payment" class="btn btn-success viewpaymenttag"><i class="fa fa-eye" aria-hidden="true"></i></a>
                     <a href="/downloadmpesareceipt/'.$row->id.'" id="Download Payment" title="Download the Payment" class="btn btn-danger"><i class="fa fa-download"></i></a>';
            })
            ->rawColumns(['created_at','action'])
            ->make(true);

            return $tenantmpesapayments;
        }
    }

    // view the payment made by tenant
    public function viewmpesareceipt($id)
    {
        $mpesadetails=Mpesapayment::where('id',$id)->first();
        $userdetails=User::where('id',$mpesadetails['user_id'])->with(['rentalhses','hserooms'])->first();

        return view('Front.Tenant.mpesareceipt',compact('mpesadetails','userdetails'));
    }

    // generate and download pdf
    public function generatedownloadreceiptpdf(Request $request,$id)
    {
        $mpesadetails=Mpesapayment::where('id',$id)->first();
        $userdetails=User::where('id',$mpesadetails['user_id'])->with(['rentalhses','hserooms'])->first();

        $data = [
            'mpesadetails'=> $mpesadetails,
            'userdetails' => $userdetails,
        ];

        view()->share($data);
        $receiptpdf=app()->make(PDF::class); 
        $receiptpdf->loadView('Front.Tenant.mpesareceipt',$data); 
        return $receiptpdf->download('MpesaReceipt.pdf');
    }
}
