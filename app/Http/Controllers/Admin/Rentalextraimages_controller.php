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

            Image::make($rental_imagestmp)->save($alternatelarge_image_path);
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

    // store room sizes for the house in the db
    public function housesizes(Request $request,$id)
    {
        $data=$request->all();

        // the the total rooms for that house
        $totalroomsforthehse=Rental_house::where('id',$id)->pluck('total_rooms')->first();

        $rules=[
            'room_size.*'=>'required',
            'roomsize_price.*'=>'required|numeric|min:1',
            'total_rooms.*'=>'required|numeric|min:1',
        ];

        $custommessages=[
            'room_size.*' => [
                'required' => 'Enter The Room Size',
            ],
            'roomsize_price.*' => [
                'required' => 'Enter The Price of the Room Size',
            ],
            'roomsize_price.*' => [
                'numeric' => 'Enter a Valid price',
            ],
            'roomsize_price.*' => [
                'min:1' => 'Room Size Price should not be less than 1',
            ],
            'total_rooms.*' => [
                'required' => 'Enter The number of total rooms for the house size',
            ],
            'total_rooms.*' => [
                'numeric' => 'Enter a Valid number',
            ],
            'total_rooms.*' => [
                'min:1' => 'Total rooms should not be less than 1',
            ]
        ];

        $validator = Validator::make( $data,$rules,$custommessages );
        
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'message'=>$validator->errors()
            ]);
        }
        elseif (array_sum($request->total_rooms)>$totalroomsforthehse)
        {
            $message="Your Total Rooms Doesnt match with the Total rooms you provided for the house.Kindly have a look again.";
            return response()->json([
                'status'=>404,
                'message'=>$message
            ]);
        }
        elseif (array_sum($request->total_rooms)<$totalroomsforthehse)
        {
            $message="Your Total Rooms Doesnt match with the Total rooms you provided for the house.Kindly have a look again.";
            return response()->json([
                'status'=>500,
                'message'=>$message
            ]);
        }
        else
        {

            foreach($data['roomsize_price'] as $key=>$value){
                if(!empty($value)){
                    $values = new Rentalhousesize();
                    $values->rentalhse_id = $id;
                    $values->room_size= $data["room_size"][$key];
                    $values->roomsize_price = $data['roomsize_price'][$key];
                    $values->total_rooms = $data['total_rooms'][$key];
                    $values->save();
                }
            }

            $data=Rentalhousesize::select('id','room_size','roomsize_price')->where('rentalhse_id',$id)->get();

            // update is_addedtags to 1 in the rental houses table
            Rental_house::where('id',$id)->update(['is_addedtags'=>1]);

            return response()->json([
                'data'=>$data,
                'status'=>200,
                'message'=>'Room Sizes saved in the database successfully'
            ]);
        }
    }
}
