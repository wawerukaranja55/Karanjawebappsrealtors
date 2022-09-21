<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Rental_category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class Rentalcategory_controller extends Controller
{

    // show all rental categories for a rental house
    public function get_rentalcats(Request $request)
    {
        $rentalcats=Rental_category::select('id','rentalcat_title','status');
        Session::put('page','rental_tags');

        if($request->ajax()){
            $rentalcats = DataTables::of ($rentalcats)


            ->addColumn ('edit',function($row){
                return 
                     '<a href="#" title="Edit the cat" class="btn btn-success editrentalcat" data-id="'.$row->id.'"><i class="fas fa-edit"></i></a>';
            })
            ->rawColumns(['edit'])
            ->make(true);

            return $rentalcats;
        }
    }
     
    // store a rental category in the db
    public function addrentalcat(Request $request)
    {
        $data=$request->all();
        $rentalcategory=Rental_category::where('rentalcat_title',$data['rentalhsecategory'])->count();
        if($rentalcategory>0){
            $message="The Rental House Category exists in the database.";
            return response()->json(['status'=>400,
                                    'message'=>$message]);
        }else{

            $data=$request->all();

            Rental_category::create([
                'rentalcat_title'=>$data['rentalhsecategory'],
                'rentalcat_url'=>$data['rentalcategoryslug']
            ]);

            $message="Rental Category Has Been Saved In the DB Successfully.";
            return response()->json([
                'status'=>200,
                'message'=>$message
            ]);
        }     
    }

    // show rental category on a modal
    public function editrentalcat($id)
    {
        $showrentalcategory=Rental_category::find($id);

        if(! $showrentalcategory)
        {
            abort(404);
        }
        return $showrentalcategory;
    }

    // update a room name
    public function updaterentalcat(Request $request)
    {
        $data=$request->all();

        $hsecount=Rental_category::where(['rentalcat_title'=>$data['rentalhsecategory'],'rentalcat_url'=>$data['rentalcategoryslug']])->count();

        if($hsecount>0){
            $message="The Rental Category already exists.";
            return response()->json(['status'=>400,
                                    'message'=>$message]);
        }else{

            $rentalcatname=Rental_category::find($request->rentalhsecat_id);

            $data=$request->all();

            $rentalcatname->update([
                'rentalcat_title'=>$data['rentalhsecategory'],
                'rentalcat_url'=>$data['rentalcategoryslug']
            ]);

            $message="Rental Category Has Been Updated Successfuly .";
            return response()->json([
                'status'=>200,
                'message'=>$message
            ]);

        }
    }

    // delete a Room name
    public function delete_rentalcat($id)
    {
        $deletecat=Rental_category::find($id);

        if($deletecat)
        {
            $deletecat->delete();
            return response()->json([
                'success'=>200,
                'message'=>'Rental Category Has Been Deleted Successfully'
            ]);
        }else{
    
            return response()->json([
                'success'=>404,
                'message'=>'Rental Category Not Found'
            ]);
        }
    }

    // update the status for an Rental Tag
    public function updaterentalcatstatus(Request $request)
    {
        $rentalcatstatus=Rental_category::find($request->id);
        $rentalcatstatus->status=$request->status;
        $rentalcatstatus->save();

        return response()->json([
            'status'=>200,
            'message'=>'Rental Tag Status changed successfully'
        ]);
    }
}
