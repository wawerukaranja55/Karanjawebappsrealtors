<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use App\Models\Rental_tags;
use App\Models\Rental_house;
use Illuminate\Http\Request;
use App\Models\Vacancy_status;
use App\Models\Rental_category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class Inactiverentals_controller extends Controller
{
    // Inactive Rental Hses management
    public function inactiverentalhses()
    {
        
        Session::put('page','inactiverentals');

        return view('Admin.Rental_houses.inactivehouses'
        // ,compact('allrentaltags','allrentalcategories','allvacancystatus','allrentallocations','allrentallocations')
        );
    }

    // show inactive rental houses
    public function get_inactiverentals(Request $request)
    {
        $inactiverentals=Rental_house::with(['housecategory','houselocation'])->where('rental_status',0)->select('id','rental_name','monthly_rent','location_id','rentalcat_id','total_rooms','rental_image','rental_status');
        // Session::put('page','inactive_rentals');

        if($request->ajax()){
            $inactiverentals = DataTables::of ($inactiverentals)

            ->addColumn ('location_id',function(Rental_house $rental_house){
                return $rental_house->houselocation->location_title;
            })

            ->addColumn ('rentalcat_id',function(Rental_house $rental_house){
                return $rental_house->housecategory->rentalcat_title;
            })

            // ->addColumn ('rental_status',function($row){
            //     return 
            //     '<input class="rentalhsestatus" type="checkbox" checked data-toggle="toggle" data-id="'.$row->id.'" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
            // })

            ->addColumn ('action',function($row){
                return '
                <a title="Add alternative images for the house" href="/admin/add_alternateimages/'.$row->id.'" class="btn btn-primary btn-xs">
                    <i class="fa fa-image"></i>
                </a>

                <a href="#" title="Edit the Rental House" class="btn btn-success btn-xs editrentalhsedetails" data-id="'.$row->id.'"><i class="fas fa-edit"></i></a>';
            })
            ->rawColumns(['location_id','rentalcat_id','rental_status','action'])
            ->make(true);

            return $inactiverentals;
        }

        return view('Admin.Rental_houses.inactivatehouses',compact('inactiverentals'));
    }
}
