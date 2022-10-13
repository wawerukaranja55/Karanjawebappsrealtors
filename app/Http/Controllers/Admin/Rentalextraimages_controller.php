<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rental_house;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\Alternaterental_image;
use App\Models\Rentalhousesize;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class Rentalextraimages_controller extends Controller
{
    // getalternate images and load them through ajax
    public function get_extraimages(Request $request,$id)
    {
        $alternateimages=Alternaterental_image::where('house_id',$id)->select('id','image','status','house_id')->get();

        if($request->ajax()){
            $allimages = DataTables::of ($alternateimages)
            ->addColumn ('delete',function($row){
                return 
                     '<a href="#" class="deletehsextraimg btn btn-danger" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['delete'])
            ->make(true);

            return $allimages;
        }

        foreach($alternateimages->housetags as $hsetags)
        {

            $hsesizes[]=$hsetags->id;
        }

        // return view('Admin.Rental_houses.edit_addimages',compact('alternateimages'));
    }

    // store alternate images in the database
    public function alternateimages(Request $request,$id)
    {
        $rentaldata=Rental_house::with('rentalalternateimages')->select('id','rental_name','location_id','rental_image')->find($id);

        $data = array();

        $validator=Validator::make($request->all(),
        [
            'file'=>'required|mimes:png,jpg,jpeg|max:2048'
        ]);

        if($validator->fails()){
            $data['success']=0;
            $data['error']=$validator->errors()->first('file');
        }else{
            $images=$request->file('file');
        
            $rental_imagestmp=Image::make($images);
            $extension=$images->getClientOriginalExtension();
            
            $rental_imagesname=$rentaldata->rental_name.'-'.rand(111,9999).'.'.$extension;

            $alternatelarge_image_path='imagesforthewebsite/rentalhouses/alternateimages/large/'.$rental_imagesname;
            $alternatemedium_image_path='imagesforthewebsite/rentalhouses/alternateimages/medium/'.$rental_imagesname;
            $alternatesmall_image_path='imagesforthewebsite/rentalhouses/alternateimages/small/'.$rental_imagesname;

            Image::make($rental_imagestmp)->resize(1040,1200)->save($alternatelarge_image_path);
            Image::make($rental_imagestmp)->resize(520,600)->save($alternatemedium_image_path);
            Image::make($rental_imagestmp)->resize(260,300)->save($alternatesmall_image_path);

            $rental_images=new Alternaterental_image();
            $rental_images->image=$rental_imagesname;
            $rental_images->house_id=$id;
            $rental_images->save();

            // update is_xtra images to 1 on adding images
            Rental_house::where('id',$id)->update(['is_extraimages'=>1,'is_rentable'=>1]);

            $data['success']=1;
            $data['message']='Uploaded Successfully';
        }
        
        return response()->json($data);
    }

    // update the status for an alternative image for a rental house
    public function updatextraimagesstatus(Request $request)
    {
        $imagestatus=Alternaterental_image::find($request->id);
        $imagestatus->status=$request->status;
        $imagestatus->save();

        return response()->json([
            'status'=>200,
            'message'=>'Image Status changed successfully'
        ]);
    }

    // delete an Extra Image
    public function delete_xtraimage(Request $request)
    {

        // delete an extra image for a house from the table
        $imageid=$request->id;

        $extraimage=Alternaterental_image::find($imageid);

        // dd($extraimage);die();

        if($extraimage->image)
        {
            $large_xtraimage_folder = Storage::path($extraimage->image);
            $large_xtraimage_folder='imagesforthewebsite/rentalhouses/alternateimages/large/'.$extraimage->image;

            $medium_xtraimage_folder = Storage::path($extraimage->image);
            $medium_xtraimage_folder='imagesforthewebsite/rentalhouses/alternateimages/medium/'.$extraimage->image;

            $small_xtraimage_folder = Storage::path($extraimage->image);
            $small_xtraimage_folder='imagesforthewebsite/rentalhouses/alternateimages/small/'.$extraimage->image;
            
            $large_xtraimage_folder='imagesforthewebsite/rentalhouses/alternateimages/large/'.$extraimage->image;
            unlink($large_xtraimage_folder);

            $medium_xtraimage_folder='imagesforthewebsite/rentalhouses/alternateimages/medium/'.$extraimage->image;
            unlink($medium_xtraimage_folder);

            $small_xtraimage_folder='imagesforthewebsite/rentalhouses/alternateimages/small/'.$extraimage->image;
            unlink($small_xtraimage_folder);

            $xtraimagefiles = array($large_xtraimage_folder,$medium_xtraimage_folder,$small_xtraimage_folder);
            
            File::delete($xtraimagefiles);

            Alternaterental_image::destroy($imageid);

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
