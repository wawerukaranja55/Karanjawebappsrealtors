<?php

namespace App\Http\Controllers\Front;

use App\Models\Location;
use App\Models\Room_name;
use App\Models\Rental_tags;
use App\Models\Rental_house;
use Illuminate\Http\Request;
use App\Models\House_Request;
use Illuminate\Support\Carbon;
use App\Models\Rental_category;
use App\Models\Rentalhousesize;
use App\Models\Houseratingreview;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class Rentalslisting_controller extends Controller
{
    // show all houses of a certain category in the listing page
    public function rentalcategory_list (Request $request){
        if($request->ajax()){

            $data=$request->all();

            // echo "<pre>";print_r($data);

            $url=$data['url'];

            $rentalcatcount=Rental_category::where(['rentalcat_url'=>$url,'status'=>1])->count();

            if($rentalcatcount>0){

                $rentalcategorydetails=Rental_category::rentalcategorydetails($url);
                
                $rentalhousescategory=Rental_house::whereIn('rentalcat_id',$rentalcategorydetails['catids'])
                ->where(['rental_status'=>1,'is_extraimages'=>1,'is_rentable'=>1]);

                    // check the sorting value is selected
                if(isset($_GET['sort']) && !empty($_GET['sort'])){

                    if($_GET['sort']=="latest_houses"){

                        $rentalhousescategory->orderBy('id','Desc');
                    }
                    elseif($_GET['sort']=="low_to_high"){
                        $rentalhousescategory->orderBy('monthly_rent','Asc');
                    }
                    elseif($_GET['sort']=="high_to_low"){
                        $rentalhousescategory->orderBy('monthly_rent','Desc');
                    }
                    elseif($_GET['sort']=="house_name_a_z"){
                        $rentalhousescategory->orderBy('rental_name','Asc');
                    }
                    elseif($_GET['sort']=="house_name_z_a"){
                        $rentalhousescategory->orderBy('rental_name','Desc');
                    }
                }

                    // show products on pushing a slider
                
                if(isset($data['startprice']) && !empty($data['startprice'])){
                    $rentalhousescategory->
                    // whereBetween('monthly_rent', [$data['startprice'],$data['endprice']]);
                    // echo "<pre>";print_r( $der);
                    where('monthly_rent','>=',$data['startprice'])
                    ->where('monthly_rent','<=',$data['endprice']);
                }
                
                // check products for a certain amenity
                    // balcony
                if(isset($data['filterbalcony']) && !empty($data['filterbalcony'])){
                    $rentalhousescategory->where('rental_houses.balcony',$data['filterbalcony']);
                    // echo "<pre>";print_r( $rentalhousescategory);die();
                }

                    // generator
                if(isset($data['filtergenerator']) && !empty($data['filtergenerator'])){
                    $rentalhousescategory->where('rental_houses.generator',$data['filtergenerator']);
                    // echo "<pre>";print_r( $rentalhousescategory);die();
                }

                // wifi
                if(isset($data['filterwifi']) && !empty($data['filterwifi'])){
                    $rentalhousescategory->where('rental_houses.wifi',$data['filterwifi']);
                    // echo "<pre>";print_r( $rentalhousescategory);die();
                }

                // parking
                if(isset($data['filterparking']) && !empty($data['filterparking'])){
                    $rentalhousescategory->where('rental_houses.parking',$data['filterparking']);
                    // echo "<pre>";print_r( $rentalhousescategory);die();
                }

                // cctv
                if(isset($data['filtercctv']) && !empty($data['filtercctv'])){
                    $rentalhousescategory->where('rental_houses.cctv_cameras',$data['filtercctv']);
                }

                // servant_quarters
                if(isset($data['filtersq']) && !empty($data['filtersq'])){
                    $rentalhousescategory->where('rental_houses.servant_quarters',$data['filtersq']);
                }

                        // filter a house search using the tag
                if(isset($data['rentaltag']) && !empty($data['rentaltag'])){

                    $tag_id = $data['rentaltag'];

                    $rentalhousescategory->whereIn('id', function($q) use ($tag_id) {
                        $q->select('rental_id')->from('rentalhouse_tags')->where('tag_id', $tag_id);
                    });
                    
                }

                // search for a house loaction
                if(isset($data['rentallocations']) && !empty($data['rentallocations'])){
                    $rentalhousescategory->where('rental_houses.location_id',$data['rentallocations']);
                }

                $housescategory=$rentalhousescategory->paginate(4);
                
                return view('Front.Rentalslisting.rentalhsesjson',compact('url','housescategory'));
            }  
            else{
                abort (404);
            }
        }else{

            Session::put('page','rentalcategory'); 
            
            $rentalcaturl=Route::current()->uri();
            
            $rentalcatcount=Rental_category::where(['rentalcat_url'=>$rentalcaturl,'status'=>1])->count();

            
            if($rentalcatcount>0){
                $rentalcategorydetails=Rental_category::rentalcategorydetails($rentalcaturl);

                $housescategory=Rental_house::whereIn('rentalcat_id',$rentalcategorydetails['catids'])
                ->where(['rental_status'=>1,'is_extraimages'=>1,'is_rentable'=>1])->orderby('id','DESC')->paginate(4);
                $rentalcategories=Rental_category::withCount('rentalhses')->get();

                $rentaltags=Rental_tags::with('tagshouse')->get();

                $rentallocations=Location::where(['status'=>1])->get();
            
                return view('Front.Rentalslisting.allrentals',compact('rentalcaturl','rentallocations','rentalcatcount','rentalcategorydetails','rentaltags','housescategory','rentalcategories'));
            }else{
                abort(404);
            }
        }
    }

    // search rental houses using jquery
    public function findhouses(Request $request){

        $data=$request->all();

        $url=$data['url'];
            
        if($data['search_houses'])
        {

            $query=$data['search_houses'];

            $rentalcategorydetails=Rental_category::rentalcategorydetails($url);

            $rentalcategoryhouses=Rental_house::whereIn('rentalcat_id',$rentalcategorydetails['catids'])
            ->where(['rental_status'=>1,'is_rentable'=>1]);

            $data=$rentalcategoryhouses->where('rental_name','like','%'.$query.'%')->get();

            $output='<div class="filter-box">
                        <ul class="dropdown-menu" style="min-width:26rem; margin:3px; border-top:none; display:block; position:relative;">';
                        foreach($data as $row)
                        {
                            $output.='<li><a href="rentalhse/'.$row->rental_slug.'/'.$row->id.'">'.$row->rental_name.'</a></li>';
                        }
        }
        $output.='</ul></div>';

        echo $output;
    }

    // show video if the rental house has a video
    // protected function _rentalhsevideo($id)
    // {
    //     $apikey=config('services.youtube.api_key');
    //     $part='snippet';
    //     $url="https://www.googleapis.com/youtube/v3/videos?part=$part&id=$id&key=$apikey";
    //     $response=Http::get($url);
    //     $results=json_decode($response);

    //     File::put(Storage_path().'/app/public/singlevid.json',$response->body());

    //     return $results;
    // }

    // show house details
    public function singlehsedetails ($rental_slug,$id)
    {
        // $rentalhsevideo=$this->_rentalhsevideo($id);

        $rentalhouse=Rental_house::with('housetags','rentalalternateimages','houselocation')->find($id);
        
        $occupiedroomscount=Room_name::where('rentalhouse_id',$id)->where('is_occupied',1)->count();
        $availablerooms=$rentalhouse->total_rooms-$occupiedroomscount;
        $relatedhouses=Rental_house::where(['rental_status'=>1,'is_extraimages'=>1,'is_rentable'=>1])->where('id','!=',$id)->take(3)->get();
        $isfeaturedhouses=Rental_house::where(['rental_status'=>1,'is_extraimages'=>1,'is_featured'=>'yes'])->get();
        $activereviews=Houseratingreview::where(['rating_isactive'=>1,'hse_id'=>$id])->get();
        
        $userrating=null;
        $allowreview=false;
        $currentuserlivinginhouse=false;
        ////check if user is living in the house
        if(isset(Auth::user()->house_id) && Auth::user()->house_id==$id){
            $currentuserlivinginhouse=true;
        }
        
        if (Auth::check())
        {
            $userrating=Houseratingreview::where(['user_id'=>Auth::user()->id,'hse_id'=>$rentalhouse->id])->first();
            //if user is living in the house and rating not given then allow review
            if($currentuserlivinginhouse && !isset($userrating->id)){
                $allowreview=true;
            }  
        }
        
        return view('Front.Rentalslisting.rentalhsedetails',compact('allowreview','userrating','activereviews','availablerooms','rentalhouse','relatedhouses','isfeaturedhouses'));
    }

    // store house request sent by user
    public function sendhserequest(Request $request)
    {
        $data=$request->all();
        $hserequest=new House_Request();
        $hserequest->name=$data['name'];
        $hserequest->email=$data['email'];
        $hserequest->phone=$data['phone'];
        $hserequest->msg_request=$data['msg_request'];
        $hserequest->hse_id=$data['hse_id'];
        $hserequest->save();

        // get the property name of the request
        $rentalname=Rental_house::where('id',$data['hse_id'])->pluck('rental_name')->first();

        // email admin to send the request
        $email='stephewaweru@gmail.com';

        $contactemail=$data['email'];
        $contactname=$data['name'];
        $contactphone=$data['phone'];
        $contactmsg=$data['msg_request'];
        $propertytitle=$rentalname;
        $messagedata=['contactphone'=>$contactphone,'propertytitle'=>$propertytitle,'contactemail'=>$contactemail,'contactmsg'=>$contactmsg,'contactname'=>$contactname,'contactmsg'=>$contactmsg];

        Mail::send('emails.propertyhsereqst', $messagedata, function ($message) use($email) {
            $message->to($email)->subject('Message/Request from a User');
        });

        return response()->json([
            'status'=>200,
            'message'=>'Your Message Has been Sent Successfully to the Admin.We will get back to You With More Details'
        ]);   
    }

    // store rating and review in the database
    public function ratingandreview(Request $request)
    {
        if(!isset($request->rate))
        {
            $message="Kindly Give a Star Rating For the House";
            return response()->json([

                'status'=>400,
                'message'=>$message
            ]);
        }
        else
        {

            $newrating=new Houseratingreview();
            $newrating->house_review=$request->textreview;
            $newrating->rating_isactive=0;
            $newrating->user_id=$request->userid;
            $newrating->hse_id=$request->houseid;
            $newrating->house_rating=$request->rate;
            $newrating->save();

            $message="Thank You For Your Review and Rating.It has now been Submitted and will be Submitted";
            return response()->json([

                'status'=>200,
                'message'=>$message
            ]);
        }
    }

    // show the room prices for a house on the house details page
    public function getroomprices(Request $request)
    {

        $roomsizespriceforahouse=Rentalhousesize::where(['rentalhse_id'=>$request->rntalhouse_id,'room_size'=>$request->housesize])->select('roomsize_price')->first();

        return response()->json($roomsizespriceforahouse);

    }
}
