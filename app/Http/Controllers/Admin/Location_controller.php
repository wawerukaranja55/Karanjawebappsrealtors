<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class Location_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('page','locations');

        return view('Admin.locations');
    }

    // get all locations
    public function get_locations(Request $request)
    {
        $locations=Location::select('id','location_title','status');

        if($request->ajax()){
            $locations = DataTables::of ($locations)

            ->addColumn ('action',function($row){
                return 
                     '<a href="#" title="Edit the location" class="btn btn-success editlocation" data-id="'.$row->id.'"><i class="fas fa-edit"></i></a>
                     <a href="#" id="deletelocation" title="Delete the Location" class="btn btn-danger" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['action'])
            ->make(true);

            return $locations;
        }
    }

    // update location status 
    public function updatelocationstatus(Request $request)
    {
        $locationstatus=Location::find($request->id);
        $locationstatus->status=$request->status;
        $locationstatus->save();

        return response()->json([
            'status'=>200,
            'message'=>'Location Status changed successfully'
        ]);
    }

    // add a role using ajax
    public function addlocation(Request $request)
    {
        $data=$request->all();

        $rules=[
            'location_title'=>'required'
        ];

        $custommessages=[
            'location_title.required'=>'Enter The Location Name'
        ];

        $validator = Validator::make( $data,$rules,$custommessages );
        
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'message'=>$validator->errors()
            ]);
        }else{

            $location=Location::where('location_title',$data['location_title'])->count();
            if($location>0){
                $message="The Location exists in the database.";
                return response()->json(['status'=>404,
                                        'message'=>$message]);
            }else{

                $data=$request->all();

                Location::create([
                    'location_title'=>$data['location_title'],
                ]);

                $message="The Location Has Been Saved In the DB Successfully.";
                return response()->json([
                    'status'=>200,
                    'message'=>$message
                ]);
            }  
        }
    }

    // edit location and show in a modal
    public function editlocation($id)
    {
        $editlocation=Location::find($id);

        if(! $editlocation)
        {
            abort(404);
        }
        return $editlocation;
    }

    // update a room name
    public function updatelocation(Request $request)
    {
        
        $data=$request->all();

        $location=Location::where('location_title',$data['locationname'])->count();
        if($location>0){
            $message="The Location exists in the database.";
            return response()->json(['status'=>404,
                                    'message'=>$message]);
        }else{

            $locationnametitle=Location::find($request->location_id);
            $locationnametitle->update([
                'location_title'=>$data['locationname']
            ]);

            $message="Location details Have Been Updated Successfuly .";
            return response()->json([
                'status'=>200,
                'message'=>$message
            ]);
        } 
    }

    // delete a location
    public function delete_location($id)
    {
        $deletelocation=Location::find($id);

        if($deletelocation)
        {
            $deletelocation->delete();
            return response()->json([
                'success'=>200,
                'message'=>'Location Has Been Deleted Successfully'
            ]);
        }else{
    
            return response()->json([
                'success'=>404,
                'message'=>'Location Not Found'
            ]);
        }
    }
}
