<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Room_name;
use App\Models\Rental_house;
use App\Models\Tenantstatus;
use Illuminate\Http\Request;
use App\Models\Houseratingreview;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class Tenant_controller extends Controller
{
    // get data into a modal
    public function gettenant_status($id)
    {
        $tenantdata=User::with('tenantstatus')->find($id);
        if($tenantdata)
        {
            return response()->json([
                'status'=>200,
                'tenantdata'=>$tenantdata
            ]);
        } else {
            return response()->json([
                'status'=>404,
                'message'=>'Tenantstaus Not Found'
            ]);
        }
    }

    /**
     * assign admin another role
     */
    public function assigntenant_status(Request $request,$id)
    {

        if($request->tenantstatname == 1)
        {
            $user=User::with('hserooms')->find($id);
            foreach ($user->hserooms as $usr) {
                $rmid[]=$usr->id;
            }
            

            $user->is_approved=$request->tenantstatname;
            $user->save();
            $user->tenantstatus()->sync(request('tenantstatname'));

            // $rmupdate=Room_name::where(['rentalhouse_id'=>$user->house_id,'id'=>['110','112']])->first();
            $rmupdate = Room_name::where('rentalhouse_id', $user->house_id)
                ->whereIn('id', $rmid)->get();

            foreach($rmupdate as $updateroom){//loop through an Eloquent collection instance
                $updateroom->is_occupied=1;//mass assign the new values
                $updateroom->save();//save the instance
            }

            $countoccupiedrms=Room_name::where(['rentalhouse_id'=>$user->house_id,'is_occupied'=>1])->count();
            $hsetotalrooms=Rental_house::where('id',$user->house_id)->pluck('total_rooms')->first();
            
            // update the house to fully booked if all the rooms are occupied
            if ($countoccupiedrms==$hsetotalrooms){
            
                Rental_house::where('id',$user->house_id)->update(['is_vacancy'=>2]);
            }

             // use 'sandbox' for development in the test environment
             // use your sandbox app API key for development in the test environment
            // $AT       = new AfricasTalking($username, $apiKey);

            // // Get one of the services
            // $sms      = $AT->sms();

            // $sms->send([
            //     'to'      => '+254702521351',
            //     'message' => 'Welcome here'
            // ]);

            $username = 'wkaranjawebapps';
            $apiKey   = 'fc4abd547d1bb533dd92a8ff180cc8098fa95fedaf6ce7f5ebe25cc00263706c';

            // Initialize the SDK
            $AT         = new AfricasTalking($username, $apiKey);

            // Get the SMS service
            $sms        = $AT->sms();

            // Set the numbers you want to send to in international format
            $recipients = "+254702521351,+254729822621,+254759194254";

            // Set your message
            $message    = "I'm a waweru and i love making softwares all day any day ";

            // Set your shortCode or senderId
            // $from       = "AFRICASTKNG";

            try {
                // Thats it, hit send and we'll take care of the rest
                $result=$sms->send([
                    'to'      => $recipients,
                    'message' => $message,
                    // 'from'    => $from
                ]);

                // $sms->send([
                //     'to'      => $recipients,
                //     'message' => $message,
                //     'from'    => $from
                // ]);
            } catch (Exception $e) {
                echo "Error: ".$e->getMessage();
                // dd($e->getMessage());die();
            }

            // send email to the user to inform them to login
            $email=$user['email'];
            $name=$user['name'];
            $housename=$user->rentalhses->rental_name;
            $messagedata=['email'=>$email,'name'=>$name,'housename'=>$housename];

            Mail::send('emails.signupsuccessful', $messagedata, function ($message) use($email) {
                $message->to($email)->subject('Welcome to W.Karanja Apps');
            });

            return response()->json([
                'user'=>$user,
                'status'=>200,
                'message'=>'The Tenant has been Activated and the tenant can login to his Account.'
            ]);

            // $occupiedrmscount=Room_name::where(['is_occupied'=>1,'rentalhouse_id'=>])->count();
    

        }elseif($request->tenantstatname == 2)
        {
            $tenantstatus=Tenantstatus::where('id',$request->tenantuser_id)->first();
            $user=User::find($id);
            $user->is_approved=$request->tenantstatname;
            $user->save();
            $user->tenantstatus()->sync(request('tenantstatname'));

            $rmupdate=Room_name::where('rentalhouse_id',$user->house_id)->first();

            $rmupdate->update([
                $rmupdate->is_occupied=0,
            ]);
            
            $countoccupiedrms=Room_name::where(['rentalhouse_id'=>$user->house_id,'is_occupied'=>1])->count();
            $hsetotalrooms=Rental_house::where('id',$user->house_id)->pluck('total_rooms')->first();
            
            // update the house to fully booked if all the rooms are occupied
            if ($countoccupiedrms!==$hsetotalrooms){
            
                Rental_house::where('id',$user->house_id)->update(['is_vacancy'=>1]);
            }

            return response()->json([
                'user'=>$user,
                'status'=>404,
                'message'=>'The Tenant Account have been Rejected By the Admin.Kindly Verify Your Details and register Again'
            ]);
        }elseif($request->tenantstatname == 3)
        {
            $tenantstatus=Tenantstatus::where('id',$request->tenantuser_id)->first();
            $user=User::find($id);
            $user->is_approved=$request->tenantstatname;
            $user->save();
            $user->tenantstatus()->sync(request('tenantstatname'));

            $rmupdate=Room_name::where('rentalhouse_id',$user->house_id)->first();

            $rmupdate->update([
                $rmupdate->is_occupied=0,
            ]);

            $countoccupiedrms=Room_name::where(['rentalhouse_id'=>$user->house_id,'is_occupied'=>1])->count();
            $hsetotalrooms=Rental_house::where('id',$user->house_id)->pluck('total_rooms')->first();
            
            // update the house to fully booked if all the rooms are occupied
            if ($countoccupiedrms!==$hsetotalrooms){
            
                Rental_house::where('id',$user->house_id)->update(['is_vacancy'=>1]);
            }

            return response()->json([
                'user'=>$user,
                'status'=>400,
                'message'=>'The Tenant Account have been Temporarily DEactivated By the Admin.You Will be Able to Login After Some Time'
            ]);
        }
            
    }

    // show reviews made by tenants on the admin panel
    public function tenantreviews()
    {
        Session::put('page','tenantratingsreviews');

        return view('Admin.Rental_houses.tenantreviews');
    }

    // get tenants reviews and show them in the datatable
    public function gettenantreviews(Request $request)
    {
        $tenantreviewsratings=Houseratingreview::with(['userrating','rentalhouse'])->select('id','house_review','house_rating','rating_isactive','user_id','hse_id','created_at');

        if($request->ajax()){
            $tenantreviewsratings = DataTables::of ($tenantreviewsratings)

            ->addColumn ('hse_id',function(Houseratingreview $houseratingreview){
                return $houseratingreview->rentalhouse->rental_name;
            })

            ->addColumn ('user_id',function(Houseratingreview $houseratingreview){
                return $houseratingreview->userrating->name;
            })

            ->addColumn ('created_at',function(Houseratingreview $houseratingreview){
                return $houseratingreview->created_at->timezone('EAT')->toDayDateTimeString();
            })

            ->addColumn ('rating_isactive',function($row){
                return 
                '<input class="hsereviewstatus" type="checkbox" checked data-toggle="toggle" data-id="'.$row->id.'" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
            })

            ->addColumn ('delete',function($row){
                return '
                <a href="#" title="Delete the Review" id="deletereviewrating" class="btn btn-danger" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['hse_id','user_id','rating_isactive','delete','created_at'])
            ->make(true);

            return $tenantreviewsratings;
        }

        return view('Admin.Rental_houses.tenantreviews',compact('tenantreviewsratings'));
    }

    // update the status for an Review to active or inactive
    public function updatereviewstatus(Request $request)
    {
        $reviewstatus=Houseratingreview::find($request->id);
        $reviewstatus->rating_isactive=$request->status;
        $reviewstatus->save();

        return response()->json([
            'status'=>200,
            'message'=>'The status of the Review has been changed successfully'
        ]);
    }
}
