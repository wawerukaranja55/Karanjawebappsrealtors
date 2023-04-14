<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>
         @yield('title','Admin Layout')
       </title>
      {{-- bootstrap cdn --}}
      {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"> --}}

      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/css/bootstrap.min.css') }}"/>
      {{-- fontawesome cdn --}}
      {{-- <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/css/all.min.css') }}"/> --}}
      
      {{-- fonawesome  --}}
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

      {{-- <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/css/all.min.css') }}"/> --}}
      {{-- animate css styles --}}
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/css/animate.css') }}"/>
      {{-- css style for the admin panel --}}
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/css/style.css') }}"/>

      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/bootstrap-togglemin/bootstrap-toggle.css') }}"/>
      {{-- icon for our website --}}
      <link rel="icon" type="image/png" href="{{ asset('imagesforthewebsite/webicon.png') }}">

      {{-- css for datatables --}}
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/datatables/DataTables-1.10.25/css/jquery.dataTables.min.css') }}"/>
      {{-- <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/datatables/DataTables-1.10.25/css/dataTables.bootstrap.min.css') }}"/> --}}
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/datatables/FixedHeader-3.1.9/css/fixedHeader.bootstrap.min.css') }}"/>
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/datatables/Responsive-2.2.9/css/responsive.bootstrap.min.css') }}"/>
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/datatables/Buttons-1.7.1/css/buttons.bootstrap4.min.css') }}"/>
      

      {{-- css for jquery ui --}}
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/plugins/jquery-ui/jquery-ui.css') }}"/>
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/plugins/jquery-ui/themesbasejquery-ui.css') }}"/>
      
      {{-- select2 --}}
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/select2/select2.min.css') }}"/>


      {{-- animate css styles --}}
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/css/plugins/dropzone/dropzone.min.css') }}"/>

      {{-- alertify --}}
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/alertifyjs/css/alertify.min.css') }}"/>
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/alertifyjs/css/themes/default.min.css') }}"/>
      
      


                           {{-- css cdn links --}}

       {{-- select2 
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>

       {{-- fonawesome 
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

       <!--  Switch buttons  -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.css"/>

       {{-- dropzone js
       <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" rel="stylesheet" />

       {{-- datatables 
      <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.4/css/fixedHeader.bootstrap.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css"> --}}

      <style>
         #wrapper{display:none;}
         #loader{
            background-color: #ffffff;
            opacity: 0.6;
            position: absolute;
            margin: auto;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            width: 400px;
            height: 400px;
         }

         #loader img{width:400px;}


         /* input error */
         form.cmxform label.error, label.error {
             color: red;
             font-style: italic;
         }

         .inputdetails{
            text-align: center; 
            font-size:15px; 
            color: black;
         }

         .inputrequired{
            font-size:20px;
         }

         .product-card{
            margin: 3px 0px;
         }

         .section-groups{
            box-shadow: 2px 2px 2px 3px #44c6dd;
            padding: 5px;
            margin-top: 2px;
         }

         .modal-lg{
            max-width: 90% !important;
         }
     </style>
     @yield('customcssstyles')
     @yield('admindashboardstyles')
     @yield('allpropertiesstyles')
     @yield('addpropertyimagesstyles')
     @yield('addimagesandroomsstyles')
   </head>
   <body>
      <?php use App\Models\Role; 
         $allroles=Role::where('status',1)->get();
      ?>

      <?php use App\Models\Rental_tags; 
         $allrentaltags=Rental_tags::where('status',1)->get();
      ?>

      <?php use App\Models\Location; 
         $allrentallocations=Location::where('status',1)->get();
      ?>

      <?php use App\Models\Vacancy_status; 
         $allvacancystatus=Vacancy_status::where('status',1)->get();
      ?>

      <?php use App\Models\Tenantstatus; 
         $alltenantstatuses=Tenantstatus::where('status',1)->get();
      ?>

      <?php use App\Models\Rental_category; 
         $allrentalcategories=Rental_category::where('status',1)->get();
      ?>

      <?php use App\Models\Propertycategory; 
         $allpropertycategories=Propertycategory::where('status',1)->get();
      ?>

      <?php use App\Models\User;
          $alllandlords=User::where(['is_landlord'=>1,'is_approved'=>1])->get();
      ?>

      <?php use App\Models\Rental_house; ?>


      <div id="loader" style="width: 100vw; height:100%; display:flex; justify-content:center;">
         <img src="{{ asset ('imagesforthewebsite/icons/loader.gif') }}">
      </div>
      <div id="wrapper">
         <nav class="navbar-default navbar-static-side" role="navigation">
            @include('Admin.adminsidebar')
         </nav>
         <div id="page-wrapper" class="white-bg">
            <div class="row border-bottom">
                @include('Admin.adminnavbar')
            </div>
            @yield('content')
            <div class="content-wrapper">
            
            </div>
            {{-- @include('Admin.adminfooter') --}}
         </div>
         @include('Admin.adminrightsidebar')
      </div>

      {{-- Add/edit tenant status modal--}}
      <div class="modal fade tenantstatusmodal" id="tenantstatusmodalmodal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" >
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title text-center tenantstatus_title" style="text-align: center;" id="custom-width-modalLabel"></h4>
               </div>
               <div class="modal-body">
                     {{-- Edit Property Details --}}
                     <div class="row" id="tenantstatusdata" style="margin:5px;">
                        <div class="col-md-12">
                           <form action="javascript:void(0)" class="form-horizontal tenantstatus_form" method="POST">
                              @csrf
                              <input type="hidden" id="rentalhouseid">
                              <div class="card padding-card product-card">
                                    <div class="card-body">
                                       <div class="row section-groups">
                                          <div class="form-group inputdetails col-sm-12">
                                             <label>Tenant Status Title<span class="text-danger inputrequired">*</span></label>
                                             <input type="text" class="form-control text-white bg-dark" required name="tenatstatustitle" id="tenatstatus_title" placeholder="Write a new Tenant Status here">
                                          </div>
                                       </div>
                                    </div>
                              </div>
                              
                              <button type="submit"  class="btn btn-success">Submit</button>
                           </form>
                        </div>
                     </div>
               </div> 
            </div>
         </div>
      </div>

      {{-- activate or dectivate a user account modal--}}
      <div class="modal fade tenantaccount" id="tenantaccountmodal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-body">
                  <div class="modal-header">
                     <h4 class="modal-title text-center" id="custom-width-modalLabel"></h4>
                  </div>
                  <form action="{{ route('rental_houses.store') }}" class="form-horizontal" role="form" method="POST" enctype="multipart/form-data">
                     @csrf
                     <div class="card padding-card product-card">
                         <div class="card-body">
                             <h5 class="card-title mb-4" style="color: black; font-size:18px;">Change Account Status</h5>
            
                             <div class="row section-groups">
                              <input type="text" class="form-control text-white bg-dark" required name="tenantaccountstatus" id="rental_name" placeholder="Write The Rental House Name">
            
                                 <div class="form-group inputdetails col-sm-6">
                                    <label>Tenant Account Statuses<span class="text-danger inputrequired">*</span></label>
                                    <select name="rentalhouselocation" class="form-control text-white bg-dark" required select2>
                                        <option class="disabled">Choose An Account Status</option>
                                        @foreach($alltenantstatuses as $accountstatus)
                                            <option value="{{ $accountstatus['id'] }}"
                                                @if (!empty (@old('is_approved')) && $accountstatus->id==@old('is_approved'))
                                                    selected=""    
                                                @endif>{{ $accountstatus->accountstatus_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                             </div>
                             <button type="submit" class="btn btn-success">Submit</button>
                         </div>
                     </div>
                 </form>
              </div> 
            </div>
         </div>
     </div>

     {{--edit details to the db--}}
      <div class="modal fade adminedit" id="admineditmodal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-body">
                  <div class="modal-header">
                     <h4 class="modal-title text-center" id="custom-width-modalLabel"></h4>
                  </div>
                  <form action="javascript(0)" method="POST" class="adminedit_form">
                     {{-- @csrf --}}
                     <input type="hidden" name="propertycat_id" id="propertycat_id">
                     <input type="hidden" name="rentaltag_id" id="rentaltag_id">
                     <input type="hidden" name="location_id" id="location_id">
                     <input type="hidden" name="roomid" id="room_id">
                     <input type="hidden" name="rolenameid" class="rolename_id">
                     <input type="hidden" name="transactiontypeid" class="transactiontype_id">

                     <div class="modal-body">
                        
                        <div class="row section-groups">
                           <div class="form-group inputdetails col-sm-12">
                              <label for="property_category" class="catlabel"></label>
                              <input type="text" class="form-control text-white bg-dark catinput" name="property_category" id="property_category" required>
                              <input type="text" class="form-control text-white bg-dark" name="rentaltagname" id="rental_tagname" required>
                              <input type="text" class="form-control text-white bg-dark" name="locationname" id="location_name" required>
                              <input type="text" class="form-control text-white bg-dark" name="roomname" id="editroom_name" readonly=''>
                              <input type="text" class="form-control text-white bg-dark" name="transactiontypename" id="transactiontype_name" required>
                           </div>
                        </div>

                        <div class="row section-groups" id="editchangeroomsize_price">
                           <div class="form-group inputdetails col-sm-12">
                              <label for="editroomsize_price" id="editroomsizelabel">Room Size Price</label>
                              <input type="number" class="form-control text-white bg-dark" name="roomsize_price" id="editroomsize_price" required>
                           </div>
                        </div>

                        <div class="row section-groups" id="editchangeroomsizes">
                           <div class="form-group inputdetails col-sm-12">
                                 <label>Change Room Size<span class="text-danger inputrequired">*</span></label>
                                 <select name="rentalhousermsize" id="editselectrmsize" class="adminselect2 form-control text-white bg-dark" style="width:100%;">
                                </select>
                           </div>
                        </div>
                        
                     </div>
                     
                     <ul class="alert alert-warning d-none" id="edit_list"></ul>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="button" class="save_button btn btn-danger waves-effect"></button>
                     </div>
                  </form>
            </div> 
            </div>
         </div>
      </div> 

         {{-- Modal For Editing the house details --}}
      <div class="modal fade editrentalhse" id="editrentalhsedetailsmodal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" >
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-body">
                     {{-- Edit Property Details --}}
                     <div class="row" id="edithousedata" style="margin: 100px 5px;">
                        <div class="mx-auto" style="text-align: center; font-size:18px; background-color:black;
                           display: flex;
                           justify-content: center; padding:5px;"> 
                           <h3 class="mb-2 panel-title text-white edit_title"></h3> 
                        </div>
                        <form action="javascript:void(0)" id="updatehsesform" class="form-horizontal updaterentaldetails" role="form" method="POST" enctype="multipart/form-data">
                           @csrf
                           <input type="hidden" id="rentalhouseid">
                           <div class="card padding-card product-card">
                                 <div class="card-body">
                                    <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Rental Description</h5>

                                    <div class="row section-groups">
                                       <div class="form-group inputdetails col-sm-6">
                                             <label>Rental Name<span class="text-danger inputrequired">*</span></label>
                                             <input type="text" class="form-control text-white bg-dark" required name="rental_name" id="rental_title"
                                             >
                                       </div>

                                       <div class="form-group inputdetails col-sm-6">
                                             <label>Rental Monthly Price<span class="text-danger inputrequired">*</span></label>
                                             <input type="number" class="form-control text-white bg-dark" required name="monthly_rent" id="monthly_rent">
                                       </div>
                                    </div>
                                    <div class="row section-groups">
                                       <div class="form-group inputdetails col-sm-12">
                                          <label>Rental Details<span class="text-danger inputrequired">*</span></label>
                                          <div id="rental_details_ck" style="border:2px solid black;">
                                          </div>
                                       </div>
                                    </div>
                                    
                                    <div class="row section-groups">
                                       <div class="form-group inputdetails col-sm-6">
                                          <label>Rental Name Slug<span class="text-danger inputrequired">*</span></label>
                                          <input type="text" class="form-control text-white bg-dark" required name="rental_slug" id="rental_slug"
                                          >
                                       </div>

                                       <div class="form-group inputdetails col-sm-6">
                                          <label>Rental category<span class="text-danger inputrequired">*</span></label>
                                          <select name="rentalhousecategory" class="rentalselectcat form-control text-white bg-dark" style="width:100%;"> 
                                             @foreach($allrentalcategories as $category)
                                                <option value="{{ $category->id }}">{{ $category->rentalcat_title }}
                                                </option>
                                             @endforeach  
                                          </select>
                                       </div>
                                    </div>

                                    <div class="row section-groups">
                                       <div class="form-group inputdetails col-sm-6">
                                             <label>Rental Location<span class="text-danger inputrequired">*</span></label>
                                             <select name="rentalhouselocation" class="rentalhselocation form-control text-white bg-dark" required style="width:100%;">
                                                @foreach($allrentallocations as $location)
                                                   <option value="{{ $location->id }}">{{ $location->location_title }}
                                                   </option>
                                                @endforeach
                                             </select>
                                       </div>

                                       <div class="form-group inputdetails col-sm-6">
                                          <label>Rental House Address<span class="text-danger inputrequired">*</span></label>
                                          <input type="text" class="form-control text-white bg-dark" required name="rental_address" id="rental_address">
                                      </div>
                                    </div>

                                    <div class="row section-groups">
                                       <div class="form-group inputdetails col-sm-12">
                                             <label for="rental_tags" class="control-label">Add tags for the rental house</label>
                                             <br>
                                             <select name="rentaltags[]" class="form-control text-white bg-dark rentaltagselect2" multiple="multiple" style="width:100%;">
                                                @foreach($allrentaltags as $tag)
                                                   <option value="{{ $tag->id }}"
                                                         {{-- {{ ($rentaldata->housetags()->pluck('rentaltag_title')->contains($tag->rentaltag_title)) ? 'selected' : '' }} --}}
                                                   >{{  $tag->rentaltag_title }}</option>
                                                @endforeach
                                             </select>
                                       </div>
                                    </div>

                                    <div class="row section-groups">
                                       <div class="form-group inputdetails col-sm-3">
                                             <label>Total No. of houses/rooms<span class="text-danger inputrequired">*</span></label>
                                             <input type="number" id="totalrooms" class="form-control text-white bg-dark" required name="total_rooms">
                                       </div>

                                       <div class="form-group inputdetails col-sm-3">
                                          <div class="custom-control custom-checkbox" style="margin-top: 10px;">
                                              <input type="checkbox" class="custom-control-input editcheckbox" name="edit_is_featured" value="yes" id="osahan-checkbox">
                                              <label class="custom-control-label" for="osahan-checkbox">Featured</label>
                                          </div>
                                      </div>

                                      <div class="form-group inputdetails col-sm-6">
                                       <label>House Owner(Landlord/Landlady)<span class="text-danger inputrequired">*</span></label>
                                       <select name="landlord_id" class="hseownerselect adminselect form-control text-white bg-dark" style="width:100%;"> 
                                          @foreach($alllandlords as $landlord)
                                             <option value="{{ $landlord->id }}">{{ $landlord->name }}
                                             </option>
                                          @endforeach  
                                       </select>
                                    </div>
                                    </div>
                                 </div>
                           </div>

                           <div class="card padding-card product-card">
                                 <div class="card-body">
                                    <h5 class="card-title mb-4" style="color: black; font-size:18px;">2.Rental Files</h5>
                                    
                                    <div class="row section-groups">
                                       <div class="col-md-6 inputdetails">
                                             <h5 class="card-title mb-4">Rental House Profile Image</h5>
                                             <div id="rentalimg">
                                                <img style="width: 80px;" src='' id="showimage">&nbsp;
                                                <input type="file" name="rental_image" accept="image/*">
                                                <input type="hidden" name="rental_image" class="rentalhseimage"/>
                                                <span class="font-italic">Recommended size:width  1040px by height 1200px</span>
                                             </div>
                                             
                                       </div>
                                    </div>
                                 </div>
                           </div>

                           <div class="card padding-card product-card">
                              <div class="card-body">
                                 <h5 class="card-title mb-4" style="color: black; font-size:18px;">3.Rental House Amenities</h5>
                                 <div class="row section-groups">
                                    <div class="col-md-4 inputdetails" style="text-align: left; color:black;">
                                       <div class="custom-control custom-checkbox">
                                          <input type="checkbox" class="custom-control-input editcheckbox wifi" name="edit_wifi" value="yes" id="osahan-checkbox6">
                                          <label class="custom-control-label" for="osahan-checkbox6">WIFI</label>
                                       </div>
                                       <div class="custom-control custom-checkbox">
                                          <input type="checkbox" class="custom-control-input editcheckbox generator" name="edit_generator" value="yes" id="osahan-checkbox1">
                                          <label class="custom-control-label" for="osahan-checkbox1">BACKUP GENERATOR</label>
                                       </div>
                                       <div class="custom-control custom-checkbox">
                                          <input type="checkbox" class="custom-control-input editcheckbox balcony" name="edit_balcony" value="yes" id="osahan-checkbox2">
                                          <label class="custom-control-label" for="osahan-checkbox2">BALCONY</label>
                                       </div>
               
                                       <div class="custom-control custom-checkbox">
                                          <input type="checkbox" class="custom-control-input editcheckbox parking" name="edit_parking" value="yes" id="osahan-checkbox3">
                                          <label class="custom-control-label" for="osahan-checkbox3">PARKING</label>
                                       </div>
                                    </div>
                                    <div class="col-md-4 inputdetails" style="text-align: left">
                                          <div class="custom-control custom-checkbox">
                                             <input type="checkbox" class="custom-control-input editcheckbox cctv_cameras" name="edit_cctv_cameras" value="yes" id="osahan-checkbox4">
                                             <label class="custom-control-label" for="osahan-checkbox4">CCTV SECURITY CAMERAS</label>
                                          </div>
                                          <div class="custom-control custom-checkbox">
                                             <input type="checkbox" class="custom-control-input editcheckbox servant_quarters" name="edit_servant_quarters" value="yes" id="osahan-checkbox5">
                                             <label class="custom-control-label" for="osahan-checkbox5">SERVANT QUARTERS</label>
                                          </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <button type="submit"  class="btn btn-success">Update Rental Details</button>
                           <ul class="alert alert-warning d-none update_errorlist"></ul>
                        </form>
                     </div>
               </div> 
            </div>
         </div>
      </div>

            {{--Update a rental category--}}
      <div class="modal fade rentalhsecategory" id="rentalhsecategorymodal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-body">
                  <div class="modal-header">
                     <h4 class="modal-title text-center" id="custom-width-modalLabel"></h4>
                  </div>
                  <form action="javascript(0)" method="POST" class="updatepropertcat_form">
                     {{-- @csrf --}}
                     <input type="hidden" name="rentalhsecat_id" id="rentalhsecat_id">
                     <input type="hidden" name="propertycat_id" id="propertycategory_id">

                     <div class="modal-body">
                        <div class="form-group">
                           <label for="rentalhse_category" class="catlabel h4">Rental House Category:</label>
                           <input type="text" class="form-control text-white bg-dark catinput" name="rentalhsecategory" id="rentalhse_category" required>
                        </div>
                     </div>
                     <div class="modal-body">
                        <div class="form-group">
                           <label for="rentalhsecategory_slug" class="catsluglabel h4">Rental House Slug:</label>
                           <input type="text" class="form-control text-white bg-dark catsluginput" name="rentalcategoryslug" id="rentalcategory_slug" required>
                        </div>
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="button" class="update_button btn btn-danger waves-effect">Update Rental Category</button>
                     </div>
                  </form>
              </div> 
            </div>
         </div>
     </div> 

            {{-- delete modal for the admin panel--}}
      <div class="modal fade admindeletemodal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title"></h5>
                </div>
               <div class="modal-body">
                  <h4 class="text-center adminmodallabel" id="custom-width-modalLabel"></h4>
                  <input type="hidden" name="rentaltag_id" class="rentaltag_id">
                  <input type="hidden" name="userrole_id" class="userrole_id">
                  <input type="hidden" name="roomname_id" class="roomname_id">
                  <input type="hidden" name="xtraimg_id" id="xtraimg_id">
                  <input type="hidden" name="housevideo_id" id="housevideo_id">
                  <input type="hidden" name="propertyvideo_id" id="propertyvideo_id">
                  <input type="hidden" name="locationid" id="locatn_id">
                  <input type="hidden" name="propertyimageid" id="propertyimage_id">
                  <input type="hidden" name="transactiontype_id" id="transactiontypid">
                  {{-- <h4>Are You Sure You Want to Delete?</h4> --}}
                     <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" id="deletemodalbutton" class="btn btn-danger waves-effect remove-category">Delete This Record</button>
                     </div>
                  </form>
              </div> 
            </div>
         </div>
     </div>

            {{-- modal to assign role to an admin--}}
      <div class="modal fade" id="assignadminmodal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-body" style="
               box-shadow: 2px 2px 4px #000000">
                  <form id="assignadminarole" method="POST" action="javascript:void(0);">
                     @csrf
                     <div class="modal-body">
                        <h4>Assign an Admin another Role</h4>
                        <input type="hidden" name="adminrole_id" id="adminrole_id">

                        <div class="form-group">
                           <label style="font-size:15px;">Name</label>
                           <input type="text" class="read-only form-control" name="name" id="edit_name">
                       </div>
                       <div class="form-group">
                           <label style="font-size:15px;">Admin Roles</label><br>
                           <select name="selectname" id="roleid" class="adminselect2 form-control text-white bg-dark" required style="width: 100%;">
                              <option disabled>Assign A user a different Role</option>
                              @foreach ($allroles as $role)
                                 <option value="{{ $role->id }}">
                                    {{ $role->role_name }}
                                 </option>
                              @endforeach
                           </select>
                       </div>
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger waves-effect assign_role_toadmin">Update</button>
                     </div>
                  </form>
              </div> 
            </div>
         </div>
      </div>

            {{-- modal to activate user upon registering --}}
      <div class="modal fade" id="activateusermodal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-body" style="
               box-shadow: 2px 2px 4px #000000">
                  <form id="activateuserform" method="POST" action="javascript:void(0);">
                     @csrf
                     <div class="modal-body">
                        <h4>Accept/Reject A User Registration</h4>
                        <input type="hidden" name="tenantuser_id" id="tenantuser_id">

                        <div class="form-group">
                           <label style="font-size:15px;">Tenant Name</label>
                           <input type="text" readonly=" " class="form-control" name="tenantname" id="tenant_name">
                       </div>
                       <div class="form-group">
                           <label style="font-size:15px;">Tenant Statuses</label>
                           <select name="tenantstatname" id="tenantstat_id" class="form-control text-white bg-dark" required>
                              <option disabled>Assign A New Status For the Tenant</option>
                              @foreach ($alltenantstatuses as $status)
                                 <option value="{{ $status->id }}">
                                    {{ $status->tenantstatus_title }}
                                 </option>
                              @endforeach
                           </select>
                       </div>
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" id="activatetenant" class="btn btn-danger waves-effect">Update</button>
                     </div>
                  </form>
              </div> 
            </div>
         </div>
      </div>

         {{-- modal to edit properties --}}
      <div class="modal fade" id="editpropertydetailsmodal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" >
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-body">
                     {{-- Edit Property Details --}}
                     <div class="row" id="editpropertydata" style="margin: 100px 5px;">
                        <div class="mx-auto" style="text-align: center; font-size:18px; background-color:black;
                           display: flex;
                           justify-content: center; padding:5px;"> 
                           <h3 class="mb-2 panel-title text-white edit_propertytitle"></h3> 
                        </div>
                        <form action="javascript:void(0)" class="form-horizontal updatepropertydetails" id="updatepropertyform" role="form" method="POST" enctype="multipart/form-data">
                           @csrf
                           <input type="hidden" id="propertyid">
                           <div class="card padding-card product-card">
                                 <div class="card-body">
                                    <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Property Details</h5>
               
                                    <div class="row section-groups">
                                       <div class="form-group inputdetails col-sm-6">
                                             <label>Property Name<span class="text-danger inputrequired">*</span></label>
                                             <input type="text" class="form-control text-white bg-dark" required name="property_name" id="property_name">
                                       </div>
               
                                       <div class="form-group inputdetails col-sm-6">
                                             <label>Property Price<span class="text-danger inputrequired">*</span></label>
                                             <input type="text" class="form-control text-white bg-dark" required name="property_price" id="property_price">
                                       </div>
                                    </div>
            
                                    <div class="row section-groups">
                                       <div class="form-group inputdetails col-sm-12">
                                             <label>Property Name Slug<span class="text-danger inputrequired">*</span></label>
                                             <input type="text" class="form-control text-white bg-dark" required name="property_slug" id="property_slug">
                                       </div>
                                    </div>
               
                                    <div class="form-group inputdetails">
                                       <label>Property Description<span class="text-danger inputrequired">*</span></label>
                                       <div id="property_details_ck" style="border:2px solid black; width:100%;">
                                       </div>
                                    </div>
               
                                    <div class="row section-groups">
                                       <div class="form-group inputdetails col-sm-6">
                                             <label>Property Location<span class="text-danger inputrequired">*</span></label><br>
                                             <select name="propertyhouselocation" class="propertylocationselect form-control text-white bg-dark" required style="width:100%;">
                                                <option>Choose the Location of the Property</option>
                                                @foreach($allrentallocations as $propertylocation)
                                                   <option value="{{ $propertylocation->id }}">{{ $propertylocation->location_title }}</option>
                                                @endforeach
                                             </select>
                                       </div>
               
                                       <div class="form-group inputdetails col-sm-6">
                                             <label>Property Category<span class="text-danger inputrequired">*</span></label><br>
                                             <select name="propertycategory" class="propertycategoryselect form-control text-white bg-dark" required style="width:100%;">
                                                <option>Choose a Property Category</option>
                                                @foreach($allpropertycategories as $propertycat)
                                                   <option value="{{ $propertycat->id }}">{{ $propertycat->propertycat_title }}</option>
                                                @endforeach
                                             </select>
                                       </div>
                                    </div>
                                 </div>
                           </div>
               
                           <div class="card padding-card product-card">
                                 <div class="card-body">
                                    <h5 class="card-title mb-4" style="color: black; font-size:18px;">2.Property Files</h5>
                                    <div class="row section-groups">
                                       <div class="col-md-6 inputdetails">
                                          <h5 class="card-title mb-4">Property Profile Image</h5>
                                          <div id="propertyimg">
                                             <img style="width: 80px;" src='' id="showpropertyimage">&nbsp;
                                             <input type="file" name="property_image" accept="image/*">
                                             <input type="hidden" name="property_image" class="sellpropertyimage"/>
                                             <span class="font-italic">Recommended size:width  1040px by height 1200px</span>
                                          </div>
                                       </div>

                                       <div class="col-md-6 inputdetails">
                                          <label>Property Address Location<span class="text-danger inputrequired">*</span></label>
                                          <input type="text" class="form-control text-white bg-dark" required name="property_address" id="property_address">
                                       </div>
                                    </div>
                                 </div>
                           </div>
                           <button type="submit" id="updateproperty" class="btn btn-success">Update Property</button>
                           <ul class="alert alert-warning d-none updateproperty_errorlist"></ul>
                        </form>
                     </div>
               </div> 
            </div>
         </div>
      </div>

      {{-- modal to send memo to tenants and admins --}}
      <div class="modal fade" id="sendmemomodal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" >
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-body">
                     {{-- add memo Details --}}
                        <div class="mx-auto" style="text-align: center; font-size:18px; background-color:black;
                           display: flex;
                           justify-content: center; padding:5px;"> 
                           <h3 class="mb-2 panel-title text-white">Memo Details</h3> 
                        </div>
                        <form action="javascript:void(0)" class="form-horizontal" id="sendmemodetailsform" role="form" method="POST" enctype="multipart/form-data">
                           @csrf
                           <div class="card padding-card product-card">
                                 <div class="card-body">
                                    <div class="row section-groups">

                                       <div class="form-group inputdetails col-sm-3">
                                       </div>
                                       <div class="form-group inputdetails col-sm-6">
                                             <label>Memo Title<span class="text-danger inputrequired">*</span></label>
                                             <input type="text" class="form-control text-white bg-dark" name="memo_title" id="memo_title" placeholder="write the title of the memo here">
                                       </div>
                                       <div class="form-group inputdetails col-sm-3">
                                       </div>
                                    </div>

                                    <div class="row section-groups">
                                       <div class="form-group inputdetails col-sm-7">
                                          <label>Rental House of the User<span class="text-danger inputrequired">*</span></label><br>
                                          <select id="recipienthouse" class="adminselect2 form-control text-white bg-dark" style="width:100%;" required>
                                             <option value="0" disabled="true" selected="true">Select House Name of the User</option>
                                             <?php 
                                                $allrentalhouses=Rental_house::where(['is_extraimages'=>1,'rental_status'=>1])->get();
                                             ?>
                                             @foreach($allrentalhouses as $rentalhse)
                                                <option value="{{ $rentalhse->id }}">
                                                   {{ $rentalhse->rental_name }}</option>
                                             @endforeach
                                          </select>
                                       </div>
                                    </div>

                                    <div class="row section-groups">
                                       <div class="form-group inputdetails col-sm-12">
                                          <label>All Tenants for the Rental House<span class="text-danger inputrequired">*</span></label><br>
                                          <select name="tenantsadmins[]" id="usertenantnme" class="adminselect2 form-control text-white bg-dark" style="width:100%;" required multiple>
                                          </select>
                                       </div>
                                    </div>
                                    
                                    <div class="form-group inputdetails">
                                       <label>Message Memo<span class="text-danger inputrequired">*</span></label>
                                       <div id="memo_message_ck" style="border:2px solid black; width:100%;">
                                       </div>
                                    </div>

                                    <ul class="alert alert-warning d-none" id="memo_errorlist"></ul>
                                 </div>
                           </div>
               
                           <button type="submit" id="sendmemobtn" class="btn btn-success">Send the Memo</button>
                        </form>
                     </div>
               </div> 
            </div>
         </div>
      </div>
      
     <!-- Mainly scripts-->
      

      <script src="{{ asset('cssjqueryfiles/adminpanel/js/jquery-3.5.1.js') }}"></script>
      <script src="{{ asset('cssjqueryfiles/adminpanel/js/popper.min.js') }}"></script>
      <script src="{{ asset('cssjqueryfiles/adminpanel/js/bootstrap.min.js') }}"></script>

      {{-- js for datatables --}}
      <script type="text/javascript" src="{{ asset('cssjqueryfiles/adminpanel/datatables/DataTables-1.10.25/js/jquery.dataTables.min.js')}}"></script> 
      {{-- <script type="text/javascript" src="{{ asset('cssjqueryfiles/adminpanel/datatables/DataTables-1.10.25/js/dataTables.bootstrap.min.js')}}"></script> --}}
      <script type="text/javascript" src="{{ asset('cssjqueryfiles/adminpanel//datatables/Responsive-2.2.9/js/dataTables.responsive.js')}}"></script>
      <script type="text/javascript" src="{{ asset('cssjqueryfiles/adminpanel/datatables/Buttons-1.7.1/js/dataTables.buttons.min.js')}}"></script>
      <script type="text/javascript" src="{{ asset('cssjqueryfiles/adminpanel/datatables/jszip3.1.3/jszip.min.js')}}"></script>
      <script type="text/javascript" src="{{ asset('cssjqueryfiles/adminpanel/datatables/pdfmake-0.1.36/pdfmake.min.js')}}"></script>
      <script type="text/javascript" src="{{ asset('cssjqueryfiles/adminpanel/datatables/pdfmake-0.1.36/vfs_fonts.js')}}"></script>
      <script type="text/javascript" src="{{ asset('cssjqueryfiles/adminpanel/datatables/Buttons-1.7.1/js/buttons.html5.min.js')}}"></script>
      <script type="text/javascript" src="{{ asset('cssjqueryfiles/adminpanel/datatables/Buttons-1.7.1/js/buttons.print.min.js')}}"></script>
      
      <script src="{{ asset('cssjqueryfiles/adminpanel/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
      <script src="{{ asset('cssjqueryfiles/adminpanel/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
      <script src="{{ asset('cssjqueryfiles/adminpanel/js/plugins/flot/jquery.flot.js') }}"></script>
      <script src="{{ asset('cssjqueryfiles/adminpanel/js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
      <script src="{{ asset('cssjqueryfiles/adminpanel/js/plugins/flot/jquery.flot.spline.js') }}"></script>
      <script src="{{ asset('cssjqueryfiles/adminpanel/js/plugins/flot/jquery.flot.resize.js') }}"></script>

      <script src="{{ asset('cssjqueryfiles/adminpanel/js/inspinia.js') }}"></script>
      <script src="{{ asset('cssjqueryfiles/adminpanel/js/plugins/pace/pace.min.js') }}"></script>

      <script src="{{ asset('cssjqueryfiles/adminpanel/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

      <script type="text/javascript" src="{{ asset('cssjqueryfiles/adminpanel/js/plugins/jqueryvalidate/jquery.validate.js')}}"></script>

      {{-- dropzone js --}}
      <script src="{{ asset('cssjqueryfiles/adminpanel/js/plugins/dropzone/dropzone.min.js') }}"></script>

      {{-- alertify --}}
      <script src="{{ asset('cssjqueryfiles/adminpanel/alertifyjs/alertify.min.js') }}"></script>

      {{-- bootstrap toggle --}}
      <script src="{{ asset('cssjqueryfiles/adminpanel/bootstrap-togglemin/bootstrap-toggle.min.js') }}"></script>

      {{-- select2 --}}
      <script src="{{ asset('cssjqueryfiles/adminpanel/select2/select2.min.js') }}"></script>

      {{-- ck editor --}}
      <script src="{{ asset('cssjqueryfiles/adminpanel/plugins/classiceditor/classicckeditor5.35.0.1.js') }}"></script>

      {{-- bootsrap date picker --}}
      <script src="{{ asset('cssjqueryfiles/adminpanel/plugins/moment/moment.min.js') }}"></script>
      <script src="{{ asset('cssjqueryfiles/adminpanel/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
      

      {{--<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
       <script src="{{ asset('cssjqueryfiles/adminpanel/plugins/ckeditor/ckeditor.js') }}"></script>
      <script src="{{ asset('cssjqueryfiles/adminpanel/plugins/ckeditor/adapters/jquery.js') }}"></script> --}}

                           {{-- cdn links  --}}

      {{-- bootstrap jquery links --}}
      {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

      {{-- select2 
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>

      {{-- Switch toggle cdns 
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

      {{-- datatables 
      <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap.min.js"></script>
      <script src="https://cdn.datatables.net/fixedheader/3.2.4/js/dataTables.fixedHeader.min.js"></script>
      <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
      <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap.min.js"></script>

      {{-- integrate ck editor 
      <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
      
      {{-- {{-- leaflet js map  
      {{-- <script src="https://unpkg.com/leaflet/dist/leaflet-src.js"></script> --}}

      

      
      @yield('addimagesscripts')
      @yield('editimagesroomsscripts')
      @yield('showhousestoaddimgsscript')
      @yield('housereviewsmgtscript')
      @yield('hserequestmgmtscript')
      @yield('rentaltagsmgmtscript')
      @yield('assignusersrolesscript')
      @yield('ourtenantsscript')
      @yield('locationsmgmtscript')
      @yield('allpropertiesmgmtscript')
      @yield('activehsesmgmtscript')
      @yield('inactivehsesmgmtscript')
      @yield('rentalcategoriesmgntscript') 
      @yield('mpesapaymentscript')
      @yield('propertycategoriesscripts')
      @yield('registeredtenantscript')
      @yield('tenantstatusesmgmtscript')
      @yield('activepropertiesmgmtscript')
      @yield('inactivepropertiesmgmtscript')
      @yield('propertyimagesscript')
      @yield('companymemoscript') 
      @yield('userrolesmgmtscript')
      @yield('alltenantspaymentscript')
      
      @section('scripts')
      <script>

         // show preloader when a page loads
         window.onload=function(){
            document.getElementById('loader').style.display="none";
            document.getElementById('wrapper').style.display="flex";
         };
         // delete user modal and also from the database
         // $(document).on('click','.deleteadmin-btn',function()
         // {
         //       var adminID=$(this).attr('data-userid');
         //    $('#deleteadmindata').val(houseID); 
         //    $('#deleteadminmodal').modal('show'); 
         // });

         // $(document).on('click','.delete-btn',function(e)
         // {
         //    e.preventDefault();

         //    var rentalid=$(this).val();

         //    $('#deleterentaldata').val(rentalid);
         // })
            
         $(document).ready(function() {


         //  datatable for showing all the rental houses
            var table = $('#rentalhouses').DataTable({
               responsive: true
            });

            
         });


         $(document).ready(function() {

            // hide the drop zone form for changing the video on page load
            $('.changehsevideo').hide();

            $('.changepropertyvideo').hide();

            // 
            $('.adminselect2').select2();

            // hide memo modal when page loads 
            $("#contactadminmodal").on('hide.bs.modal', function(){
               $('#memo_title').val('');
               $("#memo_message_ck").children("textarea").remove();
               $('.memodetailstextarea').val('');
            });

            // hide admin edit modal if closed  
            // $("#admineditmodal").on('hide.bs.modal', function(){
            //    $('.modal-title').html('');
            //    $('.catlabel').html('');
            //    $('.save_button').html('');
            //    $('.propertycat_id').html('');
            //    $('.rentaltag_id').html('');
            //    $('.location_id').html('');
            //    $('.rolename_id').html('');
            //    $('.room_id').html('');

            //    $('#property_category').html('');
            //    $('#rental_tagname').html('');
            //    $('#location_name').html('');
            //    $('#roomsize_name').html('');
            //    $('#room_name').html('');
            //    $('#role_name').html('');
            //    $('#editroomsizelabel').html('');
            //    $('#editroomsize_price').val('');

            //    $('#property_category').hide();
            //    $('#rental_tagname').hide();
            //    $('#location_name').hide();
            //    $('#roomsize_name').hide();
            //    $('#room_name').hide();
            //    $('#role_name').hide();
            // });

            // csrf token
            $.ajaxSetup({
               headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
            });

            // select tags in the add house form 
            $('.rentaltagselect2').select2();

            // show ck editor in the add property page
            ClassicEditor
            .create( document.querySelector( '.ckdescription' ),
            {
               toolbar: {
                  items: [
                     'heading', '|',
                     'bold', 'italic', '|',
                     'link', '|',
                     'outdent', 'indent', '|',
                     'bulletedList', 'numberedList', '|',
                     'undo', 'redo'
                  ],
                  shouldNotGroupWhenFull: true
               }
            })

            // hide modal if ni data has been added
            $("#editrentalhsedetailsmodal").on('hide.bs.modal', function(){
               $('#rentalhouseid').val('');
               $('.edit_title').html('');
               $('#rental_title').val('');
               $('#rental_slug').val('');
               $('#monthly_rent').val('');

               $("#rental_details_ck").children("textarea").remove();
               $('.hsedetailstextarea').val('');

               $('#totalrooms').val('');
               $('#rental_address').val('');

               $('.rentalhsevideo').val('');

               $(".rentalselectcat").val('');

               $(".rentalhsevacancy").val('');

               $(".rentalhselocation").val('');

               $(".hseownerselect").val('');

               //pass array object value to select2
               $('.rentaltagselect2').val('');

               // preview an image that was previously uploaded
               var deleteimage=$('#showimage').removeAttr('src');
               $('.rentalhseimage').html('deleteimage');

               $('.editcheckbox').prop('checked', false);
            });

            // hide editing property modal if no data has been updated
            $("#editpropertydetailsmodal").on('hide.bs.modal', function(){
               $('#propertyid').val('');
               $('.edit_propertytitle').html('');
               $('#property_name').val('');
               $('#property_price').val('');
               $('#property_slug').val('');
               $('#propertydetails').val('');

               $("#property_details_ck").children("textarea").remove();
               $('.propertydetailstextarea').val('');

               var deleteimage=$('#showpropertyimage').removeAttr('src');
               $('.propertyimg').html('deleteimage');

               $(".propertylocationselect").val('');
               $(".propertycategoryselect").val('');
            });

            // empty the edit modal on closing if no data has been updated
            $("#editpropertydetailsmodal").on('hide.bs.modal', function(){
            });
         });
      </script>
   </body>
</html>