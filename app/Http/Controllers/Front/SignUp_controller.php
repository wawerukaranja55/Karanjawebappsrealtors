<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class SignUp_controller extends Controller
{
    public function login_register(){

        
        return view('Front.loginregister');
    }

    public function registeruser(Request $request){
        $data=$request->all();

        $usercount=User::where('id_number',$data['id_number'])->count();
        if($usercount>0){
            $message="Your Account Already Exists for Another User";
            Session::flash('error_message',$message);
            Session::forget('success_message');
            return Redirect::back();
        }else{
            $user=new User;
            $user->name=$data['fullname'];
            $user->email=$data['email'];
            $user->phone=$data['phonenumber'];
            $user->id_number=$data['id_number'];
            $user->house_id=$data['rentalhousename'];
            $user->password=bcrypt($data['password']);
            $user->save();

            $user->hserooms()->attach(request('getroomnamenumber'));
            $user->tenantstatus()->attach(3);
            $user->roles()->attach(7);

            $message="Welcome to Jamar House Agents.Your Account will be Activated in a short while and you will be able to login.";
            Alert::Success('success',$message);
            return Redirect::back();
        }   
    }

    // check whether an email exist in the users table when registering usingjavascript
    public function check_email(Request $request)
    {
        $data=$request->all();
        $emailcount=User::where('email',$data['email'])->count();

        if($emailcount>0){
            return "false";
        }else{
            return "true";
        }

    }

    public function loginuser(Request $request)
    {
        $data=$request->all();
        Session::forget('error_message');
        Session::forget('success_message');

        if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
            
            $this->validate($request,
            [
                'email'=> 'required|max:255|email',
                'password'=> 'required',
                
            ]);

            $userStatus = Auth::User()->is_approved;
            if($userStatus==1) {
                $message="You have Successfully Logged In To Your Account";
                Alert::Success('success',$message);
                return Redirect::back();
            }else{
                Auth::logout();
                $message="Your Account hasnt been Activated.Please contact the admin";
                Alert::error('error',$message);
                return Redirect::back();
            }
        }
        else {

            $message="Invalid Email or Password";
            Alert::error('error',$message);
            return redirect()->back();
        }
    
    }

    public function logoutuser(){
        Auth::logout();
        return redirect()->back();
    }

    public function forgotpassword(Request $request){
        $data=$request->all();

        $emailcount=User::where('email',$data['email'])->count();

        if($emailcount>0)
        {
            $message="Email Doesn't Exists";
            Session::put('error_message',$message);
            Session::forget('success_message');

            return redirect()->back();
        }

        $random_password= Str::random(8);
        $new_password=bcrypt($random_password);

        $new_password=bcrypt($random_password);

        User::where('email',$data['email'])->update(['password'=>$new_password]);
        $username=User::select('name')->where('email',$data['email'])->first();

        $email=$data['email'];
        $name=$username->name;
        $messagedata=['email'=>$email,'name'=>$name,'password'=>$random_password];

        Mail::send('emails.forgotpass', $messagedata, function ($message) use($email) {
            $message->to($email)->subject('New Password for your Account');
        });

        $message="Please check your email for new password";
        Session::put('success_message',$message);
        Session::forget('error_message');
        return redirect('/loginuser');
    }

    // Update rooms for a user
    public function updateroomsforahouse(Request $request)
    {
        // dd($request->all());
        $roomsforahouse=Room_name::where(['rentalhouse_id'=>$request->id,'status'=>1,'is_occupied'=>0])->select('room_name','id')->get();

        return response()->json($roomsforahouse);

    }
}
