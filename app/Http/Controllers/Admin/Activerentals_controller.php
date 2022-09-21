<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use App\Models\Rental_tags;
use App\Models\Rental_house;
use App\Models\Vacancy_status;
use Illuminate\Http\Request;
use App\Models\Rental_category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class Activerentals_controller extends Controller
{
    // Active Rental Hses management
    public function activerentalhses()
    {
        // $allrentaltags=Rental_tags::where('status',1)->get();
        

        // $allrentalcategories=Rental_category::where('status',1)->get();

        // $allvacancystatus=Vacancy_status::where('status',1)->get();

        // // $rentaldata=Rental_house::with('rentalalternateimages')->find($id);
        
        // $allrentallocations=Location::where('status',1)->get();

        Session::put('page','activerentals');

        return view('Admin.Rental_houses.activehouses');
    }

    // show active rental houses
    public function get_activerentals(Request $request)
    {
        $activerentals=Rental_house::with(['housecategory','houselocation'])->where(['rental_status'=>1,'is_extraimages'=>1])->select('id','rental_name','monthly_rent','location_id','rentalcat_id','total_rooms','rental_image','rental_status');

        if($request->ajax()){
            $activerentals = DataTables::of ($activerentals)

            ->addColumn ('location_id',function(Rental_house $rental_house){
                return $rental_house->houselocation->location_title;
            })

            ->addColumn ('rentalcat_id',function(Rental_house $rental_house){
                return $rental_house->housecategory->rentalcat_title;
            })

            ->addColumn ('rental_status',function($row){
                return 
                '<input class="rentalhsestatus" type="checkbox" checked data-toggle="toggle" data-id="'.$row->id.'" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
            })

            ->addColumn ('action',function($row){
                return '
                <a title="Edit alternative images and room names for the house" href="/admin/edit_alternateimages/'.$row->id.'" class="btn btn-primary btn-xs">
                    <i class="fas fa-image"></i>
                </a>

                <a href="#" title="Edit the Rental House" class="editrentalhsedetails btn btn-success btn-xs" data-id="'.$row->id.'"><i class="fas fa-edit"></i></a>';
            })
            ->rawColumns(['location_id','rentalcat_id','rental_status','action'])
            ->make(true);

            return $activerentals;
        }

        return view('Admin.Rental_houses.inactivatehouses',compact('activerentals'));
    }

    // show rental details on the  modal
    public function editactiverental($id)
    {
        $editrentalhsedetail=Rental_house::with(['housecategory','houselocation','housetags'])->find($id);
        if($editrentalhsedetail)
        {
            return response()->json([
                'status'=>200,
                'editrentalhsedetail'=>$editrentalhsedetail
            ]);
        } else {
            return response()->json([
                'status'=>404,
                'message'=>'Rental House Not Found'
            ]);
        }
    }

}
