<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Property;
use App\Models\Company_memo;
use App\Models\Mpesapayment;
use App\Models\Rental_house;
use Illuminate\Http\Request;
use App\Models\Houseratingreview;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class Admindashboard_controller extends Controller
{
    // show all details in the  admin dashboard for the admins
    public function index()
    {  
        $rentalhouses =Rental_house::all()->count();
        $rentalproperties =Property::all()->count();
        $tenants =User::where('is_approved',1)->count();
        $reviews =Houseratingreview::all()->count();
        $mpesapayments =Mpesapayment::all()->count();
        $showrentlhses=Rental_house::with(['housecategory','houselocation'])->latest()->take(4)->get();
        $showproperties=Property::with(['propertycategory','propertylocation'])->latest()->take(4)->get();
        Session::put('page','dashboard');
        return view('Admin.admindashboard',compact('showproperties','showrentlhses','tenants','reviews','mpesapayments','rentalhouses','rentalproperties','tenants'));
    }

    // show all mpesa payments made by users

    public function mpesapayments()
    {  
        $mpesapayments=Mpesapayment::select('id','phone','mpesatransaction_id','created_at','tenant_name','amount')->get();
        Session::put('page','mpesa_payments');
        return view('Admin.tenantspayments',compact('mpesapayments'));
    }

    public function get_mpesapayments(Request $request)
    {
        $mpesapayments=Mpesapayment::select('id','phone','created_at','tenant_name','amount','mpesastatus','mpesatransaction_id');
        Session::put('page','mpesa_payments');

        if($request->ajax()){
            $mpesapayments = DataTables::of ($mpesapayments)

            ->addColumn ('created_at',function($row){
                return 
                    '<td>'.$row->created_at->timezone('EAT')->toDayDateTimeString().'</td>';
            })

            // ->addColumn ('mpesastatus',function($row){
            //     return 
            //     '<input class="mpesapaymentstatus" type="checkbox" checked data-toggle="toggle" data-id="'.$row->id.'" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
            // })

            ->rawColumns(['created_at'])
            ->make(true);

            return $mpesapayments;
        }

        return view('Admin.tenantspayments',compact('mpesapayments'));
    }

    // update payment status
    public function updatepaymentstatus(Request $request)
    {
        $paymentstatus=Mpesapayment::find($request->mpesapayment_id);
        $paymentstatus->mpesastatus=$request->status;
        $paymentstatus->save();

        $message="Status has Been Updated Successfully.";
            return response()->json([

                'success'=>200,
                'message'=>$message
            ]);
    }

    // show all mpesa payments made by users

    public function allmemospage()
    {  
        Session::put('page','allmemos');
        return view('Admin.companymemos');
    }

    // show all memos sent to tenants and admins
    public function getallmemos(Request $request)
    {
        $companymemos=Company_memo::select('id','memo_title','created_at');
        Session::put('page','allmemos');

        if($request->ajax()){
            $companymemos = DataTables::of ($companymemos)
            ->addColumn ('created_at',function($row){
                return 
                    '<td>'.$row->created_at->timezone('EAT')->toDayDateTimeString().'</td>';
            })

            ->addColumn ('viewmemo',function($row){
                return 
                    '<a href="/admin/show_memo/'.$row->id.'" target="_blank" title="View The Memo" class="btn btn-success viewmemo"><i class="fa fa-eye" aria-hidden="true"></i></a>';
            })
            ->rawColumns(['created_at','viewmemo'])
            ->make(true);

            return $companymemos;
        }

        return view('Admin.companymemos',compact('companymemos'));
    }
    
    // view the memo sent to the admin/tenant
    public function showmemo($id)
    {
        $memodetails=Company_memo::where('id',$id)->first();

        return view('Admin.memodetails',compact('memodetails'));
    }

    // send memo to the tenants/admins
    public function sendmemotouser(Request $request)
    {
        $data=$request->all();

        $rules=[
            'memo_title'=>'required',
            'memo_message'=>'required',
        ];

        $custommessages=[
            'memo_title.required'=>'Enter The Title of the Memo',
            'memo_message.required'=>'Write the message of the memo',
        ];

        $validator = Validator::make( $data,$rules,$custommessages );
        
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'message'=>$validator->errors() 
            ]);
        }else{

            if(isset($data['tenantsadmins'])){
                $recipientemails=implode(',',$data['tenantsadmins']);
                
            }
            $memodata=new Company_memo();
            $memodata->memo_title=$data['memo_title'];
            $memodata->memo_message=$data['memo_message'];
            $memodata->recipient_emails=$recipientemails;
            $memodata->save();

            $email=$data['tenantsadmins'];



            $memotitle=$data['memo_title'];
            $memomsg=$data['memo_message'];
            $messagedata=['memotitle'=>$memotitle,'memomsg'=>$memomsg];

            Mail::send('emails.memotemplate', $messagedata, function ($message) use($email) {
                $message->to('theceodave@gmail.com')->cc($email)->subject('Memo From W.karanja Apps');
            });

            return response()->json([
                'status'=>200,
                'message'=>'Memo Successfully sent'
            ]);
        }
    }

    // get users for a house and display them
    public function getuserforahouse(Request $request)
    {
        $housesusers=User::where(['house_id'=>$request->id,'is_approved'=>1])->select('email','id')->get();

        return response()->json($housesusers);

    }
}
