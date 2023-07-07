<?php

namespace App\Http\Controllers\Front;

use App\Models\Location;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Models\Property_request;
use App\Models\Propertycategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class Propertieslisting_controller extends Controller
{
    // show all properties of a certain category in the listing page
    public function propertycategory_list(Request $request){
        if($request->ajax()){

            $data=$request->all();

            $url=$data['propertyurl'];

            $propertycatcount=Propertycategory::where(['propertycat_url'=>$url,'status'=>1])->count();

            if($propertycatcount>0){

                $propertycategorydetails=Propertycategory::propertycategorydetails($url);
                
                $propertydetails=Property::whereIn('propertycat_id',$propertycategorydetails['propertyids'])
                ->where(['property_isactive'=>1,'property_isavailable'=>1]);

                    // check the propertytosorting value is selected
                if(isset($_GET['propertytosort']) && !empty($_GET['propertytosort'])){

                    if($_GET['propertytosort']=="latest_properties"){

                        $propertydetails->orderBy('id','Desc');
                    }
                    elseif($_GET['propertytosort']=="low_to_high"){
                        $propertydetails->orderBy('property_price','Asc');
                    }
                    elseif($_GET['propertytosort']=="high_to_low"){
                        $propertydetails->orderBy('property_price','Desc');
                    }
                    elseif($_GET['propertytosort']=="property_name_a_z"){
                        $propertydetails->orderBy('property_name','Asc');
                    }
                    elseif($_GET['propertytosort']=="property_name_z_a"){
                        $propertydetails->orderBy('property_name','Desc');
                    }
                }

                // search for a house loaction
                if(isset($data['propertylocationtitle']) && !empty($data['propertylocationtitle'])){
                    $propertydetails->where('propertylocation_id',$data['propertylocationtitle']);
                    // echo "<pre>";print_r($propertydetails->where('propertylocation_id',$data['propertylocationtitle'])->get());die();
                }

                $propertycategory=$propertydetails->paginate(3);
                
                return view('Front.Properties.propertiesjson',compact('url','propertycategory'));
            }  
            else{
                abort (404);
            }
        }else{

            Session::put('page','propertycategory'); 

            $propertycaturl=Route::current()->uri();
            
            $propertycatcount=Propertycategory::where(['propertycat_url'=>$propertycaturl,'status'=>1])->count();

            if($propertycatcount>0){
                $propertycategorydetails=Propertycategory::propertycategorydetails($propertycaturl);

                $propertycategory=Property::whereIn('propertycat_id',$propertycategorydetails['propertyids'])
                ->where(['property_isactive'=>1,'property_isavailable'=>1])->orderby('id','DESC')->paginate(3);
                $propertycategories=Propertycategory::withCount('onsaleproperties')->get();

                $propertylocations=Location::where(['status'=>1])->get();

                $meta_title=$propertycategory;
                $meta_description="Rental Houses And Properties Management System For Realtors and Website";
                $meta_keywords="Rental and Property Mangement System,Content Management System,Realtor Website";
            
                return view('Front.Properties.propertieslisting',compact('propertycaturl','propertylocations','propertycatcount','propertycategorydetails','propertycategory','propertycategories','meta_name','meta_description','meta_keywords'));
            }else{
                abort(404);
            }
        }
    }

    // store house request sent by user
    public function sendpropertyrequest(Request $request)
    {
        $data=$request->all();

        $rules=[
            'name'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'msg_request'=>'required',
        ];

        $custommessages=[
            'name.required'=>'Enter Your Name',
            'email.required'=>'Enter Your Email',
            'phone.required'=>'Enter Your Phone Number',
            'msg_request.required'=>'Write your Message on the text area',
        ];

        $validator = Validator::make( $data,$rules,$custommessages );
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'message'=>$validator->errors()
            ]);
        }else{

            $hserequest=new Property_request();
            $hserequest->name=$data['name'];
            $hserequest->email=$data['email'];
            $hserequest->phone=$data['phone'];
            $hserequest->msg_request=$data['msg_request'];
            $hserequest->property_id=$data['hse_id'];
            $hserequest->save();

            //get the property name of the request
            $propertyname=Property::where('id',$data['hse_id'])->pluck('property_name')->first();

            //email admin to send the request
            $email='edward.wambugu@gmail.com';

            $contactemail=$data['email'];
            $contactname=$data['name'];
            $contactphone=$data['phone'];
            $contactmsg=$data['msg_request'];
            $propertytitle=$propertyname;
            $messagedata=['contactphone'=>$contactphone,'propertytitle'=>$propertytitle,'contactemail'=>$contactemail,'contactmsg'=>$contactmsg,'contactname'=>$contactname,'contactmsg'=>$contactmsg];
    
            Mail::send('Emails.propertyhsereqst', $messagedata, function ($message) use($email) {
                $message->to($email)->subject('Message/Request from a User');
            });

            return response()->json([
                'status'=>200,
                'message'=>'Your Message Has been Sent Successfully to the Admin.We will get back to You With More Details'
            ]);

        }   
    }

    // show house details
    public function propertydetails ($property_slug,$id){

        $property=Property::with('propertyimages','propertylocation')->find($id);

        $relatedproperties=Property::where(['property_isactive'=>1,'property_isavailable'=>1])->where('id','!=',$id)->take(3)->get();
        
        $meta_title=$property;
        $meta_description="Rental Houses And Properties Management System For Realtors and Website";
        $meta_keywords="Rental and Property Mangement System,Content Management System,Realtor Website";

        return view('Front.Properties.propertydetails',compact('property','relatedproperties','meta_name','meta_description','meta_keywords'));
    }
}
