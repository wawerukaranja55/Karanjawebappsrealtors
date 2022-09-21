<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rental_tags;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class Rentaltags_controller extends Controller
{
    // rental tags and categories management
    public function tagscatmngt()
    {
        Session::put('page','tagscatmngt');

        return view('Admin.Rental_houses.rentaltagscatmngt');
    }

    // show all room names for a rental house
    public function get_rentaltags(Request $request)
    {
        $rentaltags=Rental_tags::select('id','rentaltag_title','status');
        Session::put('page','rental_tags');

        if($request->ajax()){
            $rentaltags = DataTables::of ($rentaltags)

            ->addColumn ('edit',function($row){
                return 
                     '<a href="#" title="Edit the tag" class="btn btn-success editrentaltag" data-id="'.$row->id.'"><i class="fas fa-edit"></i></a>';
            })
            ->rawColumns(['edit'])
            ->make(true);

            return $rentaltags;
        }
    }
     
    // store a rental tag in the db
    public function addrentaltag(Request $request)
    {
        $data=$request->all();
        $rentaltag=Rental_tags::where('rentaltag_title',$data['rentaltagtitle'])->count();
        if($rentaltag>0){
            $message="The Rental Tag exists in the database.";
            return response()->json(['status'=>400,
                                    'message'=>$message]);
        }else{

            $data=$request->all();

            Rental_tags::create([
                'rentaltag_title'=>$data['rentaltagtitle']
            ]);

            $message="Rental Tag Has Been Saved In the DB Successfully.";
            return response()->json([
                'success'=>200,
                'message'=>$message
            ]);
        }     
    }

    // show room details on the  modal
    public function editrentaltag($id)
    {
        $editrentaltag=Rental_tags::find($id);

        if(! $editrentaltag)
        {
            abort(404);
        }
        return $editrentaltag;
    }

    // update a room name
    public function updaterentaltag(Request $request)
    {
        $data=$request->all();

        $hsecount=Rental_tags::where('rentaltag_title',$data['rentaltagname'])->count();


        if($hsecount>0){
            $message="The Rental tag already exists.";
            return response()->json(['status'=>400,
                                    'message'=>$message]);
        }else{

            $rentaltagname=Rental_tags::find($request->rentaltag_id);

            $data=$request->all();

            $rentaltagname->update([
                'rentaltag_title'=>$data['rentaltagname']
            ]);

            $message="Rental Tag Has Been Updated Successfuly .";
            return response()->json([
                'status'=>200,
                'message'=>$message
            ]);

        }
    }

    // delete a rental tag
    public function delete_rentaltag($id)
    {
        $deletetag=Rental_tags::find($id);

        if($deletetag)
        {
            $deletetag->delete();
            return response()->json([
                'success'=>200,
                'message'=>'Rental Tag Has Been Deleted Successfully'
            ]);
        }else{
    
            return response()->json([
                'success'=>404,
                'message'=>'Rental Tag Not Found'
            ]);
        }
    }

    // update the status for an Rental Tag
    public function updaterentaltagstatus(Request $request)
    {
        $imagestatus=Rental_tags::find($request->id);
        $imagestatus->status=$request->status;
        $imagestatus->save();

        return response()->json([
            'status'=>200,
            'message'=>'Rental Tag Status changed successfully'
        ]);
    }
}
