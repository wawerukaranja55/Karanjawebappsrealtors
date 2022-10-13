<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use App\Models\Room_name;
use App\Models\Rental_house;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Rentalhousesize;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class Userprofile_controller extends Controller
{
    public function myaccount($id)
    {
        if (Auth::user()->id == $id)
        {
            $userprofile=User::with('rentalhses','hserooms')->find($id);

            foreach ($userprofile->hserooms as $hserms)
            {
                $hseprices[]=$hserms->roomsize_price;
            }

            $total_rent=array_sum($hseprices);
            // dd( $total_rent);die();
            // total amount of rent to pay
                // if (count($userprofile->hserooms)>1)
                // {
                //     if()
                //     {

                //     }
                // } 
                // else
                // {

                // }


            // if ($userprofile->rentalhses->is_addedtags==1)
            // {
            //     $total_rent=
            // }
            // else
            // {

            // }

            // if ($userprofile->rentalhses->is_addedtags==1)
            // {

            //     foreach ($userprofile->hserooms as $hserm) {
            //         $hseroom=$hserm->house_size;
            //     }
                 
            //     $hseroomprice = Room_name::where(['rentalhouse_id'=>$userprofile->house_id,'house_size'=>$hseroom])->pluck('roomsize_price')->first();
                
            // }else
            // {
            //     $hseroomprice=0;
            // }

            $activehousenames=Rental_house::select('rental_name','id')->where(['rental_status'=>1,'is_rentable'=>1])->get();
            
            $rmnames = Room_name::where(['rentalhouse_id'=>$userprofile->house_id,'status'=>1])->get();

            return view('Front.Tenant.tenantprofile',compact('userprofile','total_rent','rmnames','activehousenames'));
        }
        else{
            abort(403);
        }
    }

    // edit user details
    public function updateuserdetails(Request $request,$id)
    {
        $data=$request->all();
        
        $rules=[
            'name'=>'required',
            'phone'=>'required|regex:/(07)[0-9]/|digits:10',
            'email'=>'required',
            'id_number'=>'required|digits:8',
            'house_id'=>'required',
            'rentalroom_id'=>'required',
        ];

        $custommessages=[
            'name.required'=>'Kindly Write Your Name',
            'email.required'=>'Kindly Write Your Email',
            'id_number.required'=>'Kindly Write Your National Id Number',
            'id_number.digits:8'=>'Kindly Write National Id Number',
            'house_id.required'=>'Select Your House Name',
            'rentalroom_id.required'=>'Select Your Room name',
            'password.required'=>'Write Your Password',
            'phone.required'=>'Kindly Write Your Phone',
            'phone.regex'=>'Your Phone NUmber Should start with 07',
            'phone.digits:10'=>'The Phone NUmber Should not be less or more than 10 digits',
            'location_id.required'=>'The Category cant be blank.Select a Location'
        ];

        $validator = Validator::make( $data,$rules,$custommessages );
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'message'=>$validator->errors()
            ]);
        }else{
            $user=User::find($id);
            $user->name=$data['name'];
            $user->email=$data['email'];
            $user->phone=$data['phone'];
            $user->id_number=$data['id_number'];
            $user->house_id=$data['house_id'];
            $user->save();

            $user->hserooms()->sync(request('rentalroom_id'));
            $user->tenantstatus()->sync(3);
            $message="Account Details have Been Updated Successfully!";
            return response()->json([
                'status'=>200,
                'message'=>$message
            ]);
        }
    }

    public function changeprofileimg(Request $request)
    {
        $username=User::where('id',$request->tenant_id)->pluck('name')->first();

        $updateruserimg=User::find($request->tenant_id);


        if($updateruserimg->avatar =='default.jpg')
        {
            $tenantimg=$request->file('tenant_image');

            $tenantimgtmp=Image::make($tenantimg);
            $extension=$tenantimg->getClientOriginalExtension();
            $tenantimgname=$username.'-'.rand(111,9999).'.'.$extension;

            $tenantimg_path='imagesforthewebsite/usersimages/'.$tenantimgname;
            Image::make($tenantimgtmp)->resize(500,550)->save($tenantimg_path);

            $updateruserimg=User::find($request->tenant_id);
            $updateruserimg->avatar= $tenantimgname;
            $updateruserimg->save();

            return response()->json([
                'success'=>200,
                'message'=>'The image Has Been updated Successfully'
            ]);

        } elseif($updateruserimg->avatar){
            // delete the existing image
            $tenantimagesfolder = Storage::path($updateruserimg->avatar);
            $tenantimagesfolder='imagesforthewebsite/usersimages/'.$updateruserimg->avatar;
            unlink($tenantimagesfolder);

            File::delete($tenantimagesfolder);

            User::destroy($updateruserimg->avatar);

            // update the image
            $tenantimg=$request->file('tenant_image');

            $tenantimgtmp=Image::make($tenantimg);
            $extension=$tenantimg->getClientOriginalExtension();
            $tenantimgname=$username.'-'.rand(111,9999).'.'.$extension;

            $tenantimg_path='imagesforthewebsite/usersimages/'.$tenantimgname;
            Image::make($tenantimgtmp)->resize(500,550)->save($tenantimg_path);

            $updateruserimg=User::find($request->tenant_id);
            $updateruserimg->avatar= $tenantimgname;
            $updateruserimg->save();

            return response()->json([
                'success'=>200,
                'message'=>'The image Has Been updated Successfully'
            ]);
        }
    }

    // check current password
    public function checkcurrentpwd(Request $request)
    {
        $data=$request->all();
        if(Hash::check($data['currentpwd'],Auth::user()->password))
        {
            echo "true";
        } else {
            echo "false";
        }
    }

    // update password
    public function update_password(Request $request)
    {
        $data=$request->all();

        if(Hash::check($data['currentpwd'],Auth::user()->password))
        {
            if($data['newpwd']==$data['confirmpwd'])
            {
                User::where('id',Auth::user()->id)->update(['password'=>bcrypt($data['newpwd'])]);

                $message="Your Account Password have Been Updated Successfully!";
                Alert::Success('success',$message);
            }
        } else {
            $message="Your New Password and Confirmed Password Doesnt Match!";
            Alert::Success('error',$message);
        }

        return Redirect::back();
    }

    // deactivate user account
    // public function deactivateaccount(Request $request)
    // {
    //     $useraccountstatus=User::find($request->useraccountid);
    //     $useraccountstatus->is_approved=$request->accountstatus;
    //     $useraccountstatus->save();

    //     Auth::logout();

    //     return response()->json([
    //         'message'=>'Your Account Has been Deactivated Successfully.Contact the admin For your to access your account',
    //         'url'=>url('/')
    //     ]);
    // }
}
