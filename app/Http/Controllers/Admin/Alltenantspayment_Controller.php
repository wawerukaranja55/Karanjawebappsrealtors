<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Models\AllTenantspayment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use AfricasTalking\SDK\AfricasTalking;
use App\Models\Payment_Transactiontype;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class Alltenantspayment_Controller extends Controller
{
    public function allpayments()
    {  
        $tenants=User::where(['is_admin'=>0,'is_tenant'=>1])->select('id','name')->get();

        $transactiontypes=Payment_Transactiontype::where('status',1)->get();

        // $tenantspayments=AllTenantspayment::with(['userpaymentdetails','usersrooms'])->select('id','user_id','rental_name','total_rent','amount_paid','total_arrears','date_paid')->get();
        // dd($tenantspayments);die();

        Session::put('page','all_payments');
        return view('Admin.alltenantspayments',compact('tenants','transactiontypes'));
    }

    public function gettenantdetails(Request $request)
    {
        $tenantuserdetails=User::with('hserooms','rentalhses')->where(['id'=>$request->id])->get();

        return response()->json($tenantuserdetails);

    }

    // show all payments made by tenants
    public function get_allpayments(Request $request)
    {
        $tenantspayments=AllTenantspayment::with(['userpaymentdetails'])->select('id','user_id','receipt_number','transactiontype_id','rental_name','total_rent','amount_paid','total_arrears','overpaid_amount','date_paid');

        if($request->ajax()){
            
            $tenantspayments = DataTables::of ($tenantspayments)

            ->addColumn ('user_id',function(AllTenantspayment $alltenantspayment){
                return $alltenantspayment->userpaymentdetails->name;
            })

            ->addColumn ('transactiontype_id',function(AllTenantspayment $alltenantspayment){
                return $alltenantspayment->paymenttransactiontype->name;
            })

            ->addColumn ('action',function($row){
                return 
                '<a href="/admin/viewpaymentreceipt/'.$row->id.'/'.$row->date_paid.'" target="_blank" alt="View the Payment Receipt" class="btn btn-success viewpaymentreciept" data-id="'.$row->id.'"><i class="fa fa-eye"></i></a>
                <a href="/downloadpaymentreceipt/'.$row->id.'/'.$row->date_paid.'" id="downloadpaymentreceipt" alt="Download the Payment Receipt" class="btn btn-danger" data-id="'.$row->id.'"><i class="fa fa-download"></i></a>';
            })
            ->rawColumns(['user_id','action','transactiontype_id'])
            ->make(true);

            return $tenantspayments;
        }

    }

    // view the receipt generated for the user
    public function showpaymentreciept($id,$date_paid)
    {
        $month = Carbon::parse($date_paid)->format('m');

        $paymentdetails=AllTenantspayment::where('id',$id)->first();
        $paymenttypes=Payment_Transactiontype::where('status',1)->get();
        
        $tenantpaymentsforthemonth=DB::table('all_tenantspayments')
                ->where('user_id',$paymentdetails['user_id'])
                ->whereMonth('date_paid', $month)
                ->select('amount_paid','overpaid_amount','total_arrears','id','date_paid')
                ->get();

        $current_arrear=AllTenantspayment::where('user_id',$paymentdetails['user_id'])
            ->orderBy('created_at', 'desc')
            ->whereMonth('date_paid', $month)
            ->pluck('total_arrears')
            ->first();
        
        $userdetails=User::where('id', $paymentdetails['user_id'])->with(['rentalhses','hserooms'])->first();

        return view('Admin.paymentreceipt',compact('paymenttypes','paymentdetails','current_arrear','userdetails','tenantpaymentsforthemonth'));
    }

    // generate and download pdf
    public function downloadpaymentreceipt(Request $request,$id,$date_paid)
    {
        $month = Carbon::parse($date_paid)->format('m');

        $paymentdetails=AllTenantspayment::where('id',$id)->first();

        $paymenttypes=Payment_Transactiontype::where('status',1)->get();
        
        $tenantpaymentsforthemonth=DB::table('all_tenantspayments')
                ->where('user_id',$paymentdetails['user_id'])
                ->whereMonth('date_paid', $month)
                ->select('amount_paid','overpaid_amount','total_arrears','id','date_paid')
                ->get();

        $current_arrear=AllTenantspayment::where('user_id',$paymentdetails['user_id'])
            ->orderBy('created_at', 'desc')
            ->whereMonth('date_paid', $month)
            ->pluck('total_arrears')
            ->first();
        
        $userdetails=User::where('id', $paymentdetails['user_id'])->with(['rentalhses','hserooms'])->first();

        $data = [
            'paymentdetails'=> $paymentdetails,
            'paymenttypes' => $paymenttypes,
            'tenantpaymentsforthemonth'=> $tenantpaymentsforthemonth,
            'current_arrear' => $current_arrear,
            'userdetails' => $userdetails,
        ];

        view()->share($data);
        $tenantreceiptpdf=app()->make(PDF::class); 
        $tenantreceiptpdf->loadView('Admin.paymentreceipt',$data); 
        return $tenantreceiptpdf->download('Tenantreceipt.pdf');
    }

    // store a payment in the db 
    public function addtenantpayment(Request $request)
    {
        $data=$request->all();

        $rules=[
            'user_id'=>'required',
            'amount_paid'=>'required|numeric|min:1',
            'date_paid'=>'required|date_format:Y-m-d',
        ];

        $custommessages=[
            'user_id.required'=>'Kindly Select the name of the Tenant',
            'amount_paid.required'=>'Enter the Amount the Tenant Has Paid',
            'amount_paid.numeric'=>'The Amount should be numbers',
            'amount_paid.min:1'=>'The Amount should greater than 1',
            'date_paid.required'=>'Kindly Select the Date the Tenant made the Tenant',
            'date_paid.date_format:Y-m-d'=>'The date format is incorrect.it should be date/month/year',
        ];

        $datepaid=$data['date_paid'];
        $month = Carbon::parse($datepaid)->format('m');

        $validator = Validator::make( $data,$rules,$custommessages );
        
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'message'=>$validator->errors()
            ]);
        }else{

            $totalamountpaidforthatmonth=DB::table('all_tenantspayments')
                ->where('user_id',$data['user_id'])
                ->whereMonth('date_paid', $month)
                // ->select('amount_paid')
                ->sum('amount_paid');

            // get the current arrears 
            $current_arrear=AllTenantspayment::where('user_id',$data['user_id'])->orderBy('created_at', 'desc')->pluck('total_arrears')->first();

            if ($current_arrear == null && $data['amount_paid']>=$data['total_rent'] && $totalamountpaidforthatmonth == 0)
            {
                $total_arrear=0;
                $unpaidxtrabalance=$data['amount_paid']-$data['total_rent'];
                // 
            }
            elseif ($current_arrear == null && $data['amount_paid']<$data['total_rent'] && $totalamountpaidforthatmonth == 0)
            {
                $total_arrear=$data['total_rent']-$data['amount_paid'];
                $unpaidxtrabalance=0;
                // $unpaidxtrabalance=$totalamountpaidforthatmonth-$data['total_rent'];

            }
            elseif ($totalamountpaidforthatmonth >= $data['total_rent'] && $current_arrear == 0)
            {
                $total_arrear=0;
                $unpaidxtrabalance=$data['amount_paid'];
                // 
            }
            elseif ($totalamountpaidforthatmonth < $data['total_rent'] && $current_arrear < $data['amount_paid'])
            {
                $total_arrear=0;
                $unpaidxtrabalance=$data['amount_paid']-$current_arrear;
                // 
            }
            elseif ($totalamountpaidforthatmonth < $data['total_rent'] && $current_arrear < $data['total_rent'])
            {
                $total_arrear=$current_arrear-$data['amount_paid'];
                $unpaidxtrabalance=0;
                // 
            }
            
            $payment=new AllTenantspayment();

            // Get the last order id
            $lastorderId = AllTenantspayment::orderBy('id', 'desc')->first()->id ?? 1;

            // Get last 3 digits of last order id
            $lastIncreament = substr($lastorderId, -3);

            // Make a new order id with appending last increment + 1
            $newreceiptId = 'wkrealtors' . $data['user_id'] . str_pad($lastIncreament + 1, 3, 0, STR_PAD_LEFT);

            // $newreceiptid=$receiptid+1;
            $payment->user_id=$data['user_id'];
            $payment->transactiontype_id=$data['transactiontype'];
            $payment->rental_name=$data['rental_name'];
            $payment->total_rent=$data['total_rent'];
            $payment->receipt_number=$newreceiptId;
            $payment->amount_paid=$data['amount_paid'];
            $payment->total_arrears=$total_arrear;
            $payment->overpaid_amount=$unpaidxtrabalance;
            $payment->date_paid=$data['date_paid'];
            $payment->save();

            $tenantpaymentsonthemonth=DB::table('all_tenantspayments')
                ->where('user_id',$data['user_id'])
                ->whereMonth('date_paid', $month)
                ->sum('amount_paid');

            $tenantphonenumber=User::where('id',$data['user_id'])->pluck('phone')->first();

            $formattednumber=Substr($tenantphonenumber,1);
            $code="254";
            $phone=$code.$formattednumber;

            // Send Sms to the tenant that tey havepaid ther rent
            $username = 'wkaranjawebapps';
            $apiKey   = 'fc4abd547d1bb533dd92a8ff180cc8098fa95fedaf6ce7f5ebe25cc00263706c';

            // Initialize the SDK
            $AT         = new AfricasTalking($username, $apiKey);

            // Get the SMS service
            $sms        = $AT->sms();

            // Set the numbers you want to send to in international format
            $recipients = $phone;

            $downloadurl="'downloadpaymentreceipt/$payment->id/$payment->date_paid'";
            // Set your message
            $message    = "hello there your rent has been received.Click `<a href=$downloadurl>Here</a>` to downoad your receipt.You have an arrear of  $current_arrear and your Over payment is $tenantpaymentsonthemonth ";

            // Set your shortCode or senderId
            $from       = "AFRICASTKNG";

            try {
                // Thats it, hit send and we'll take care of the rest
                $result=$sms->send([
                    'to'      => $recipients,
                    'message' => $message,
                    'from'    => $from
                ]);

                // $sms->send([
                //     'to'      => $recipients,
                //     'message' => $message,
                //     'from'    => $from
                // ]);
            } catch (Exception $e) {
                echo "Error: ".$e->getMessage();
                dd($e->getMessage());
            }

            $message="Payment Has Been Saved In the DB Successfully.";
            return response()->json([
                'status'=>200,
                'message'=>$message
            ]);
            // return redirect()->route('inactiverentalhses')->with('success','The Rental House has been added successfuly.');
        }
    }

    // show all rental categories for a rental house
    public function get_transactiontypes(Request $request)
    {
        $transactiontypes=Payment_Transactiontype::select('id','name','status','number');

        if($request->ajax()){
            $transactiontypes = DataTables::of ($transactiontypes)

            ->addColumn ('action',function($row){
                return 
                     '<a href="#" class="btn btn-success edittransactiontype" data-id="'.$row->id.'">Edit</a>
                     <a href="#" id="deletetransactiontype" class="btn btn-danger" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['action'])
            ->make(true);

            return $transactiontypes;
        }
    }

    // store a transaction type in the db
    public function addtransactiontype(Request $request)
    {
        $data=$request->all();
        $transactiontyp=Payment_Transactiontype::where('name',$data['name'])->count();
        if($transactiontyp>0){
            $message="Transaction Type exists in the database.";
            return response()->json(['status'=>400,
                                    'message'=>$message]);
        }else{

            $data=$request->all();

            Payment_Transactiontype::create([
                'name'=>$data['name'],
                'number'=>$data['number']
            ]);

            $message="Transaction Type Has Been Saved In the DB Successfully.";
            return response()->json([
                'status'=>200,
                'message'=>$message
            ]);
        }     
    }

    // show transaction type details on a modal
    public function edittransactiontype($id)
    {
        $showtransactiontype=Payment_Transactiontype::find($id);

        if(! $showtransactiontype)
        {
            abort(404);
        }
        return $showtransactiontype;
    }

    // update a room name
    public function updatetransactiontype(Request $request)
    {
        $data=$request->all();

        $transactiontypcount=Payment_Transactiontype::where(['name'=>$data['transactiontypename'],'number'=>$data['roomsize_price']])->count();

        if($transactiontypcount>0){
            $message="The Transaction Type already exists.";
            return response()->json(['status'=>400,
                                    'message'=>$message]);
        }else{

            $trnsactiontypname=Payment_Transactiontype::find($request->transactiontypeid);

            $data=$request->all();

            $trnsactiontypname->update([
                'name'=>$data['transactiontypename'],
                'number'=>$data['roomsize_price']
            ]);

            $message="Transaction Type Name Has Been Updated Successfuly .";
            return response()->json([
                'status'=>200,
                'message'=>$message
            ]);

        }
    }

    // delete a Room name
    public function delete_transactiontype($id)
    {
        $deletetransactiontype=Payment_Transactiontype::find($id);

        if($deletetransactiontype)
        {
            $deletetransactiontype->delete();
            return response()->json([
                'success'=>200,
                'message'=>'Transaction Type Has Been Deleted Successfully'
            ]);
        }else{
    
            return response()->json([
                'success'=>404,
                'message'=>'Transaction Type Not Found'
            ]);
        }
    }

    // update the status for a Transaction type
    public function updatetransactiontypestatus(Request $request)
    {
        $transactiontypestatus=Payment_Transactiontype::find($request->id);
        $transactiontypestatus->status=$request->status;
        $transactiontypestatus->save();

        return response()->json([
            'status'=>200,
            'message'=>'Transaction Type Status changed successfully'
        ]);
    }
}
