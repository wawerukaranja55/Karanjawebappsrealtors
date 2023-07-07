<!DOCTYPE html>
<html>
   <head>
      @include('Front.headerlinks')
      <style>
         .whatsapp_chat{
            bottom: 30px;
            right:20px;
            position: fixed;
            z-index: 3;
         }

         .inputdetails label{
            font-size:15px;
         }

         .modal-lg{
            max-width: 85% !important;
         }

         .wrapper{
            min-height: 100%;
         }

         footer {
            background-color: orange;
            width: 100%;
            /* overflow: hidden; */
         }


      </style>
      @yield('403pagestyles')
      @yield('listingpagestyles')
      @yield('loginandregisterstyles')
      @yield('tenantdetailsstyles')
      @yield('homepagepagestyles')
   </head>
   <body>
      <?php use App\Models\Rental_house; ?>
      
      @include('Front.header')
      @include('sweetalert::alert')

      <div class="wrapper container">
         @yield('content')
      </div>
      <div class="whatsapp_chat">
         <a href="https://wa.link/dc5azf" target="_blank">
            <img src="{{ asset('imagesforthewebsite/icons/whatsapp.png') }}" alt="Chat with Our Admin" height="60px" width="60px">
         </a>
      </div>
      @include('Front.footer')

      {{-- User contact  Admin to Book a House --}}
      <div class="modal fade" id="contactadminmodal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="card-body">
                  <h5 class="card-title mb-4 request_title"></h5>
                  <form action="javascript:void(0)" id="hserequestform" method="POST"  class="form-horizontal" role="form" style="margin: 5px;">
                     <ul class="alert alert-warning d-none" id="error_list"></ul>
                     @csrf
                      <div class="control-group form-group">
                          <div class="controls">
                              <label>Your Name <span class="text-danger">*</span></label>
                              <input type="text" name="name" placeholder="Enter Your Name" class="yourname form-control" required>
                          </div>
                      </div>

                      <input type="hidden" name="hse_id" class="houseuserid" value="">

                      <div class="control-group form-group">
                          <div class="controls">
                              <label>Your Email <span class="text-danger">(Optional)</span></label>
                              <input type="text" name="email" placeholder="Enter Your Email" class="youremail form-control" required>
                          </div>
                      </div>
                      <div class="control-group form-group">
                          <div class="controls">
                              <label>Phone <span class="text-danger">*</span></label>
                              <input type="text" name="phone" placeholder="Enter Phone Number" class="yourphone form-control" required>
                          </div>
                      </div>
                      <div class="control-group form-group">
                        <div class="controls">
                           <label>Message <span class="text-danger">*</span></label>
                           <textarea name="msg_request" class="hsemsg_request form-control" style="height:200px; font-size:20px; color:black;"></textarea>
                        </div>
                     </div>
                      
                      <button type="submit" id="savemsgrqst" class="btn btn-primary btn-block">SEND REQUEST</button>
                  </form>
              </div>
            </div>
         </div>
      </div>
 
      <!-- ------- REGISTRATION ------- -->
      <div class="modal fade" id="signupmodal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <h3>Register An Account</h3>
                  <button type="button" class="close" data-dismiss="modal">
                     <span aria-hidden="true">×</span>
                     <span class="sr-only">Close</span>
                  </button>
               </div>
               <div class="modal-body">
                     <!-- Form Title -->
                     <div class="form-heading text-center">
                        <p class="title-description" style="font-size:13px;">Already have an account?
                           <a href="#" data-toggle="modal" style="color: black; font-size: 20px;" data-target="#LogInModal" data-dismiss="modal">Sign in.</a>
                        </p>
                        
                     </div>
                     <form action="javascript:void(0)" id="signupform" class="form-horizontal signupuser" role="form" method="POST">
                        @csrf
                        <div class="card padding-card product-card">
                           <div class="card-body">
                              <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Personal Details</h5>
         
                              <div class="row section-groups">
                                 <div class="form-group inputdetails col-sm-6">
                                    <label>Name<span class="text-danger inputrequired">*</span></label>
                                    <input type="text" class="form-control text-white bg-dark full_name" required name="name" placeholder="Write Your Full Name">
                                 </div>
         
                                 <div class="form-group inputdetails col-sm-6">
                                    <label>Phone Number<span class="text-danger inputrequired">*</span></label>
                                    <input type="number" class="form-control text-white bg-dark phone_number" name="phone" placeholder="Write Your Phone Number">
                                 </div>
                              </div>

                              <div class="row section-groups">
                                 <div class="form-group inputdetails col-sm-6">
                                     <label>Email<span class="text-danger inputrequired">*</span></label>
                                     <input type="email" class="form-control text-white bg-dark email" name="email" placeholder="Write Your Email here">
                                 </div>
                                 <div class="form-group inputdetails col-sm-6">
                                    <label>Id Number<span class="text-danger inputrequired">*</span></label>
                                    <input type="number" class="form-control text-white bg-dark id_number" name="id_number" id="modalid_number" placeholder="Write Your Id Number here">
                                </div>
                              </div>
                           </div>
                       </div>

                       <div class="card padding-card product-card">
                        <div class="card-body">
                           <h5 class="card-title mb-4" style="color: black; font-size:18px;">2.House Details</h5>

                           <div class="row section-groups">
                              <div class="form-group inputdetails col-sm-6" style="color: black; font-size:18px;">
                                  <label>House Name<span class="text-danger inputrequired">*</span></label><br>
                                  <select name="house_id" id="rentalhsenme" class="rentalhsename form-control text-white bg-dark" style="width:100%;">
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
                                 <select name="rentalroom_id[]" class="roomnamenumber form-control text-white bg-dark" required style="width: 100%;" multiple>
                                    
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
                               <input type="password" name="password" required autocomplete="current-password" id="signuppassword" placeholder="Write Your Password here" class="text-white bg-dark form-control">
                              <input type="checkbox" id="signupcheckpassword">Show Password
                           </div>
                        </div>
                        </div>
                        </div>
                        <ul class="alert alert-warning d-none update_errorlist"></ul>
                       <button type="submit" id="registerusermdal" class="btn btn-dark text-white">Register Your Account</button>
                     </form>
               </div>
            </div>
         </div>
      </div>
      <!-- ------- REGISTRATION Ends ------- -->

      <!-- ------- LOGIN ------- -->
      <div class="modal fade" id="LogInModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <h3>Sign In</h3>
                  <a href="#" data-toggle="modal" style="color: black; font-size: 15px;" data-target="#signupmodal" data-dismiss="modal" class="btn btn-danger pull-left">Register An Account</a>
                  
               </div>
               <div class="modal-body">
                  <form method="POST" action="{{ route('loginuser') }}">
                     @csrf
                     <div class="card padding-card product-card">
                        <div class="card-body">
                           <div class="row section-groups">
                              <div class="form-group inputdetails col-sm-6">
                                 <label>Email<span class="text-danger inputrequired">*</span></label>
                                 <input type="email" class="form-control text-white bg-dark" required name="email" placeholder="Write Your Email">
                              </div>
      
                              <div class="form-group inputdetails col-sm-6">
                                 <label>Password<span class="text-danger inputrequired">*</span></label>
                                 <input type="password" name="password" required autocomplete="current-password" id="showpassword" class="text-white bg-dark form-control">
                                 <input type="checkbox" id="checkpassword">Show Password
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
      <!-- ------- LOGIN Ends ------- -->

      <!-- ------- FORGOT FORM ------- -->
      <div class="modal fade" id="ForgotModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <h3>Reset Your Password</h3>
                     
                     <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                  </div>
                  <div class="modal-body">
                     <div class="title">Forgot Password?</div><br>
                     <p class="title-description">We'll email you a link to reset it.</p>
                     <form method="POST" action="{{ route('loginuser') }}">
                        @csrf
                        <div class="card padding-card product-card">
                           <div class="card-body">
                              <div class="row section-groups mx-auto">
                                 <div class="form-group inputdetails col-sm-9">
                                    <label>Email<span class="text-danger inputrequired">*</span></label>
                                    <input type="email" class="form-control text-white bg-dark" required type="email" name="email" placeholder="Write Your Email">
                                 </div>
                              </div>

                              <div class="row">
                                 <div class="col-md-12">
                                       <input type="hidden" name="current_page" value="{{Request::getRequestUri()}}">
                                 </div>
                              </div>

                              <div class="row section-groups">
                                 <div class="col-md-12 text-center">
                                       <button class="btn btn-md btn-danger">Send Mail</button>
                                 </div>
                              </div>

                           </div>
                       </div>
                     </form>
                  </div>
               </div>
            </div>
      </div>
      <!-- ------- FORGOT FORM ends ------- --> 

      {{-- deactivate a user --}}
      <div class="modal fade" id="deactivateaccountmodal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Deactivate Your Account</h5>
                </div>
               <div class="modal-body">
                  <h5 class="text-center adminmodallabel" id="custom-width-modalLabel">Are You Sure You Want To Deactivate your Account?You Wont be able to access your account anymore</h5>
                  <input type="hidden" name="useraccountid" class="useraccount_id">
                     <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <input class="deleteuseraccountbutton btn btn-lg" name="accountstatus" type="checkbox" checked data-toggle="toggle" data-id="1" data-on="Yes" data-onstyle="danger">
                     </div>
                  </form>
              </div> 
            </div>
         </div>
     </div>

      @include('Front.scriptlinks')

      @yield('registerpagescripts')
      @yield('tenantpagescript')
      @yield('listingpagescript')
      @yield('hsedetailspagescript')
      @yield('contactuspagescript')
      @yield('propertydetailsscript')
      @yield('propertylistingpagescript')
      @section('scripts')
      <script>
         // csrf token
         $(document).ready(function() {
            // csrf token
            $.ajaxSetup({
               headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
            });

            // hide alert message
            $("#msg").hide();
            $("#tenantstatusmsg").hide();

            // empty contact admin modal on closing it
            $("#contactadminmodal").on('hide.bs.modal', function(){
               $('.houseuserid').val('');
               $('.yourname').html('');
               $('.youremail').val('');
               $('.yourphone').val('');
               $('.hsemsg_request').val('');
            });

            // empty register modal on closing it
            $("#registerusermdal").on('hide.bs.modal', function(){
               $('.full_name').val('');
               $('.phone_number').val('');
               $('.email').val('');
               $('.id_number').val('');
               $('#rentalhsenme').val('');
               $('.roomnamenumber').val('');
               $('#signuppassword').val('');
            });
         });
         
         // show password on clicking a checkbox in login modal
         $('#checkpassword').click(function(){
               if(document.getElementById('checkpassword').checked) {
               $('#showpassword').get(0).type = 'text';
            } else {
                  $('#showpassword').get(0).type = 'password';
            }
         });
         // show password on clicking a checkbox in sign up modal
         $('#signupcheckpassword').click(function(){
               if(document.getElementById('signupcheckpassword').checked) {
               $('#signuppassword').get(0).type = 'text';
            } else {
                  $('#signuppassword').get(0).type = 'password';
            }
         });
         $(document).ready(function() {
            // ===========Hover Nav============	
            $('.navbar-nav li.dropdown').hover(function() {
               $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(500);
               }, function() {
               $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(500);
            });
            $('.roomnamenumber').select2();
            $('.rentalhsename').select2();
            $('.sortproperties').select2();
            $('.propertylocation').select2();
            $('.rntalhse').select2();
         });
         // prevent navbar scroll
         document.addEventListener("DOMContentLoaded", function(){
            window.addEventListener('scroll', function() {
               if (window.scrollY > 50) {
                  document.getElementById('navbar_top').classList.add('fixed-top');
                  // add padding top to show content behind navbar
                  navbar_height = document.querySelector('.navbar').offsetHeight;
                  document.body.style.paddingTop = navbar_height + 'px';
               } else {
                  document.getElementById('navbar_top').classList.remove('fixed-top');
                     // remove padding top from body
                  document.body.style.paddingTop = '0';
               } 
            });
         });
         
         // show rooms for a house on dropdown
         $(document).on('change','#rentalhsenme',function(){
            var hsetitle_id=$( "#rentalhsenme" ).val();
            var getroomsurl = '{{ route("getrooms.house") }}'; 
            $.ajax({
               type:'get',
               url:getroomsurl,
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

         // show register modal on clicking the sign up button
         $(document).on('click','#signup',function(){
            $('#signupmodal').modal('toggle');
         });

         // store the user details in the db
         $(document).on('submit','#signupform',function()
         {
            var usersignupurl = '{{ route("signup.modal") }}'; 
            var form = $('#signupform')[0];
            var formdata=new FormData(form);

            $.ajax({
               url:usersignupurl,
               method:'POST',
               processData:false,
               contentType:false,
               data:formdata,
               success:function(response)
               {
                  console.log(response);
                  if (response.status==400)
                  {
                     $('.update_errorlist').html(" ");
                     $('.update_errorlist').removeClass('d-none');
                     $.each(response.message,function(key,err_value)
                     {
                           $('.update_errorlist').append('<li>' + err_value + '</li>');
                     })
                  } 
                  else if (response.status==200)
                  {
                     alertify.set('notifier','position', 'top-right');
                     alertify.success(response.message);
                     $('.full_name').val('');
                     $('.phone_number').val('');
                     $('.email').val('');
                     $('.id_number').val('');
                     $('#rentalhsenme').val('');
                     $('.roomnamenumber').val('');
                     $('#signuppassword').val('');
                     $('#signupmodal').modal('hide');
                  }
                  else if (response.status==404)
                  {
                     alertify.set('notifier','position', 'top-right');
                     alertify.success(response.message);
                     $('#signupmodal').modal('hide');
                  }
               }
            });
         });
         
      </script>
   </body>
</html>