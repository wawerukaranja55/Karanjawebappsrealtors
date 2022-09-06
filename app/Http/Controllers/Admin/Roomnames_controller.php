<?php

namespace App\Http\Controllers\Admin;

use App\Models\Room_name;
use App\Models\Rental_house;
use Illuminate\Http\Request;
use App\Models\Rentalhousesize;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class Roomnames_controller extends Controller
{
    // show all room sizes for a rental house
    public function get_roomsizes(Request $request,$id)
    {
        $roomsizes=Rentalhousesize::where('rentalhse_id',$id)->select('rentalhse_id','room_size','roomsize_price','total_rooms','status')->get();

        if($request->ajax()){
            $allroomsizes = DataTables::of ($roomsizes)
            ->make(true);

            return $allroomsizes;
        }
    }

    // update the status for a room size for a rental house
    public function updatehousesizedetails(Request $request)
    {
        $data=$request->all();
        
        // the the total rooms for that house
        $totalroomsforthehse=Rental_house::where('id',$request->rentalhse_id)->pluck('total_rooms')->first();

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

            foreach($data['rentalhse_id'] as $key=>$value){
                if(!empty($value)){
                    Rentalhousesize::where(['rentalhse_id'=>$data['rentalhse_id'][$key]])->update
                    ([
                        'roomsize_price'=>$data["roomsize_price"][$key],
                        'total_rooms'=>$data["total_rooms"][$key]
                    ]);
                }
            }

            return response()->json([
                'status'=>200,
                'message'=>'Room Sizes Updated Successfully'
            ]);
        }
    }

    // show room names in the 

    // show all room names for a rental house in the editing page
    public function get_roomnames(Request $request,$id)
    {
        $roomnames=Room_name::where('rentalhouse_id',$id)->select('id','rentalhouse_id','room_name','house_size','status')->get();

        if($request->ajax()){
            $allrooms = DataTables::of ($roomnames)
            ->addColumn ('action',function($row){
                return 
                     '<a href="#" class="btn btn-success editroomname" data-id="'.$row->id.'">Edit</a>
                     <a href="#" id="deleteroomname" class="btn btn-danger" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['action'])
            ->make(true);

            return $allrooms;
        }
    }

    // store a room name in the database
    public function addroomname(Request $request)
    {
        $data=$request->all();
        // count the number of rooms
        $totalroomscount=Room_name::where('rentalhouse_id',$data['rentalhouseid'])->count();

        $totalrooms=Rental_house::where('id',$data['rentalhouseid'])->pluck('total_rooms')->first();

            // find the house details
        $checkifhsehasrmsizes = Rental_house::with('housetags')->find($data['rentalhouseid']);

        foreach($checkifhsehasrmsizes->housetags as $hsetgs)
        {
            $totalhsesizes[]=$hsetgs->id;
        }
        
        if($totalhsesizes==[1,2,3,6,7]){
            
            $totalroomsizecount=Rentalhousesize::where('rentalhse_id',$data['rentalhouseid'])->sum('total_rooms');
        }else{
            $totalroomsizecount=$totalrooms;
        }

        $roomcount=Room_name::where(['room_name'=>$data['room_numbername'],'rentalhouse_id'=>$data['rentalhouseid']])->count();

        if ($roomcount>0){
            $message="The Room name for the house already exists.";
            return response()->json(['status'=>400,
                                    'message'=>$message]);
        }
        elseif($totalroomscount==$totalrooms){
            
            Rental_house::where('id',$data['rentalhouseid'])->update(['rental_status'=>1]);

            $message="No Extra Rooms can be Added for this Rental House.";
            return response()->json([

                'status'=>404,
                'message'=>$message
            ]);
        }
        elseif ($totalroomscount==$totalroomsizecount)
        {
            
            Rental_house::where('id',$data['rentalhouseid'])->update(['rental_status'=>1]);

            $message="No Extra Rooms can be Added for this Rental House.";
            return response()->json([

                'status'=>500,
                'message'=>$message
            ]);
        }
        else
        {
            $addedrm=new Room_name();
            $addedrm->room_name=$data['room_numbername'];
            $addedrm->rentalhouse_id=$data['rentalhouseid'];
            $addedrm->house_size=$data['rentalhousermsize'];
            $addedrm->save();

            $recentlyaddedrms=Room_name::where('rentalhouse_id',$data['rentalhouseid'])->count();
            if($recentlyaddedrms==$totalrooms)
            {
                Rental_house::where('id',$data['rentalhouseid'])->update(['rental_status'=>1]);
            }

            $message="Room Name Has Been Saved In the DB.";
            return response()->json([

                'status'=>200,
                'message'=>$message
            ]);
        }  
    }

    // show room details on the  modal
    public function editroomname($id)
    {
        $room_name=Room_name::find($id);

        if(! $room_name)
        {
            abort(404);
        }
        return $room_name;
    }

    // update a room name
    public function updateroomname(Request $request)
    {
        $data=$request->all();
        $roomcount=Room_name::where('room_name',$data['roomname'])->count();
        if ($roomcount>0){
            $message="The Room name for the house already exists.";
            return response()->json(['status'=>400,
                                    'message'=>$message]);
        } else {

            $rolename=Room_name::find($request->roomid);

            $data=$request->all();

            $rolename->update([
                'room_name'=>$data['roomname'],
            ]);

            $message="Room Name Has Been Updated Successfuly .";
            return response()->json([

                'status'=>200,
                'message'=>$message
            ]);

        }
    }

    // delete a Room name
    public function delete_roomname($id)
    {
        $roomname=Room_name::find($id);

        if($roomname)
        {
            $roomname->delete();
            return response()->json([
                'success'=>200,
                'message'=>'Room name Has Been Deleted Successfully'
            ]);
        }else{
    
            return response()->json([
                'success'=>404,
                'message'=>'Room name Not Found'
            ]);
        }
    }

    // update the status for a room for a rental house
    public function updateroomnamestatus(Request $request)
    {
        $roomstatus=Room_name::find($request->id);
        $roomstatus->status=$request->status;
        $roomstatus->save();

        return response()->json([
            'status'=>200,
            'message'=>'Room Status changed successfully'
        ]);
    }
}
