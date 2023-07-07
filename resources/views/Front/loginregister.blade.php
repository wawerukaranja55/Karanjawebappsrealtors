@extends('Front.frontmaster')
@section('title','Sign In/Sign Up Form')
@section('content')
@section('loginandregisterstyles')
    <style>
        /* input error */
        form.cmxform label.error, label.error {
            color: red;
            font-style: italic;
        }
    </style>
@stop
<?php use App\Models\Rental_house; ?>
    
      
    <div class="row">
         
        <div class="col-md-8 mx-auto" id="signupbox">
            <div class="panel-heading text-center mt-5">
                <div class="panel-title" style="font-size: 18px;">Sign Up For an Account</div>
            </div> 
            <div class="modal-content">
                
                <div class="modal-body">
                      <!-- Form Title -->
                      <div class="form-heading text-center">
                         <p class="title-description" style="font-size:13px;">Already have an account?
                            <a href="#" onClick="$('#signupbox').hide(); $('#loginbox').show()">
                                Log In Here
                            </a>
                         </p>
                         
                      </div>
                      <form method="POST" action="{{ route('registeruser') }}">
                         @csrf
                         <div class="card padding-card product-card">
                            <div class="card-body">
                               <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Personal Details</h5>
                               @if (Session::has('error_message'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ Session::get('error_message') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                               <div class="row section-groups">
                                  <div class="form-group inputdetails col-sm-6">
                                     <label>Name<span class="text-danger inputrequired">*</span></label>
                                     <input type="text" class="form-control text-white bg-dark" name="name" id="full_name" placeholder="Write Your Full Name">
                                  </div>
          
                                  <div class="form-group inputdetails col-sm-6">
                                     <label>Phone Number<span class="text-danger inputrequired">*</span></label>
                                     <input type="number" class="form-control text-white bg-dark" name="phone" id="Phone_number" placeholder="Write Your Phone Number">
                                  </div>
                               </div>
    
                               <div class="row section-groups">
                                  <div class="form-group inputdetails col-sm-6">
                                      <label>Email<span class="text-danger inputrequired">(Optional)</span></label>
                                      <input type="email" class="form-control text-white bg-dark" name="email" id="email" placeholder="Write Your Email here">
                                  </div>
                                  <div class="form-group inputdetails col-sm-6">
                                     <label>Id Number<span class="text-danger inputrequired">*</span></label>
                                     <input type="number" class="form-control text-white bg-dark" name="id_number" id="id_number" placeholder="Write Your Id Number here">
                                 </div>
                               </div>
                            </div>
                        </div>
    
                        <div class="card padding-card product-card">
                         <div class="card-body">
                            <h5 class="card-title mb-4" style="color: black; font-size:18px;">2.House Details</h5>
    
                            <div class="row section-groups">
                               <div class="form-group inputdetails col-sm-6">
                                   <label>House Name<span class="text-danger inputrequired">*</span></label>
                                   <select name="house_id" id="rentalhse" class="rentalhsename form-control text-white bg-dark" required>
                                    <option disabled selected>Select Your Rental House </option>
                                        <?php 
                                           $activehousenames=Rental_house::select('rental_name','id')->where(['rental_status'=>1,'is_vacancy'=>1])->get();
                                        ?>
                                        @foreach($activehousenames as $housename)
                                           <option value="{{ $housename->id }}">
                                              {{ $housename->rental_name }}</option>
                                        @endforeach
                                   </select>
                               </div>
       
                               <div class="form-group inputdetails col-sm-6">
                                  <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                  <br>
                                  <select name="rentalroom_id[]" multiple class="roomnamenumber form-control text-white bg-dark" required style="width: 100%;">
                                     {{-- <option value=" " disabled="true" selected="true">Select Your Room Name/Number</option> --}}
                                  </select>
                               </div>
                           </div>
    
                            <div class="row">
                               <div class="col-md-12">
                                  <input type="hidden" name="current_page" value="{{Request::getRequestUri()}}">
                               </div>
                            </div>
    
                           <div class="row section-groups">
                            <div class="form-group inputdetails col-sm-8">
                                <label>Password<span class="text-danger inputrequired">*</span></label>
                                <input type="password" name="password" autocomplete="current-password" id="signupshowpassword" placeholder="Write Your Password here" class="text-white bg-dark form-control">
                               <input type="checkbox" id="signupcheckpasswordform">Show Password
                            </div>
                         </div>
                         </div>
                         </div>
                        
                        <button type="submit" class="btn btn-dark text-white">Register Your Account</button>
                      </form>
                </div>
             </div>
        </div>
    
        <div class="col-md-8 mx-auto" id="loginbox">
            <div class="panel-heading text-center mt-5">
                <div class="panel-title" style="font-size: 18px;">Login To Your Account</div>
                <div class="form-heading text-center">
                    <p class="title-description" style="font-size:15px;">You don't have an account?
                        <a id="signinlink" href="#" onclick="$('#loginbox').hide(); $('#signupbox').show()">Click here to Sign Up</a>
                    </p>
                    
                 </div>
            </div> 
            <div class="modal-content">
                <div class="modal-body">
                    <form method="POST" action="{{ route('loginuser') }}">
                    @csrf
                    <div class="card padding-card product-card">
                        <div class="card-body">
                            <div class="row section-groups">
                                <div class="form-group inputdetails col-sm-6">
                                <label>Phone Number<span class="text-danger inputrequired">*</span></label>
                                <input type="number" class="form-control text-white bg-dark" required name="phone_number" placeholder="Write Your Phone Number">
                                </div>
        
                                <div class="form-group inputdetails col-sm-6">
                                <label>Password<span class="text-danger inputrequired">*</span></label>
                                <input type="password" name="password" required autocomplete="current-password" id="loginshowpassword" class="text-white bg-dark form-control">
                                <input type="checkbox" id="logincheckpasswordform">Show Password
                                </div>
                            </div>
    
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="current_page" value="{{Request::getRequestUri()}}">
                                </div>
                            </div>
    
                            <div class="row section-groups">
                                <div class="form-group inputdetails col-sm-6">
                                
                                </div>
        
                                <div class="form-group inputdetails col-sm-6">
                                <label><a href="#" data-toggle="modal" data-target="#ForgotModal" data-dismiss="modal">Forget Password?</a></label>
                                </div>
                            </div>
    
                            <div class="row section-groups">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-md btn-danger">Sign In</button>
                                </div>
                            </div>
    
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection 


    @section('registerpagescripts')
    <script type="text/javascript">
        $(document).ready(function(){

            // hide login box
            $('#loginbox').hide();

           // validate signup form on keyup and submit
            $(".registerform").validate({
                rules: {
                    name: "required",
                    phone: {
                        required: true,
                        minlength: 10,
                        maxlength:13,
                        digits:true
                    },
                    email: {
                        required: true,
                        email: true,
                        remote:"/check_email"
                    },
                    password: {
                        required: true,
                        minlength: 5
                    }
                },
                messages: {
                    name: "Please enter your Full Name",
                    phone: {
                        required: "Please enter your Phone Number",
                        minlength: "Your Phone Number must consist of at least 10 characters",
                        maxlength: "Your Phone Number should not exceed 10 characters",
                        digits: "Please Enter a Valid Phone Number"
                    },
                    email: {
                        required: "Please provide your Email Address",
                        email: "Please Enter your Valid Email Address",
                        remote: "The Email is already taken"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long"
                    },
                }
            }); 

            // show password on clicking a checkbox in login modal
            $('#logincheckpasswordform').click(function(){
                if(document.getElementById('logincheckpasswordform').checked) {
                $('#loginshowpassword').get(0).type = 'text';
                } else {
                    $('#loginshowpassword').get(0).type = 'password';
                }
            });
            // show password on clicking a checkbox in sign up modal
            $('#signupcheckpasswordform').click(function(){
                if(document.getElementById('signupcheckpasswordform').checked) {
                $('#signupshowpassword').get(0).type = 'text';
                } else {
                    $('#signupshowpassword').get(0).type = 'password';
                }
            });
        });



        // show rooms for a house on dropdown
        $(document).on('change','#rentalhse',function(){
            var hsetitle_id=$( "#rentalhse" ).val();
            var searchroomsurl = '{{ route("getrooms.house") }}'; 
            $.ajax({
               type:'get',
               url:searchroomsurl,
               data:{
                  'id':hsetitle_id
               },
               success:function(data){
                     console.log(data);
                     $('.roomnamenumber').html('<option disabled selected value=" ">Select Your Room Name/Number</option>');
                     
                     console.log("the data is ",data);
                     data.forEach((room)=>{
                        console.log(room);
                        $('.roomnamenumber').append('<option value="'+room.id+'">'+room.room_name+'</option>');
                     });
                     
               },error:function(){
               }
            });
         });


        // $(document).on('change','#rentalhse',function(){
        //     var hsetitle_id=$( "#rentalhse" ).val();
        //     $.ajax({
        //        type:'get',
        //        url:'getroomsforahouse',
        //        data:{
        //           'id':hsetitle_id
        //        },
        //        success:function(data){
                     
        //              console.log("the data is ",data);
        //              data.forEach((room)=>{
        //                 console.log(room);
        //                 $('.roomnamenumber').append('<option value="'+room.id+'">'+room.room_name+'</option>');
        //              });
                     
        //        },error:function(){
        //        }
        //     });
        // });
    </script>
@stop