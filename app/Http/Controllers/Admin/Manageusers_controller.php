<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\Rental_house;
use App\Models\Tenantstatus;
use Illuminate\Http\Request;
use App\Models\House_Request;
use App\Http\Controllers\Controller;
use App\Models\Room_name;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class Manageusers_controller extends Controller
{
    // show all users and assign them a new role respectively
    public function assignuser_roles()
    {  
        $allroles=Role::where('status',1)->get();
        $companyadmins =User::where('is_admin',1)->get();
        Session::put('page','assignuser_roles');
        return view('Admin.Company_users.assignuserroles',compact('allroles','companyadmins')
        );
    }

    public function getusersroles_assign(Request $request)
    {
        $all_users=User::with(['roles','hserooms','rentalhses','tenantstatus','userPayments'])->select('id','name','avatar','is_approved','house_id','phone');

        if($request->ajax()){
            $all_users = DataTables::of ($all_users)

            ->addColumn ('house_id',function(User $user){
                return $user->rentalhses->rental_name;
            })

            ->addColumn ('action',function($row){
                return 
                    '<a href="getuserpayments/'.$row->id.'" target="_blank" title="View All Payments Made by the Tenant" class="btn btn-success"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                    //  <a href="downloaduserpayments/'.$row->id.'" id="Download Payment" title="Download All Payments Made by the Tenant" class="btn btn-danger"><i class="fa fa-download"></i></a>;
            })

            // ->addColumn ('delete',function($row){
            //     return '
            //     <a href="#" title="Delete the User Details" id="deleteuser" class="btn btn-danger" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';
            // })
            ->rawColumns(['house_id','action'])
            ->make(true);

            return $all_users;
        }

        return view('Admin.Company_users.registeredusers',compact('registered_users'));
    }

    // activate or deactivate a user status
    public function updateuserrolestatus(Request $request)
    {
        $userrolestatus=User::find($request->id);
        $userrolestatus->is_approved=$request->status;
        $userrolestatus->save();

        return response()->json([
            'status'=>200,
            'message'=>'User Status has been changed successfully'
        ]);
    }

    public function deleteuserrole(Request $request)
    {

        //delete user details from the table
        $userroleid=$request->userroleid;

        $userdetails=User::with('hserooms')->find($userroleid);

        if($userdetails)
        {
            if($userdetails->avatar !== "default.jpg")
            {
                $userimagesfolder = Storage::path($userdetails->avatar);
                $userimagesfolder='imagesforthewebsite/usersimages/'.$userdetails->avatar;
                
                $userimagesfolder='imagesforthewebsite/usersimages/'.$userdetails->avatar;
                unlink($userimagesfolder);
                
                File::delete($userimagesfolder);
            }
        
            // // make the room of the user available
            Room_name::where('rentalhouse_id',$userdetails->house_id)->update(['is_occupied'=>0]);

            User::destroy($userroleid);

            return response()->json([
                'success'=>200,
                'message'=>'The User details have been Deleted Successfully from the System'
            ]);

        }else{
        
                return response()->json([
                    'success'=>404,
                    'message'=>'User details Not Found'
                ]);
        }
    }
    
    // show all registered users
    public function registered_users()
    {  
        $registered_users=User::with(['hserooms','rentalhses','tenantstatus'])->select('id','name','phone','house_id','is_approved','is_tenant');
        $allroles=Tenantstatus::where('status',1)->get();
        Session::put('page','registered_users');
        return view('Admin.Company_users.registeredusers',compact('registered_users')
        );
    }

    public function getregisteredtenants(Request $request)
    {
        $registered_users=User::with(['hserooms','rentalhses','tenantstatus'])->select('id','name','phone','house_id','is_approved');

        if($request->ajax()){
            $registered_users = DataTables::of ($registered_users)

            ->addColumn ('house_id',function(User $user){
                return $user->rentalhses->rental_name;
            })

            ->addColumn ('delete',function($row){
                return '
                <a href="#" title="Delete the Rental House" id="deletetenant" class="btn btn-danger" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['house_id','delete'])
            ->make(true);

            return $registered_users;
        }

        return view('Admin.Company_users.registeredusers',compact('registered_users'));
    }


    // get data into a modal
    public function getadmin_role($id)
    {
        $admindata=User::with('roles')->find($id);
        // $adminrole=$admindata->roles;
        if($admindata)
        {
            return response()->json([
                'status'=>200,
                // 'adminrole'=>$adminrole,
                'admindata'=>$admindata
            ]);
        } else {
            return response()->json([
                'status'=>404,
                'message'=>'Admin Not Found'
            ]);
        }
    }


    /**
     * assign admin another role
     */
    public function assign_role(Request $request)
    {
        $data=$request->all();
        $rules=[
            'selectname'=>'required',
        ];

        $custommessages=[
            'selectname.required'=>'The Role cant be blank.Select a role for the user'
        ];

        $validator = Validator::make($data,$rules,$custommessages );

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->$custommessages()
            ]);
        }else{
            $role=Role::where('id',$request->selectname)->first();
            $user=User::find($request->adminrole_id);

            if($role->id!==8 && $role->id!==7 && $user->is_admin=1)
            {
                $user->roles()->sync($role);
            }
            elseif($role->id==7 && $user->is_landlord==0){

                $user->roles()->sync($role);
                $user->update(['is_landlord'=>1]);
                $user->update(['is_admin'=>0]); 
                $user->update(['is_tenant'=>0]);
            }
            elseif($role->id!==7 && $role->id!==8 && $user->is_landlord=1){

                $user->roles()->sync($role);
                $user->update(['is_landlord'=>0]);
                $user->update(['is_admin'=>1]);
                $user->update(['is_tenant'=>0]);
            }
            elseif($role->id==8 && $user->is_admin=1){
                $user->roles()->sync($role);
                $user->update(['is_admin'=>0]);
                $user->update(['is_landlord'=>0]);
                $user->update(['is_tenant'=>1]);
            }
            
            $user->save();

            return response()->json([
                'user'=>$user->name,
                'status'=>200,
                'message'=>'The User has been assigned another role'
            ]);
        }
            
    }

    // show tenant statuses in a datatable
    public function tenant_status(Request $request)
    {
        $tenantstatus=Tenantstatus::select('id','tenantstatus_title');

        if($request->ajax()){
            $tenantstatus = DataTables::of ($tenantstatus)


            // ->addColumn ('delete',function($row){
            //     return 
            //          '<a href="#" readonly="" id="deletenantstatus" title="Delete the Tenant Status" class="btn btn-danger" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>';
            // })
            // ->rawColumns(['delete'])
            ->make(true);

            return $tenantstatus;
        }
    }

    // update tenant status from active to inactive
    public function updatetenantstatus(Request $request)
    {
        $tenantstatus=Tenantstatus::find($request->id);
        $tenantstatus->status=$request->status;
        $tenantstatus->save();

        return response()->json([
            'status'=>200,
            'message'=>'Tenant Status changed successfully'
        ]);
    }

    // view house requests made by users
    public function gethouse_requests(Request $request)
    {
        Session::put('page','house_requests');
        $hserequests=House_Request::select('id','name','phone','email','msg_request');

        if($request->ajax()){
            $hserequests = DataTables::of ($hserequests)

            ->addColumn ('delete',function($row){
                return 
                    '<a href="#" id="deletehserequest" class="btn btn-danger" data-id="'.$row->id.'">Delete</a>';
            })
            ->rawColumns(['delete'])
            ->make(true);

            return $hserequests;
        }

        return view('Admin.Rental_houses.houserequests',compact('hserequests'));
    }
}
