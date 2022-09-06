// store a room name in the database
    public function addroomname(Request $request)
    {
        $data=$request->all();

        // count the number of rooms
        $totalroomscount=Room_name::where('rentalhouse_id',$data['rentalhouseid'])->count();

        $totalrooms=Rental_house::where('id',$data['rentalhouseid'])->pluck('total_rooms')->first();

            // find the house details
        // $checkifhsehasrmsizes = Rental_house::with('housetags')->find($data['rentalhouseid']);

        // foreach($checkifhsehasrmsizes->housetags as $hsetgs)
        // {
        //     $totalhsesizes[]=$hsetgs->id;
        // }
        
        // if($totalhsesizes==[1,2,3,6,7]){
            
        //     $totalroomsizecount=Rentalhousesize::where('rentalhse_id',$data['rentalhouseid'])->sum('total_rooms');
        // }else{
        //     $totalroomsizecount=$totalrooms;
        // }

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

                'success'=>404,
                'message'=>$message
            ]);
        }
        // elseif ($totalroomscount==$totalroomsizecount)
        // {
            
        //     Rental_house::where('id',$data['rentalhouseid'])->update(['rental_status'=>1]);

        //     $message="No Extra Rooms can be Added for this Rental House.";
        //     return response()->json([

        //         'success'=>500,
        //         'message'=>$message
        //     ]);
        // }
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

                'success'=>200,
                'message'=>$message
            ]);
        }  
    }