<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use App\Models\Room_name;
use App\Models\Rental_house;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class Userprofile_controller extends Controller
{
    public function myaccount($id)
    {
        if (Auth::user()->id == $id)
        {
            $userprofile=User::with('rentalhses','hserooms')->findOrFail($id);
            
            $activehousenames=Rental_house::select('rental_name','id')->where('rental_status',1)->get();
            
            $rmnames = Room_name::where(['rentalhouse_id'=>$userprofile->house_id,'status'=>1])->get();

            return view('Front.Tenant.tenantprofile',compact('userprofile','rmnames','activehousenames'));
        }
        else{
            abort(403);
        }
    }

    // get user details and show them in the edit form
    public function edituseraccount($id)
    {
        $edituserdetail=User::with(['hserooms','rentalhses'])->find($id);
        if($edituserdetail)
        {
            return response()->json([
                'status'=>200,
                'edituserdetail'=>$edituserdetail
            ]);
        }
    }

    // edit user details
    public function updateuserdetails(Request $request,$id)
    {
        $data=$request->all();

        $rules=[
            'phone'=>'numeric'
        ];

        $custommessages=[
            'phone.numeric'=>'Enter a Correct Phone Number',
        ];
        $this->validate($request,$rules,$custommessages);

        $user=User::find($id);
        $user->name=$data['fullname'];
        $user->email=$data['email'];
        $user->phone=$data['phonenumber'];
        $user->id_number=$data['id_number'];
        $user->house_id=$data['rentalhousename'];
        $user->save();

        $user->hserooms()->sync(request('getroomnamenumber'));
        // $user->tenantstatus()->sync(3);

        $message="Account Details have Been Updated Successfully!";
        Alert::Success('success',$message);
        return Redirect::back();
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
