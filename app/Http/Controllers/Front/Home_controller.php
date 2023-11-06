<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Models\Property;
use App\Models\Room_name;
use App\Models\Subscriber;
use App\Models\Rental_tags;
use App\Models\Rental_house;
use Illuminate\Http\Request;
use App\Models\Rental_category;
use Spatie\Newsletter\Newsletter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Mpesapayment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class Home_controller extends Controller
{
    public function index()
    { 
        Session::put('page','homepage');

        $showcommercialhses=Rental_house::where(['rentalcat_id'=>2,'is_rentable'=>1])->latest()->take(4)->get();

        $showlatestbedsitters = Rental_house::with(['houselocation','housecategory'])->whereHas('housetags', function($q) {
            $q->where('tag_id', 7);
        })->limit(4)->orderBy('id', 'DESC')->get();

        $showlatestlands=Property::where(['propertycat_id'=>1,'property_isactive'=>1])->latest()->take(4)->get();
        $meta_title="Rental and Property Management System and Website In Kenya";
        $meta_description="Rental Houses And Properties Management System For Realtors and Website";
        $meta_keywords="Rental and Property Mangement System,Content Management System,Realtor Website";
        return view('Front.homepage',compact('showcommercialhses','showlatestbedsitters','showlatestlands','meta_title','meta_description','meta_keywords'));
    }

    public function contactus()
    {
        Session::put('page','contact_us');
        $meta_title="Contact Us WkaranjaRealtorSystem";
        $meta_description="Rental Houses And Properties Management System For Realtors and Website";
        $meta_keywords="Rental and Property Mangement System,Content Management System,Realtor Website";

        return view('Front.contact',compact('meta_title','meta_description','meta_keywords'));
    }

    // show the rooms for a house on the register modal and page
    public function getroomsforahouse(Request $request)
    {
        $roomsforahouse=Room_name::where(['rentalhouse_id'=>$request->id,'status'=>1,'is_occupied'=>0])->select('room_name','id')->get();

        return response()->json($roomsforahouse);

    }

    // store subscribers into the db
    public function newslettersubscribe(Request $request)
    {
        $data=$request->all();
        $checksubscriber=Subscriber::where('email',$data['email'])->count();
        if($checksubscriber>0){
            $message="You have already subscribed to the Subscription List.";
            return response()->json(['status'=>400,
                                    'message'=>$message]);
        }else{

            $data=$request->all();

            Subscriber::create([
                'email'=>$data['email']
            ]);

            $message="Thank You For Subscribing to Our List.We'll be Sending You Updates On Rental Houses";
            return response()->json([
                'success'=>200,
                'message'=>$message
            ]);
        }
        
    }

    // write to the admin in the contact us page
    public function contactadmin(Request $request)
    {
        $data=$request->all();
        // send email admin to inform them to login
        $email="stephewaweru@gmail.com";

        $contactemail=$data['contact_email'];
        $contactname=$data['contact_name'];
        $contactphone=$data['contact_phone'];
        $contactmsg=$data['contact_details'];
        $messagedata=['contactphone'=>$contactphone,'contactemail'=>$contactemail,'contactmsg'=>$contactmsg,'contactname'=>$contactname,'contactmsg'=>$contactmsg];

        Mail::send('emails.contactadmin', $messagedata, function ($message) use($email) {
            $message->to($email)->subject('Message/Request from a User');
        });

        return response()->json([
            'status'=>200,
            'message'=>'Your Message has been successfully sent.We will get back to You Very Soon!'
        ]);
    }
}
