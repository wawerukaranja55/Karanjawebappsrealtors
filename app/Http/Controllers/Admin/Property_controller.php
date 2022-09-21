<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Models\Property_image;
use App\Models\Propertycategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class Property_controller extends Controller
{

    // add a new property form
    public function addaproperty()
    {
        $allpropertycategories=Propertycategory::where('status',1)->get();
        $alllocations=Location::where('status',1)->get();

        Session::put('page','addproperty');

        return view('Admin.Properties.addaproperty',compact('allpropertycategories','alllocations'));
    }

    public function store(Request $request)
    {
        $data=$request->all();
        $rules=[
            'property_name'=>'required',
            'property_slug'=>'required',
            'property_price'=>'required|numeric',
            'property_details'=>'required'
        ];

        $custommessages=[
            'property_name.required'=>'Enter The property Name',
            'property_slug.required'=>'Enter The property Slug',
            'property_price.required'=>'Enter The Proprty Price',
            'property_price.numeric'=>'Enter a Valid Amount',
            'property_details.required'=>'Kindly Write the property details'
        ];
        $this->validate($request,$rules,$custommessages);

        if($request->hasFile('property_image')){
            $imagetmp=$request->file('property_image');
            if($imagetmp->isValid()){
                $extension=$imagetmp->getClientOriginalExtension();
                $image_name=$request->get('property_name').'-'.rand(111,9999).'.'.$extension;

                $large_image_path='imagesforthewebsite/properties/propertyimages/large/'.$image_name;
                $medium_image_path='imagesforthewebsite/properties/propertyimages/medium/'.$image_name;
                $small_image_path='imagesforthewebsite/properties/propertyimages/small/'.$image_name;

                Image::make($imagetmp)->save($large_image_path);
                Image::make($imagetmp)->resize(520,600)->save($medium_image_path);
                Image::make($imagetmp)->resize(260,300)->save($small_image_path);

            }
        }

        // add a video
        // if(empty($data['property_video'])){
        //     $video_name='No video added';
        // }else{
        //     if($request->hasFile('property_video')){
        //         $videotmp=$request->file('property_video');
        //         if($videotmp->isValid()){
        //             $extension=$videotmp->getClientOriginalExtension();
        //             $video_name=$request->get('property_name').'-'.rand(111,9999).'.'.$extension;
    
        //             $video_path='videos/propertyvideos/';
        //             $videotmp->move($video_path,$video_name);
        //         }
        //     }
        // }

        $property=new Property();
        $property->property_name=$data['property_name'];
        $property->property_slug=$data['property_slug'];
        $property->property_price=$data['property_price'];
        $property->property_image=$image_name;
        // $property->property_video=$video_name;
        $property->property_details=$data['property_details'];
        $property->propertycat_id=$data['propertycategory'];
        $property->propertylocation_id=$data['propertyhouselocation'];
        $property->save();
        return redirect()->route('inactive.properties')->with('success','The Property has been created successfuly.Add Extra Images To Make it Active');
    }

    // Inactive Rental Hses management
    public function inactiveproperties()
    {
        
        Session::put('page','inactiveproperties');

        return view('Admin.Properties.inactiveproperties');
    }

    // show inactive properties
    public function get_inactiverentals(Request $request)
    {
        $inactiveproperties=Property::with(['propertycategory','propertylocation'])->where('property_isactive',0)->select('id','property_name','property_price','propertylocation_id','propertycat_id','property_image');

        if($request->ajax()){
            $inactiveproperties = DataTables::of ($inactiveproperties)

            ->addColumn ('propertylocation_id',function(Property $property){
                return $property->propertylocation->location_title;
            })

            ->addColumn ('propertycat_id',function(Property $property){
                return $property->propertycategory->propertycat_title;
            })

            ->addColumn ('action',function($row){
                return '
                <a title="Add alternative images for the property" href="/admin/add_propertyimages/'.$row->id.'" class="btn btn-primary btn-xs">
                    <i class="fa fa-image"></i>
                </a>

                <a href="#" title="Edit the Property Details" class="btn btn-success editpropertydetails" data-id="'.$row->id.'"><i class="fas fa-edit"></i></a>';
            })
            ->rawColumns(['propertylocation_id','propertycat_id','action'])
            ->make(true);

            return $inactiveproperties;
        }

        return view('Admin.Properties.inactiveproperties',compact('inactiveproperties'));
    }

    // show the add images page for the property
    public function addpropertyimages(Request $request,$id)
    {
        
        $propertyimages=Property_image::where('status',1)->get();

        $propertydata=Property::with('propertyimages')->select('id','property_name','propertylocation_id','property_image','property_video')->find($id);

        return view('Admin.Properties.propertyimages',compact('propertydata','propertyimages'));
    }

    // store Property images in the database
    public function propertyimages(Request $request,$id)
    {
        $propertydata=Property::with('propertyimages')->select('id','property_name','propertylocation_id','property_image')->find($id);

        $data = array();

        $validator=Validator::make($request->all(),
        [
            'file'=>'required|mimes:png,jpg,jpeg|max:2048'
        ]);

        if($validator->fails()){
            $data['success']=0;
            $data['error']=$validator->errors()->first('file');
        }else{
            $propertyimgs=$request->file('file');
        
            $property_imagestmp=Image::make($propertyimgs);
            $extension=$propertyimgs->getClientOriginalExtension();
            
            $property_imagesname=$propertydata->property_name.'-'.rand(111,9999).'.'.$extension;

            $propertylarge_image_path='imagesforthewebsite/properties/propertyxtraimages/large/'.$property_imagesname;
            $propertymedium_image_path='imagesforthewebsite/properties/propertyxtraimages/medium/'.$property_imagesname;
            $propertysmall_image_path='imagesforthewebsite/properties/propertyxtraimages/small/'.$property_imagesname;

            Image::make($property_imagestmp)->save($propertylarge_image_path);
            Image::make($property_imagestmp)->resize(520,600)->save($propertymedium_image_path);
            Image::make($property_imagestmp)->resize(260,300)->save($propertysmall_image_path);

            $property_images=new Property_image();
            $property_images->image=$property_imagesname;
            $property_images->property_id=$id;
            $property_images->save();

            // update is_xtra images to 1 on adding images
            Property::where('id',$id)->update(['property_isactive'=>1]);

            $data['success']=1;
            $data['message']='Uploaded Successfully';
        }
        
        return response()->json($data);
    }

    // get property images and load them to datatable through ajax
    public function get_propertyimages(Request $request,$id)
    {
        $propertyimgs=Property_image::where('property_id',$id)->select('id','image','status','property_id')->get();

        if($request->ajax()){
            $allpropertyimages = DataTables::of ($propertyimgs)
            
            ->addColumn ('delete',function($row){
                return 
                     '<a href="#" id="deletepropertyimg" class="btn btn-danger" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['delete'])
            ->make(true);

            return $allpropertyimages;
        }

        return view('Admin.Properties.propertyimages',compact('allpropertyimages'));
    }

    // update the status for a property image 
    public function updatepropertyimagesstatus(Request $request)
    {
        $propertyimgstatus=Property_image::find($request->id);
        $propertyimgstatus->status=$request->status;
        $propertyimgstatus->save();

        return response()->json([
            'status'=>200,
            'message'=>'Property Image Status changed successfully'
        ]);
    }

    // Active Properties management
    public function activeproperties()
    {
        
        Session::put('page','activeproperties');

        return view('Admin.Properties.activeproperties');
    }

    // show active properties
    public function get_activeproperties(Request $request)
    {
        $activedproperties=Property::with(['propertycategory','propertylocation'])->where('property_isactive',1)->select('id','property_name','property_price','propertylocation_id','propertycat_id','property_image');

        if($request->ajax()){
            $activedproperties = DataTables::of ($activedproperties)

            ->addColumn ('propertylocation_id',function(Property $property){
                return $property->propertylocation->location_title;
            })

            ->addColumn ('propertycat_id',function(Property $property){
                return $property->propertycategory->propertycat_title;
            })

            ->addColumn ('action',function($row){
                return '
                <a title="Add alternative images for the property" href="/admin/add_propertyimages/'.$row->id.'" class="btn btn-primary btn-xs">
                    <i class="fa fa-image"></i>
                </a>

                <a href="#" title="Edit the Property Details" class="btn btn-success editpropertydetails" data-id="'.$row->id.'"><i class="fas fa-edit"></i></a>';
            })
            ->rawColumns(['propertylocation_id','propertycat_id','action'])
            ->make(true);

            return $activedproperties;
        }

        return view('Admin.Properties.activeproperties',compact('inactiveproperties'));
    }

    // show property details on the  modal
    public function editproperty($id)
    {
        $editpropertydetails=Property::with(['propertycategory','propertylocation'])->find($id);
        if($editpropertydetails)
        {
            return response()->json([
                'status'=>200,
                'editpropertydetails'=>$editpropertydetails
            ]);
        } else {
            return response()->json([
                'status'=>404,
                'message'=>'Property Not Found'
            ]);
        }
    }

    // update property details
    public function updatepropertiesdetails(Request $request,$id)
    {
        $data=$request->all();
        $rules=[
            'property_name'=>'required',
            'property_slug'=>'required',
            'property_price'=>'required|numeric',
            'property_details'=>'required'
        ];

        $custommessages=[
            'property_name.required'=>'Enter The property Name',
            'property_slug.required'=>'Enter The property Slug',
            'property_price.required'=>'Enter The Proprty Price',
            'property_price.numeric'=>'Enter a Valid Amount',
            'property_details.required'=>'Kindly Write the property details'
        ];

        $validator = Validator::make( $data,$rules,$custommessages );
        
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'message'=>$validator->errors()
            ]);
        }else{

            $property=Property::find($id);
            $property->property_name=$data['property_name'];
            $property->property_slug=$data['property_slug'];
            $property->property_price=$data['property_price'];
            
            
            if($request->hasFile('property_image')){
                // delete the image first then update
                $large_image_path='imagesforthewebsite/properties/propertyimages/large/'.$data['property_image'];
                $medium_image_path='imagesforthewebsite/properties/propertyimages/medium/'.$data['property_image'];
                $small_image_path='imagesforthewebsite/properties/propertyimages/small/'.$data['property_image'];

                if(File::exists($large_image_path,$medium_image_path,$small_image_path))
                {
                    File::delete($large_image_path,$medium_image_path,$small_image_path);
                }
                    
                $imagetmp=$request->file('property_image');

                if($imagetmp->isValid()){
                    $extension=$imagetmp->getClientOriginalExtension();

                    $image_name=$request->get('property_name').'-'.rand(111,9999).'.'.$extension;
                    
                    $large_image_path='imagesforthewebsite/properties/propertyimages/large/'.$image_name;
                    $medium_image_path='imagesforthewebsite/properties/propertyimages/medium/'.$image_name;
                    $small_image_path='imagesforthewebsite/properties/propertyimages/small/'.$image_name;
                    
                    Image::make($imagetmp)->save($large_image_path);
                    Image::make($imagetmp)->resize(520,600)->save($medium_image_path);
                    Image::make($imagetmp)->resize(260,300)->save($small_image_path);

                }
            } else {
                $image_name=$request->property_image;
            }

            // $video_path='videos/propertyvideos/'.$data['property_video'];
            // if(File::exists($video_path))
            // {
            //     File::delete($video_path);
            // }

            // if($request->hasFile('property_video')){
            //     $videotmp=$request->file('property_video');
            //     if($videotmp->isValid()){
            //         $extension=$videotmp->getClientOriginalExtension();
            //         $video_name=$request->get('property_name').'-'.rand(111,9999).'.'.$extension;

            //         $video_path='videos/propertyvideos/';
            //         $videotmp->move($video_path,$video_name);
            //     }
            // } else {
            //     $video_name=$request->rentalproperty_video;
            // }

            $property->property_image=$image_name;
            // $property->property_video=$video_name;
            $property->property_details=$data['property_details'];
            $property->propertycat_id=$data['propertycategory'];
            $property->propertylocation_id=$data['propertyhouselocation'];
            $property->save();

            return response()->json([
                'status'=>200,
                'message'=>'Property Data updated successfully'
            ]);
        }
    }

    // store Property video in the database
    public function addpropertyvideo(Request $request,$id)
    {

        $propertydata=Property::select('id','property_name','property_video')->find($id);

        if($request->hasFile('file')){
            $videotmp=$request->file('file');
            if($videotmp->isValid()){
                $extension=$videotmp->getClientOriginalExtension();
                $property_name=$propertydata->property_name.'-'.rand(111,9999).'.'.$extension;

                $video_path='videos/propertyvideos/';
                $videotmp->move($video_path,$property_name);
            }
        }

        $propertydata->update([
            'property_video'=>$property_name,
        ]);

        return response()->json([
            'status'=>200,
            'message'=>'Video Uploaded Successfully'
        ]);
    }

    // delete Property video from the db
    public function deletepropertyvideo(Request $request)
    {
        // delete the video of the rental house from the table
        $propertyvideoid=$request->input('propertyvideo_id');
        
        // delete the image from folders
        $propertyvideo=Property::select('property_video')->where('id',$propertyvideoid)->first();
        $video_folder = Storage::path($propertyvideo->property_video);
        $video_folder='videos/propertyvideos/'.$propertyvideo->property_video;
        
        $video_folder='videos/propertyvideos/'.$propertyvideo->property_video;
        unlink($video_folder);
        
        File::delete($video_folder);

        Property::where('id',$propertyvideoid)->update(['property_video' => NULL]);
        return response()->json([
            'status'=>200,
            'message'=>'Property Video Deleted successfully'
        ]);
    }

    // delete an Extra Image
    public function deletepropertyimage(Request $request)
    {

        // delete an extra image for a house from the table
        $imageid=$request->propertyimageid;

        $extrapropertyimage=Property_image::find($imageid);

        if($extrapropertyimage->image)
        {
            $large_xtraimage_folder = Storage::path($extrapropertyimage->image);
            $large_xtraimage_folder='imagesforthewebsite/properties/propertyxtraimages/large/'.$extrapropertyimage->image;

            $medium_xtraimage_folder = Storage::path($extrapropertyimage->image);
            $medium_xtraimage_folder='imagesforthewebsite/properties/propertyxtraimages/medium/'.$extrapropertyimage->image;

            $small_xtraimage_folder = Storage::path($extrapropertyimage->image);
            $small_xtraimage_folder='imagesforthewebsite/properties/propertyxtraimages/small/'.$extrapropertyimage->image;
            
            $large_xtraimage_folder='imagesforthewebsite/properties/propertyxtraimages/large/'.$extrapropertyimage->image;
            unlink($large_xtraimage_folder);

            $medium_xtraimage_folder='imagesforthewebsite/properties/propertyxtraimages/medium/'.$extrapropertyimage->image;
            unlink($medium_xtraimage_folder);

            $small_xtraimage_folder='imagesforthewebsite/properties/propertyxtraimages/small/'.$extrapropertyimage->image;
            unlink($small_xtraimage_folder);

            $xtraimagefiles = array($large_xtraimage_folder,$medium_xtraimage_folder,$small_xtraimage_folder);
            
            File::delete($xtraimagefiles);

            Property_image::destroy($imageid);

            return response()->json([
                'success'=>200,
                'message'=>'The image Has Been Deleted Successfully'
            ]);

        }else{
        
                return response()->json([
                    'success'=>404,
                    'message'=>'Image Not Found'
                ]);
        }
    }
}
