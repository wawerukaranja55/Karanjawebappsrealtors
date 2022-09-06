<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Propertycategory;
use App\Http\Controllers\Controller;
use App\Notifications\Adminactivities;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Notification;

class Propertycategory_controller extends Controller
{
    // show update modal details
    public function edit_propertycategories($id)
    {
        $category=Propertycategory::find($id);

        // dd($category);die();
        if(! $category)
        {
            abort(404);
        }
        return $category;
    }

    // add and edit a property category
    public function storepropertycat(Request $request)
    {
        if($request->propertycat_id)
        {
            $category=Propertycategory::find($request->propertycat_id);

            // dd($category);die();
            if(!$category)
            {
                abort(404);
            }else{
                $request->validate([
                    'property_category'=>'required',
                    'property_caturl'=>'required'
                ]);
        
                $category->update([
                    'propertycat_title'=>$request->property_category,
                    'propertycat_url'=>$request->property_caturl,
                ]);
        
                return response()->json([
                    'success'=>'Property Category Has Been Updated Successfully'
                ],201);
            }
        }else{
            $data=$request->all();
            // dd($data);die();
            $request->validate([
                'property_category'=>'required',
                'property_caturl'=>'required'
            ]);

            $propertycategeryadd=Propertycategory::create([
                'propertycat_title'=>$data['propertycat_title'],
                'propertycat_url'=>$data['property_caturl']
            ]);

            return response()->json([
                'success'=>'Property Category Has Been Saved In the DB'
            ],201);

            // send notifications to the superadmins
            $users=User::where('role_id','1')->first();
            Notification::send($users,new Adminactivities($propertycategeryadd));
        }
    }

    // get property categories
    public function get_propertycategories(Request $request)
    {
        $propertiescategories=Propertycategory::select('id','propertycat_title','propertycat_url');

        if($request->ajax()){
            $allpropertycats = DataTables::of ($propertiescategories)

            ->addColumn ('status',function($row){
                return 
                '<input class="propertycats_status" type="checkbox" checked data-toggle="toggle" data-id="'.$row->id.'" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
            })

            ->addColumn ('action',function($row){
                return 
                    '<a href="#" class="btn btn-success editbutton" data-id="'.$row->id.'">Edit</a>
                     <a href="#" id="deletepropertycat" class="btn btn-danger" data-id="'.$row->id.'">Delete</a>';
            })
            ->rawColumns(['status','action'])
            ->make(true);

            return $allpropertycats;
        }

        return view('Admin.Properties.propertiescategories',compact('propertiescategories'));
    }

    // delete a property category
    public function delete_propertycategories($id)
    {
        $category=Propertycategory::find($id);

        if($category)
        {
            $category->delete();
            return response()->json([
                'success'=>200,
                'message'=>'Property Category Has Been Deleted Successfully'
            ]);
        }else{
    
            return response()->json([
                'success'=>404,
                'message'=>'Property Category Not Found'
            ]);
        }
    }

    // update the status for an Property Category
    public function updatepropertycatstatus(Request $request)
    {
        $propertycatstatus=Propertycategory::find($request->id);
        $propertycatstatus->status=$request->status;
        $propertycatstatus->save();

        return response()->json([
            'status'=>200,
            'message'=>'Property Category Status changed successfully'
        ]);
    }
}
