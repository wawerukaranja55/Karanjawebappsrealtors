<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Location;
use App\Models\Room_name;
use App\Models\Rental_tags;
use App\Models\Rental_house;
use Illuminate\Http\Request;
use App\Models\Vacancy_status;
use App\Models\Rental_category;
use App\Models\Rental_location;
use App\Models\Rentalhousesize;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\Alternaterental_image;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class Rentalhouses_controller extends Controller
{

    // update the status for an Rental House
    public function updaterentalhsestatus(Request $request)
    {
        $hsestatus=Rental_house::find($request->id);
        $hsestatus->rental_status=$request->status;
        $hsestatus->save();

        return response()->json([
            'status'=>200,
            'message'=>'Rental house Status changed successfully'
        ]);
    }
    // show active rental houses
    public function get_activerentals(Request $request)
    {
        $activerentals=Rental_house::with(['housecategory','houselocation'])->where('rental_status',1)->select('id','rental_name','monthly_rent','location_id','rentalcat_id','total_rooms','rental_image','rental_status');
        
        if($request->ajax()){
            $activerentals = DataTables::of ($activerentals)

            ->addColumn ('location_id',function(Rental_house $rental_house){
                return $rental_house->houselocation->location_title;
            })

            ->addColumn ('rentalcat_id',function(Rental_house $rental_house){
                return $rental_house->housecategory->rentalcat_title;
            })

            ->addColumn ('action',function($row){
                return '
                <a title="Add alternative images for the house" href="/admin/add_alternateimages/'.$row->id.'" class="btn btn-primary btn-xs">
                    <i class="fa fa-image"></i>
                </a>

                <a href="#" title="Edit the Rental House" class="btn btn-success editrentalhse" data-id="'.$row->id.'"><i class="fas fa-edit"></i></a>';
            })
            ->rawColumns(['location_id','rentalcat_id','rental_status','action'])
            ->make(true);

            return $activerentals;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addrentalhse()
    {
        $allrentaltags=Rental_tags::where('status',1)->get();
        $allrentallocations=Location::where('status','1')->get();
        $allrentalcategories=Rental_category::where('status',1)->get();
        $allvacancystatus=Vacancy_status::where('status',1)->get();
        $alllandlords=User::where(['is_landlord'=>1,'is_approved'=>1])->get();
        
        Session::put('page','addrental_house');

        return view('Admin.Rental_houses.addrentalhouses',compact('allrentaltags','alllandlords','allvacancystatus','allrentallocations','allrentalcategories'));
    }

            // show the add images page
    public function addalternateimages(Request $request,$id)
    {
        
        $displayimages=Alternaterental_image::where('status',1)->get();

        $rentaldata=Rental_house::with('rentalalternateimages','housetags')->select('id','rental_name','location_id','rental_image','total_rooms','rental_video')->find($id);

        $roomsizescount=Rentalhousesize::where('rentalhse_id',$id)->sum('total_rooms');

        
        foreach($rentaldata->housetags as $hsetags)
        {
            $hsesizes[]=$hsetags->id;
        }

        // dd($hsesizes);die();
        return view('Admin.Rental_houses.edit_addimages',compact('rentaldata','roomsizescount','displayimages','hsesizes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->all();
        
        $rules=[
            'rental_details'=>'required',
            'rentalcat_id'=>'required',
            'location_id'=>'required',
            'total_rooms'=>'required|numeric|min:1',
            'landlord_id'=>'required',
        ];

        $custommessages=[
            'rental_details.required'=>'Write Merchadise description',
            'rentalcat_id.required'=>'The Category cant be blank.Select a category',
            'location_id.required'=>'The Category cant be blank.Select a Location',
            'total_rooms.required'=>'Kindly write the total rooms for the house',
            'total_rooms.numeric'=>'The total rooms should be a number',
            'total_rooms.min:1'=>'The total rooms should greater than 1',
            'landlord_id.required'=>'The Name Of the Landlord cannot be blank.Select the Landlord'
        ];

        $validator = Validator::make( $data,$rules,$custommessages );
        
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator);;
        }else{

            // show if a house has wifi amenity
            if(empty($data['wifi'])){
                $wifi='no';
            }else{
                $wifi='yes';
            }

            // show if a house has wifi amenity
            if(empty($data['wifi'])){
                $wifi='no';
            }else{
                $wifi='yes';
            }

            // show if a house has generator amenity
            if(empty($data['generator'])){
                $generator='no';
            }else{
                $generator='yes';
            }

            // show if a house has balcony amenity
            if(empty($data['balcony'])){
                $balcony='no';
            }else{
                $balcony='yes';
            }

            // show if a house has parking amenity
            if(empty($data['parking'])){
                $parking='no';
            }else{
                $parking='yes';
            }

            // show if a house has cctv_cameras amenity
            if(empty($data['cctv_cameras'])){
                $cctv_cameras='no';
            }else{
                $cctv_cameras='yes';
            }

            // show if a house has servant_quarters amenity
            if(empty($data['servant_quarters'])){
                $servant_quarters='no';
            }else{
                $servant_quarters='yes';
            }

            // show if a house is featured
            if(empty($data['is_featured'])){
                $is_featured='no';
            }else{
                $is_featured='yes';
            }

            if($request->hasFile('rental_image')){
                $imagetmp=$request->file('rental_image');
                if($imagetmp->isValid()){
                    $extension=$imagetmp->getClientOriginalExtension();
                    $image_name=$request->get('rental_name').'-'.rand(111,9999).'.'.$extension;

                    $large_image_path='imagesforthewebsite/rentalhouses/rentalimages/large/'.$image_name;
                    $medium_image_path='imagesforthewebsite/rentalhouses/rentalimages/medium/'.$image_name;
                    $small_image_path='imagesforthewebsite/rentalhouses/rentalimages/small/'.$image_name;

                    Image::make($imagetmp)->save($large_image_path);
                    Image::make($imagetmp)->resize(520,600)->save($medium_image_path);
                    Image::make($imagetmp)->resize(260,300)->save($small_image_path);

                }
            }

            $rental_house=new Rental_house();
            $rental_house->rental_name=$data['rental_name'];
            $rental_house->rental_slug=$data['rental_slug'];
            $rental_house->monthly_rent=$data['monthly_rent'];
            $rental_house->rental_image=$image_name;
            // $rental_house->rental_video=$video_name;
            $rental_house->rental_details=$data['rental_details'];
            $rental_house->rentalcat_id=$data['rentalcat_id'];
            $rental_house->landlord_id=$data['landlord_id'];
            $rental_house->location_id=$data['location_id'];
            $rental_house->total_rooms=$data['total_rooms'];
            $rental_house->is_featured=$is_featured;
            $rental_house->wifi=$wifi;
            $rental_house->generator=$generator;
            $rental_house->balcony=$balcony;
            $rental_house->parking=$parking;
            $rental_house->cctv_cameras=$cctv_cameras;
            $rental_house->servant_quarters=$servant_quarters;
            $rental_house->rental_status=0;
            $rental_house->total_rooms=$data['total_rooms'];
            $rental_house->save();

            $rental_house->housetags()->attach(request('rentaltags'));

            return redirect()->route('inactiverentalhses')->with('success','The Rental House has been added successfuly.');
        }
    }

    public function updaterentaldetails(Request $request,$id)
    {
        $data=$request->all();
        
        $rules=[
            'rental_name'=>'required',
            'monthly_rent'=>'required|numeric',
            'rental_details'=>'required',
            'total_rooms'=>'required|numeric',
            'landlord_id'=>'required',
            'rentalhousecategory'=>'required',
        ];

        $custommessages=[
            'rental_name.required'=>'Enter The Rental Name',
            'rental_slug.required'=>'Enter The Rental Slug',
            'total_rooms.required'=>'Enter The Merchadise Code',
            'monthly_rent.required'=>'Enter The Merchadise Price',
            'monthly_rent.numeric'=>'Enter a Valid Amount',
            'rental_details.required'=>'Write Merchadise description',
            'rentalhousecategory.required'=>'The Category cant be blank.Select a category',
            'total_rooms.required'=>'Kindly write the total rooms for the house',
            'total_rooms.numeric'=>'The total rooms should be a number',
            'landlord_id.required'=>'The Name Of the Landlord cannot be blank.Select the Landlord'
        ];

        $validator = Validator::make( $data,$rules,$custommessages );
        
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'message'=>$validator->errors()
            ]);
        }else{

            // show if a house has wifi amenity
            if(empty($data['edit_wifi'])){
                $wifi='no';
            }else{
                $wifi='yes';
            }

            // show if a house has generator amenity
            if(empty($data['edit_generator'])){
                $generator='no';
            }else{
                $generator='yes';
            }

            // show if a house has balcony amenity
            if(empty($data['edit_balcony'])){
                $balcony='no';
            }else{
                $balcony='yes';
            }

            // show if a house has parking amenity
            if(empty($data['edit_parking'])){
                $parking='no';
            }else{
                $parking='yes';
            }

            // show if a house has cctv_cameras amenity
            if(empty($data['edit_cctv_cameras'])){
                $cctv_cameras='no';
            }else{
                $cctv_cameras='yes';
            }

            // show if a house has servant_quarters amenity
            if(empty($data['edit_servant_quarters'])){
                $servant_quarters='no';
            }else{
                $servant_quarters='yes';
            }

            // show if a house is featured
            if(empty($data['edit_is_featured'])){
                $is_featured='no';
            }else{
                $is_featured='yes';
            }
            
            $rental_house=Rental_house::find($id);
            $rental_house->rental_name=$data['rental_name'];
            $rental_house->monthly_rent=$data['monthly_rent'];

            // update the image and video

            // if($request->hasfile('merch_video')){
            //     $videotmp=$request->file('merch_video');
            //     $video_name=$request->get('merch_name').'-'.rand(111,9999).'.'.$videotmp->getClientOriginalExtension();

            //     $video_path='videos/productvideos/'.$video_name;

            //     $videotmp->move($video_path,$video_name);
            // } else {
            //     $video_name=$request->merch_video;
            // }

            
            if($request->hasFile('rental_image')){
                // delete the image first then update
                $large_image_path='imagesforthewebsite/rentalhouses/rentalimages/large/'.$data['rental_image'];
                $medium_image_path='imagesforthewebsite/rentalhouses/rentalimages/medium/'.$data['rental_image'];
                $small_image_path='imagesforthewebsite/rentalhouses/rentalimages/small/'.$data['rental_image'];

                if(File::exists($large_image_path,$medium_image_path,$small_image_path))
                {
                    File::delete($large_image_path,$medium_image_path,$small_image_path);
                }
                    
                $imagetmp=$request->file('rental_image');

                if($imagetmp->isValid()){
                    $extension=$imagetmp->getClientOriginalExtension();

                    $image_name=$request->get('rental_name').'-'.rand(111,9999).'.'.$extension;
                    
                    $large_image_path='imagesforthewebsite/rentalhouses/rentalimages/large/'.$image_name;
                    $medium_image_path='imagesforthewebsite/rentalhouses/rentalimages/medium/'.$image_name;
                    $small_image_path='imagesforthewebsite/rentalhouses/rentalimages/small/'.$image_name;
                    
                    Image::make($imagetmp)->save($large_image_path);
                    Image::make($imagetmp)->resize(520,600)->save($medium_image_path);
                    Image::make($imagetmp)->resize(260,300)->save($small_image_path);

                }
            } else {
                $image_name=$request->rental_image;
            }

            if($request->hasFile('rental_video')){
                $videotmp=$request->file('rental_video');
                if($videotmp->isValid()){

                    $extension=$videotmp->getClientOriginalExtension();
                    $video_name=$request->get('rental_name').'-'.rand(111,9999).'.'.$extension;

                    $video_path='videos/rentalvideos/';
                    // $video_path='videos/rentalvideos/'.$data['rental_video'];
                    if(File::exists($video_path))
                    {
                        File::delete($video_path);
                    }

                    $videotmp->move($video_path,$video_name);
                }
            } else {
                $video_name=$request->rental_video;
            }

            $rental_house->rental_image=$image_name;
            $rental_house->rental_video=$video_name;
            $rental_house->rental_details=$data['rental_details'];
            $rental_house->rentalcat_id=$data['rentalhousecategory'];
            $rental_house->location_id=$data['rentalhouselocation'];
            $rental_house->total_rooms=$data['total_rooms'];
            $rental_house->landlord_id=$data['landlord_id'];
            $rental_house->wifi=$wifi;
            $rental_house->is_featured=$is_featured;
            $rental_house->generator=$generator;
            $rental_house->balcony=$balcony;
            $rental_house->parking=$parking;
            $rental_house->cctv_cameras=$cctv_cameras;
            $rental_house->servant_quarters=$servant_quarters;
            $rental_house->total_rooms=$data['total_rooms'];
            $rental_house->save();

            $rental_house->housetags()->sync(request('rentaltags'));

            return response()->json([
                'status'=>200,
                'message'=>'Rental House Data updated successfully'
            ]);
        }
    }

    // delete rental house details from the db
    public function deleterentaldetails(Request $request)
    {
        // delete the rental house from the table
        $houseid=$request->input('house_id');
        
        // delete the image from folders
        $rentalimage=Rental_house::select('rental_image','tagimages_status')->find($houseid);

        $large_image_folder = Storage::path($rentalimage->rental_image);
        $large_image_folder='imagesforthewebsite/rentalhouses/rentalimages/large/'.$rentalimage->rental_image;

        $medium_image_folder = Storage::path($rentalimage->rental_image);
        $medium_image_folder='imagesforthewebsite/rentalhouses/rentalimages/medium/'.$rentalimage->rental_image;

        $small_image_folder = Storage::path($rentalimage->rental_image);
        $small_image_folder='imagesforthewebsite/rentalhouses/rentalimages/small/'.$rentalimage->rental_image;
        
        $large_image_folder='imagesforthewebsite/rentalhouses/rentalimages/large/'.$rentalimage->rental_image;
        unlink($large_image_folder);

        $medium_image_folder='imagesforthewebsite/rentalhouses/rentalimages/medium/'.$rentalimage->rental_image;
        unlink($medium_image_folder);

        $small_image_folder='imagesforthewebsite/rentalhouses/rentalimages/small/'.$rentalimage->rental_image;
        unlink($small_image_folder);

        $imagefiles = array($large_image_folder,$medium_image_folder,$small_image_folder);
        
        File::delete($imagefiles);

        Rental_house::destroy($houseid);

        if($rentalimage->tagimages_status==1)
        {
            // delete alternate images related to the product
        
            $getalternateimage=Alternaterental_image::select('image')->where('house_id',$houseid)->first();

            $alternatlarge_image_folder = Storage::path($getalternateimage->image);
            $alternatlarge_image_folder='imagesforthewebsite/rentalhouses/alternateimages/large/'.$getalternateimage->image;

            $alternatmedium_image_folder = Storage::path($getalternateimage->image);
            $alternatmedium_image_folder='imagesforthewebsite/rentalhouses/alternateimages/medium/'.$getalternateimage->image;

            $alternatsmall_image_folder = Storage::path($getalternateimage->image);
            $alternatsmall_image_folder='imagesforthewebsite/rentalhouses/alternateimages/small/'.$getalternateimage->image;
            
            $alternatlarge_image_folder='imagesforthewebsite/rentalhouses/alternateimages/large/'.$getalternateimage->image;
            unlink($alternatlarge_image_folder);

            $alternatmedium_image_folder='imagesforthewebsite/rentalhouses/alternateimages/medium/'.$getalternateimage->image;
            unlink($alternatmedium_image_folder);

            $alternatsmall_image_folder='imagesforthewebsite/rentalhouses/alternateimages/small/'.$getalternateimage->image;
            unlink($alternatsmall_image_folder);

            $alternateimagefiles = array($alternatlarge_image_folder,$alternatmedium_image_folder,$alternatsmall_image_folder);
            
            File::delete($alternateimagefiles);

            Alternaterental_image::where('house_id',$houseid)->delete();
        }

        return redirect()->back()->with('success', 'The house record has been successfully deleted');
    }

    // show the edit aternative images page
    public function editalternateimages(Request $request,$id)
    {
        
        $displayimages=Alternaterental_image::where('status',1)->get();

        $rentaldata=Rental_house::with('rentalalternateimages','housetags')->select('id','rental_name','location_id','rental_image','total_rooms','rental_video')->find($id);

        $hsermsizes=Rentalhousesize::where('rentalhse_id',$id)->count();

        // foreach($rentaldata->housetags as $hsetags)
        // {
        //     $hsesizes=$hsetags->id;
        // }

        if ($rentaldata->is_addedtags==1)
        {
            foreach ($rentaldata->housetags()->get() as $hsetags)
            {
                $hsesizes=$hsetags->id;
            }
        }else
        {
            $hsesizes=0;
        }

        return view('Admin.Rental_houses.edit_roomnamesimages',compact('rentaldata','hsermsizes','displayimages','hsesizes'));
    }
    
    // store rental video in the database
    public function addrentalvideo(Request $request,$id)
    {

        $rentaldata=Rental_house::select('id','rental_name','location_id','rental_image','rental_video')->find($id);

        if($request->hasFile('file')){
            $videotmp=$request->file('file');
            if($videotmp->isValid()){
                $extension=$videotmp->getClientOriginalExtension();
                $video_name=$rentaldata->rental_name.'-'.rand(111,9999).'.'.$extension;

                $video_path='videos/rentalvideos/';
                $videotmp->move($video_path,$video_name);
            }
        }

        $rentaldata->update([
            'rental_video'=>$video_name,
        ]);

        return response()->json([
            'status'=>200,
            'message'=>'Video Uploaded Successfully'
        ]);
    }

    // delete rental house details from the db
    public function deleterentalvideo(Request $request)
    {
        // delete the video of the rental house from the table
        $housevideoid=$request->input('housevideo_id');
        
        // delete the image from folders
        $rentalvideo=Rental_house::select('rental_video')->where('id',$housevideoid)->first();

        $video_folder = Storage::path($rentalvideo->rental_video);
        $video_folder='videos/rentalvideos/'.$rentalvideo->rental_video;
        
        $video_folder='videos/rentalvideos/'.$rentalvideo->rental_video;
        unlink($video_folder);
        
        File::delete($video_folder);

        Rental_house::where('id',$housevideoid)->update(['rental_video' => NULL]);
        return response()->json([
            'status'=>200,
            'message'=>'Rental House Video Deleted successfully'
        ]);
    }
}
