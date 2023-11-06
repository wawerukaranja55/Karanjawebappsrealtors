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
        
        $rules=[
            'name'=>'required',
            'phone'=>'required|regex:/(07)[0-9]/|digits:10',
            'id_number'=>'required|digits:8',
            'house_id'=>'required',
            'rentalroom_id'=>'required',
            'password'=>'required',
        ];

        $custommessages=[
            'name.required'=>'Kindly Write Your Name',
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
            return redirect()->back()->withErrors($validator);;
        }else{
            $usercount=User::where('id_number',$data['id_number'])->count();
            if($usercount>0){
                $message="Your Account Already Exists for Another User";
                Session::flash('error_message',$message);
                Session::forget('success_message');
                return Redirect::back();
            }else{
                
                if ( empty($data['email']) ) 
                { 
                    $useremail = NULL;
                } else {
                    $useremail = $data['email'];
                }

                $user=new User;
                $user->name=$data['name'];
                $user->email=$useremail;
                $user->phone=$data['phone'];
                $user->id_number=$data['id_number'];
                $user->house_id=$data['house_id'];
                $user->password=bcrypt($data['password']);
                $user->save();

                $user->hserooms()->attach(request('rentalroom_id'));
                $user->tenantstatus()->attach(3);
                $user->roles()->attach(8);

                $message="Welcome to W.Karanja Apps.Your Account will be Activated in a short while and you will be able to login.";
                Alert::Success('success',$message);
                return redirect('/');
            //     return Redirect::back();
            }
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
                'email'=> 'required',
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

    public function signupwithmodal(Request $request){
        $data=$request->all();

        $rules=[
            'name'=>'required',
            'phone'=>'required|regex:/(07)[0-9]/|digits:10',
            //'email'=>'required|unique:users|email',
            'id_number'=>'required|digits:8',
            'house_id'=>'required',
            'rentalroom_id'=>'required',
            'password'=>'required',
        ];

        $custommessages=[
            'name.required'=>'Kindly Write Your Name',
            //'email.required'=>'Kindly Write Your Email',
            'email.unique'=>'The Email Already Exists For another user',
            'email.email'=>'The Input should be an email',
            'id_number.required'=>'Kindly Write Your National Id Number',
            'id_number.digits:8'=>'Kindly Write National Id Number',
            'house_id.required'=>'Select Your House Name',
            'rentalroom_id.required'=>'Select Your Room name',
            'password.required'=>'Write Your Password',
            'phone.required'=>'Kindly Write Your Phone',
            'phone.regex'=>'Your Phone NUmber Should start with 07',
            'phone.digits:10'=>'The Phone NUmber Should not be less or more than 10 digits',
            'location_id.required'=>'The Location cant be blank.Select a Location'
        ];

        $validator = Validator::make( $data,$rules,$custommessages );
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'message'=>$validator->errors()
            ]);
        }else{
            $usercount=User::where('id_number',$data['id_number'])->count();
            if($usercount>0){
                $message="The Account Already Exists for Another User";
                return response()->json([
                    'status'=>404,
                    'message'=>$message
                ]);
            }else{

                if ( empty($data['email']) ) 
                { 
                    $useremail = NULL;
                } else {
                    $useremail = $data['email'];
                }

                $user=new User;
                $user->name=$data['name'];
                $user->email=$useremail;
                $user->phone=$data['phone'];
                $user->id_number=$data['id_number'];
                $user->house_id=$data['house_id'];
                $user->password=bcrypt($data['password']);
                $user->save();

                $user->hserooms()->attach(request('rentalroom_id'));
                $user->tenantstatus()->attach(3);
                $user->roles()->attach(8);

                $message="Welcome to W.Karanja apps.Your Account will be Activated in a short while and you will be able to login.";
                return response()->json([
                    'status'=>200,
                    'message'=>$message
                ]);
            }
        }
    }
}
