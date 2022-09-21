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
        Session::put('page','users_roles');

        return view('Admin.Company_users.usersroles');
    }
    
    // show all roles for the users
    public function get_userroles(Request $request)
    {
        $userroles=Role::all();

        if($request->ajax()){
            $alluserroles = DataTables::of ($userroles)
            ->make(true);

            return $alluserroles;
        }
    }
    
    // update the status for a User Role
    public function updateuserrolestatus(Request $request)
    {
        $userrolestatus=Role::find($request->id);
        $userrolestatus->status=$request->status;
        $userrolestatus->save();

        return response()->json([
            'status'=>200,
            'message'=>'User Role Status changed successfully'
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

        $rolecount=Role::where('role_name',$data['rolename'])->count();

        if($rolecount>0){
            $message="The Rental Name already exists.";
            return response()->json(['status'=>400,
                                    'message'=>$message]);
        }else{

            $userrolename=Role::find($request->id);

            $userrolename->update([
                'role_name'=>$data['rolename']
            ]);

            $message="Rental Name Has Been Updated Successfuly .";
            return response()->json([
                'status'=>200,
                'message'=>$message
            ]);

        }
    }
}
