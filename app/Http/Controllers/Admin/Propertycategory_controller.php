<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Propertycategory;
use App\Http\Controllers\Controller;
use App\Notifications\Adminactivities;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Notification;

class Propertycategory_controller extends Controller
{
    // show update modal details
    public function edit_propertycategories($id)
    {
        $category=Propertycategory::find($id);

        if(! $category)
        {
            abort(404);
        }
        return $category;
    }

    // add and edit a property category
    public function storepropertycat(Request $request)
    {
        $data=$request->all();

        if($request->propertycat_id)
        {
            
            $propcategory=Propertycategory::where(['propertycat_title'=>$data['rentalhsecategory'],'propertycat_url'=>$data['rentalcategoryslug']])->count();
            if($propcategory>0){
                $message="Property Category details exists in the database.";
                return response()->json(['status'=>400,
                                        'message'=>$message]);
            }else{
                $category=Propertycategory::find($request->propertycat_id);

                $category->update([
                    'propertycat_title'=>$data['rentalhsecategory'],
                    'propertycat_url'=>$data['rentalcategoryslug']
                ]);

                $message="Property Category details Have Been Updated Successfuly .";
                return response()->json([
                    'status'=>200,
                    'message'=>$message
                ]);
            }
        }else{

            $propcategory=Propertycategory::where(['propertycat_title'=>$data['rentalhsecategory'],'propertycat_url'=>$data['rentalcategoryslug']])->count();
            if($propcategory>0){
                $message="Property Category details exists in the database.";
                return response()->json(['status'=>400,
                                        'message'=>$message]);
            }else{
                Propertycategory::create([
                    'propertycat_title'=>$data['propertycat_title'],
                    'propertycat_url'=>$request->propertycat_url
                ]);

                $message="Property Category Have Been saved Successfuly .";
                return response()->json([
                    'status'=>200,
                    'message'=>$message
                ]);
            }

        }
    }

    public function propertycategories()
    {
         Session::put('page','propertiescategories');

        return view('Admin.Properties.propertiescategories');
    }

    // get property categories
    public function get_propertycategories(Request $request)
    {
        $propertiescategories=Propertycategory::select('id','propertycat_title','propertycat_url','status');

        if($request->ajax()){
            $allpropertycats = DataTables::of ($propertiescategories)

            ->addColumn ('edit',function($row){
                return 
                    '<a href="#" class="btn btn-success editpropcatbutton" data-id="'.$row->id.'">Edit</a>';
            })
            ->rawColumns(['edit'])
            ->make(true);

            return $allpropertycats;
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
