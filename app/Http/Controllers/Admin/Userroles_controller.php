<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class Userroles_controller extends Controller
{
    public function alluserroles()
    {
        $alluserroles=Role::all();
        Session::put('page','user_roles');

        return view('Admin.Rental_houses.userroles',compact('alluserroles'));
    }
    
    // show all roles for the users
    public function get_userroles(Request $request)
    {
        $userroles=Role::all();
        Session::put('page','user_roles');

        if($request->ajax()){
            $userroles = DataTables::of ($userroles)

            ->addColumn ('status',function($row){
                return 
                '<input class="userrolestatus" type="checkbox" checked data-toggle="toggle" data-id="'.$row->id.'" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
            })

            ->addColumn ('action',function($row){
                return 
                     '<a href="#" title="Edit the role" class="btn btn-success edituserrole" data-id="'.$row->id.'"><i class="fas fa-edit"></i></a>
                     <a href="#" id="deleterentalrole" title="Delete the Role" class="btn btn-danger" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['status','action'])
            ->make(true);

            return $userroles;
        }

        return view('Admin.Rental_houses.userroles',compact('userroles'));
    }
    
    

    // add a role using ajax
    public function addrolename(Request $request)
    {
        $data=$request->all();
        $userrole=Role::where('role_name',$data['role_name'])->count();
        if($userrole>0){
            $message="The Role exists in the database.Kindly Create a new Role Name";
            return response()->json(['status'=>400,
                                    'message'=>$message]);
        }else{

            Role::create([
                'role_name'=>$data['role_name']
            ]);

            $message="Role Name Has Been Saved In the DB Successfully.";
            return response()->json([
                'status'=>200,
                'message'=>$message
            ]);
        } 
    }

    // update the status for an Rental Tag
    public function updaterolenamestatus(Request $request)
    {
        $rolestatus=Role::find($request->id);
        $rolestatus->status=$request->status;
        $rolestatus->save();

        return response()->json([
            'status'=>200,
            'message'=>'Role Status changed successfully'
        ]);
    }
    
    // show user role to edit on the  modal
    public function edituserrole($id)
    {
        $edituserrole=Role::find($id);

        if(! $edituserrole)
        {
            abort(404);
        }
        return $edituserrole;
    }

    // update a room name
    public function updateuserrole(Request $request)
    {
        $data=$request->all();
       
        $hsecount=Role::where('role_name',$data['rentaltagname'])->count();

        if($hsecount>0){
            $message="The Rental Name already exists.";
            return response()->json(['status'=>400,
                                    'message'=>$message]);
        }else{

            $rentaltagname=Role::find($request->rentaltag_id);

            $data=$request->all();

            $rentaltagname->update([
                'role_name'=>$data['rentaltagname']
            ]);

            $message="Rental Name Has Been Updated Successfuly .";
            return response()->json([
                'status'=>200,
                'message'=>$message
            ]);

        }
    }

    // delete a Room name
    public function deleteuserrole($id)
    {
        $deletetag=Role::find($id);

        if($deletetag)
        {
            $deletetag->delete();
            return response()->json([
                'status'=>200,
                'message'=>'The Role Has Been Deleted Successfully'
            ]);
        }else{
    
            return response()->json([
                'status'=>404,
                'message'=>'Role Not Found'
            ]);
        }
    }
}
