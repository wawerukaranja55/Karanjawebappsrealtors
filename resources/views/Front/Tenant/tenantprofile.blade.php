@extends('Front.frontmaster')
@section('title','Tenant Profile Page')
@section('content')
@section('tenantdetailsstyles')
    <style>
        .tenantdetails{
            font-size: 15px;
             color:black;
        }

        /* tabs detail */
        .project-tab {
            padding: 2%;
            margin-top: 7px;
        }
        .project-tab #tabs{
            background: #007b5e;
            color: #eee;
        }
        .project-tab #tabs h6.section-title{
            color: #eee;
        }
        .project-tab #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
            color: #fffdfe;
            background-color: rgb(17, 5, 5);
            border-color: transparent transparent #f3f3f3;
            border-bottom: 3px solid !important;
            font-size: 16px;
            font-weight: bold;
        }
        .project-tab .nav-link {
            border: 1px solid transparent;
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
            color: #0062cc;
            font-size: 16px;
            font-weight: 600;
        }
        .project-tab .nav-link:hover {
            border: none;
        }
        .project-tab thead{
            background: #f3f3f3;
            color: #333;
        }
        .project-tab a{
            text-decoration: none;
            color: #333;
            font-weight: 600;
        }

        #payrentwithmpesa{
            margin: 0px !important;
        }

        .disabled{
        cursor: pointer !important;
        }
    </style>
@stop
    <div class="container">
        {{-- <div class="row">
            <div class="col-lg-8 col-md-8">

            </div>
            <div class="col-lg-4 col-md-4">
                <a href="#" class="btn btn-danger float-right" data-id="{{ $userprofile->id }}" id="deactivateuseraccount">Deactivate Your Account</a>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-lg-5 col-md-5">
                <div class="float-right mt-3" style="text-align: center;">
                    <form action="javascript:void(0)" id="updateimage" class="form-horizontal" role="form" method="POST"  enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="tenantid" id="tenant_id" value="{{ $userprofile->id }}" >
                        <label for="tenantimg" style="font-size:18px;" class="btn text-success mb-3">Click To Change Image</label>
                        <input id="tenantimg" name="tenant_image" accept="image/*" style="visibility:hidden;" type="file">
                        <button type="submit" class="btn btn-primary">Upload</button>  
                    </form>
                    @if ($userprofile->avatar == 'default.jpg')
                        <img id="tenantimg_preview" class="rounded img-fluid" src="/imagesforthewebsite/usersimages/default.jpg" alt="{{ $userprofile->name }}">
                    @else
                        <img id="tenantimg_preview" class="rounded img-fluid" src="/imagesforthewebsite/usersimages/{{ $userprofile->avatar }}" alt="{{ $userprofile->name }}">
                    @endif
                    
                </div>
            </div>
            <div class="col-lg-7 col-md-7 pl-5 pr-5">
                <h1 class="mb-0 mt-4">{{ $userprofile->name }}</h1>
                <input type="hidden" name="userid" id="userid" value="{{ $userprofile->id }}">
                
                {{-- <input type="hidden" name="checkoutrequestid" id="checkoutrequestid" value="{{ $userprofile->checkoutrequest_id }}"> --}}
                <div class="row mt-3">
                    <div class="col-lg-6 col-md-6">
                        <p class="tenantdetails"><strong>Id Number :</strong> {{ $userprofile->id_number }}</p>
                        <p class="tenantdetails">
                            <strong>Phone :</strong> {{ $userprofile->phone }}
                        </p>
                        <p class="tenantdetails"><strong>House Name :</strong>
                            {{ $userprofile->rentalhses->rental_name }}
                        </p>
                        <p class="tenantdetails"><strong>House Number :</strong>
                            @foreach ($userprofile->hserooms as $room )
                                {{ $room->room_name }}
                            @endforeach
                        </p>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <p class="tenantdetails"><strong>Monthly Rent :sh.</strong> {{ $userprofile->rentalhses->monthly_rent }}</p>
                    </div>
                </div>
                

                <div id="paywithmpesa">
                    <section id="tabs" class="project-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <nav>
                                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active payment-tab" id="nav-payment-tab" 
                                            data-toggle="tab" href="#nav-payment" role="tab" aria-controls="nav-payment" aria-selected="true">
                                            <span id="paydetails">1.</span>Payment Details
                                        </a>
                                        <a class="nav-item nav-link confirm-tab disabled" id="nav-confirm-tab"
                                            data-toggle="tab" href="#nav-confirm" role="tab" aria-controls="nav-confirm" aria-selected="false">
                                            <span id="confirmpay">2.</span>Confirm Payment
                                        </a>
                                        <a class="nav-item nav-link paid-tab disabled" id="nav-paid-tab" 
                                            data-toggle="tab" href="#nav-paid" role="tab" aria-controls="nav-paid" aria-selected="false">
                                            <span id="rentpaid">3.</span>Rent Paid</a>
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-payment" role="tabpanel" aria-labelledby="nav-payment-tab">
                                        <div class="row">
                                            <div class="col-md-12" style="border: 2px solid black;">
                                                <div class="card padding-card product-card" style="text-align: center; margin-top:20px;">
                                                    <h3>Pay Your Rent With Mpesa</h3>
                                                    <form action="javascript:void(0)" id="payrentwithmpesa" class="form-horizontal" role="form" method="POST">
                                                        @csrf
                                                        <div class="card-body">
                                
                                                            <div class="row">
                                                                <div class="col-md-9">
                                                                    <label style="font-size: 20px;">Amount Of Rent To Pay</label>
                                                                    <input type="number" class="form-control text-white bg-dark" name="rent_amount" id="rent_amount" value="{{ $userprofile->rentalhses->monthly_rent }}">
                                                                </div>
                                                            </div>
                                
                                                            <div class="row">
                                                                <div class="col-md-9">
                                                                <label style="font-size: 20px;">Phone Number</label>
                                                                <input type="number" class="form-control text-white bg-dark" name="phone_number" id="phonenumber" placeholder="Enter Phone Number To Charge">
                                                                </div>
                                                            </div>
                                
                                                            <input type="hidden" name="tenantname" id="tenantname" value="{{ $userprofile->name }}">
                                                            <input type="text" class="form-control" name="userid" id="user" value="{{ $userprofile->id }}" hidden>
                                
                                                            <div class="row section-groups mt-3">
                                                                <div class="col-md-12 text-center">
                                                                    <button type="submit" class="btn btn-md btn-danger">Pay Rent</button>
                                                                </div>
                                                            </div>
                                
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade show" id="nav-confirm" role="tabpanel" aria-labelledby="nav-confirm-tab">
                                        <div class="row">
                                            <div class="col-md-12" style="border: 2px solid black;">
                                                <div class="card padding-card product-card confirmrentalpay" style="text-align: center; margin-top:20px;">
                                                    <h3>Confirm The Rental Payment</h3>
                                                    <form action="javascript:void(0)" id="confirmmpesapayment" class="form-horizontal" role="form" method="POST">
                                                        @csrf
                                                        <div class="card-body">

                                                            <div class="row">
                                                                <div class="col-md-9">
                                                                    <label style="font-size: 20px;">Transaction Code</label>
                                                                    <input type="text" class="form-control text-white bg-dark" name="transactionid" id="transactionid" placeholder="Enter the Transaction code Sent Back In Your Mpesa Message.e.g QWERRYHSG ">
                                                                </div>
                                                            </div>
                                                            <span style="font-style: italic">Keenly Check the Confirmation code very well on the message and type all the letters and number.</span>
                                                            <div class="row section-groups mt-3">
                                                                <div class="col-md-12 text-center">
                                                                    <button type="submit" class="btn btn-md btn-danger">Submit</button>
                                                                </div>
                                                            </div>
                                
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade show" id="nav-paid" role="tabpanel" aria-labelledby="nav-paid-tab">
                                        <div class="card" id="mpesasuccessful">
                                            <div style="border-radius:200px; height:200px; width:200px;
                                            background: #f3f5f1; margin:0 auto; 
                                            display: flex;
                                            justify-content: center;" >
                                              <i class="checkmark" 
                                                style="color: hsl(180, 93%, 43%);
                                                font-size: 100px;
                                                line-height: 200px;">✓</i>
                                            </div>
                                            <div class="card-body">
                                                <h1>Payment Successful</h1>
                                                <span>Your Payment is Successful.Click on the tab below to check the transaction Details.</span>
                                            </div>
                                        </div>
                                        <div class="card" id="mpesafailed">
                                            <div style="border-radius:200px; height:200px; width:200px;
                                            background: #dd0529; margin:0 auto; 
                                            display: flex;
                                            justify-content: center;" >
                                                <i class="checkmark" style="color: hsl(0, 29%, 97%);
                                                font-size: 100px;
                                                line-height: 200px;">X</i>
                                            </div>
                                            <div class="card-body">
                                                <h1>Payment On Mpesa Failed</h1>
                                                <span>Your Payment Failed Kindly check Your Phone Number Again.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
                 
        </div>
        <div class="row" >
            <div class="col-md-12">
                <section id="tabs" class="project-tab">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <nav>
                                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Update Your Profile</a>
                                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Mpesa Rent Payments</a>
                                        <a class="nav-item nav-link" id="nav-password-tab" data-toggle="tab" href="#nav-password" role="tab" aria-controls="nav-password" aria-selected="false">Update Your Password</a>
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form method="POST" action="{{ url('edituserdetails/'.$userprofile->id) }}">
                                                    @csrf
                                                    <div class="card padding-card product-card">
                                                        <div class="card-body">
                                                            <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Personal Details</h5>
                                        
                                                            <div class="row section-groups">
                                                                <div class="form-group inputdetails col-sm-6">
                                                                    <label>Name<span class="text-danger inputrequired">*</span></label>
                                                                    <input type="text" class="form-control text-white bg-dark" required name="fullname" id="fullname">
                                                                </div>
                                        
                                                                <div class="form-group inputdetails col-sm-6">
                                                                    <label>Phone Number<span class="text-danger inputrequired">*</span></label>
                                                                    <input type="text" class="form-control text-white bg-dark" required name="phonenumber" id="phone_number">
                                                                </div>
                                                            </div>
                                
                                                            <div class="row section-groups">
                                                                <div class="form-group inputdetails col-sm-6">
                                                                    <label>Email<span class="text-danger inputrequired">*</span></label>
                                                                    <input type="email" class="form-control text-white bg-dark" required name="email" id="emailaddress">
                                                                </div>
                                                                <div class="form-group inputdetails col-sm-6">
                                                                    <label>Id Number<span class="text-danger inputrequired">*</span></label>
                                                                    <input type="number" class="form-control text-white bg-dark" required name="id_number" id="idnumber">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if($userprofile->is_admin == 0)
                                                        <div class="card padding-card product-card">
                                                            <div class="card-body">
                                                                <h5 class="card-title mb-4" style="color: black; font-size:18px;">2.House Details</h5>
                                                                
                                                                <div class="row section-groups">
                                                                    <div class="form-group inputdetails col-sm-6">
                                                                        <label>House Name<span class="text-danger inputrequired">*</span></label>
                                                                        <br>
                                                                        <select name="rentalnameid" class="rntalhse form-control text-white bg-dark" style="width: 100%;" required>
                                                                            @foreach($activehousenames as $housename)
                                                                                <option value="{{ $housename->id }}">{{ $housename->rental_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                            
                                                                    <div class="form-group inputdetails col-sm-6">
                                                                        <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                                                        <select name="getroomnamenumber" id="rmnamenumber" class="form-control text-white bg-dark" style="width: 100%;" required>
                                                                            @foreach($rmnames as $rmname)
                                                                                <option value="{{ $rmname->id }}">{{ $rmname->room_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif 
                                                   <button type="submit" class="btn btn-dark text-white">Update The Details</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                        <table id="mpesapaymentstable" class="table  table-bordered" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Transaction_id</th>
                                                    <th>Phone Number</th>
                                                    <th>Date Paid</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="nav-password" role="tabpanel" aria-labelledby="nav-password-tab">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form method="POST" action="{{ url('updatepassword') }}" name="update_passwordform" id="updatepasswordform">
                                                    @csrf
                                                    <div class="card padding-card product-card">
                                                        <div class="card-body">
                                                            <h5 class="card-title mb-4" style="color: black; font-size:18px;">Change Account Password</h5>

                                                            <div class="row section-groups">
                                                                <div class="form-group inputdetails col-sm-7">
                                                                    <label>Email</label>
                                                                    <input type="email" readonly="" class="form-control text-white bg-dark" value="{{ $userprofile->email }}">
                                                                </div>
                                                            </div>
                                        
                                                            <div class="row section-groups">
                                                                <div class="form-group inputdetails col-sm-7">
                                                                    <label>Current Password</label>
                                                                    <span id="checkcurrentpwd"></span>
                                                                    <input type="text" class="form-control text-white bg-dark" name="currentpwd" id="current_pwd" required>
                                                                </div>
                                                            </div>

                                                            <div class="row section-groups">
                                                                <div class="form-group inputdetails col-sm-7">
                                                                    <label>New Password</label>
                                                                    <input type="text" class="form-control text-white bg-dark" name="newpwd" id="new_pwd" required>
                                                                </div>
                                                            </div>
                                
                                                            <div class="row section-groups">
                                                                <div class="form-group inputdetails col-sm-7">
                                                                    <label>Confirm Password</label>
                                                                    <input type="text" class="form-control text-white bg-dark" name="confirmpwd" id="confirm_pwd" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                   
                                                   <button type="submit" class="btn btn-dark text-white">Update Password</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('tenantpagescript')
    <script>
        // update image in the tenant profile page
        $("#tenantimg").change(function() {
            var filename = $('#tenantimg')[0].files[0];
            let reader = new FileReader();

            // preview image on upload
            reader.onload = (e) => { 
                $('#tenantimg_preview').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]);

            var tenantimageid=$('#tenant_id').val();

            var token =  $('input[name="_token"]').attr('value')
            $.ajaxSetup({
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Csrf-Token', token);
                }
            });

            // get image data to send ajax
            var tenantimgdata = new FormData();
            tenantimgdata.append("tenant_id", tenantimageid);
            tenantimgdata.append("tenant_image", filename);
            tenantimgdata.append("_token", token);
        
            $("#updateimage").on("submit",function(e){
                e.preventDefault();
                $.ajax({
                    url:'/updateprofileimg',
                    type:"POST",
                    data: tenantimgdata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(res){
                        console.log(res);
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(res.message);
                    }
                });
            })
        });

        // show all mpesa payments for that specific tenant in a datatable
        var user_id=$('#userid').val();

        var mpesapaymentstable = $('#mpesapaymentstable').DataTable({
            processing:true,
            serverside:true,
            responsive:true,

            ajax:
                {
                    url:'{{ url("get_tenantmpesapayments") }}',
                    type: 'get',
                    dataType: 'json',
                    data:{
                        'id':user_id
                    },
                },
            columns: [
                { data: 'id' },
                { data: 'mpesatransaction_id' },
                { data: 'phone' },
                { data: 'created_at',name:'created_at',orderable:false,searchable:false },
                { data: 'action',name:'action',orderable:false,searchable:false },
            ],
        });

        // mpesa pay rent by mpesa
        $(document).ready(function(){

            // add payment details
            var mpesapayurl = '{{ route("stkpush") }}'; 
            $("#payrentwithmpesa").on("submit",function(e){
                e.preventDefault();
                var mpesaform = $('#payrentwithmpesa')[0];
                var formdata=new FormData(mpesaform);
                $.ajax({
                    url:mpesapayurl,
                    type:"POST",
                    processData:false,
                    contentType:false,
                    data:formdata,
                    success:function(response){
                        $message="Kindly Check On Your Phone and Enter Mpesa Pin"
                        alertify.set('notifier','position', 'top-right');
                        alertify.success($message);
                        alert('check phone');
                        // $('#nav-payment-tab').append('<span id="paydetails"><img src=\"/imagesforthewebsite/icons/check-circle-solid.svg/" height=\"30px\"></span>');

                        $('#nav-confirm-tab').removeClass("disabled").addClass("active");
                        $('#nav-payment-tab').removeClass("active").addClass("disabled");

                        $('#nav-payment').hide();
                        $('#nav-confirm').show()
                        
                    },
                    error:function(response){
                        console.log(response);
                        if(error){
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(response.message);
                        }
                    }
                });
            })

            // confirm payment details
            var mpesaconfirmurl = '{{ route("confirmmpesa.transaction") }}'; 

            $("#confirmmpesapayment").on("submit",function(e){
                e.preventDefault();
                var mpesaform = $('#confirmmpesapayment')[0];
                var formdata=new FormData(mpesaform);
                $.ajax({
                    url:mpesaconfirmurl,
                    type:"POST",
                    processData:false,
                    contentType:false,
                    data:formdata,
                    success:function(response){
                        $('#nav-paid-tab').removeClass("disabled").addClass("active");
                        $('#nav-confirm-tab').removeClass("active").addClass("disabled");
                        $('#nav-confirm').hide();
                        $('#nav-paid').show();

                        console.log(response.status);
                        if (response.status==200)
                        {
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(response.message);
                            $('#mpesafailed').hide();
                            $('#mpesasuccessful').show();
                            mpesapaymentstable.ajax.reload();

                        } else if (response.status==404)
                        {
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(response.message);
                            $('#mpesasuccessful').hide();
                            $('#mpesafailed').show();
                        }   
                    }
                });
            })

            // add data to the edit form from the table upon page load
            var useraccountid=$('.useraccntid').val();
            $.ajax({
                url:'{{ url("edituseraccount",'') }}' + '/' + useraccountid + '/edit',
                method:'GET',
                processData: false,
                contentType: false,
                success:function(response)
                {
                    if (response.status==200)
                    {
                    $('#username').val(response.edituserdetail.username);
                    $('#fullname').val(response.edituserdetail.name);
                    $('#phone_number').val(response.edituserdetail.phone);
                    $('#emailaddress').val(response.edituserdetail.email);
                    $('#idnumber').val(response.edituserdetail.id_number);

                    $('.rntalhse').select2();
                    $('.rntalhse').val(response.edituserdetail.rentalhses.id);

                    var housesobject = (response.edituserdetail.hserooms);
                    var tagsarray = $.map(housesobject, function(el) { 
                        return el['id']; 
                    });

                    //pass array object value to select2
                    $("#rmnamenumber").select2();
                    $('#rmnamenumber').val(tagsarray).trigger('change');;
                    }
                }
            })

            // check if the current password is correct
            $("#current_pwd").keyup(function(){
                var currentpassword=$("#current_pwd").val();
                $.ajax({
                    url:'{{ url("check_current_password") }}',
                    method:"post",
                    data:{
                        currentpwd:currentpassword,
                    },
                    success:function(resp){
                        console.log(resp);
                        if(resp=="false")
                        {
                            $('#checkcurrentpwd').html("<br><font color=red>Current password is Incorrect</font>");
                        }else if (resp=="true")
                        {
                            $('#checkcurrentpwd').html("<br><font color=green>The Password is Correct</font>");
                        } 
                    },error:function(){
                        alert("error");
                    }
                })
            })
        });

        // show rooms for a house on dropdown
        $(document).on('change','.rntalhse',function(){
            var hsetitle_id=$( ".rntalhse" ).val();
            $.ajax({
                type:'get',
                url:'{{ route("getrooms.house") }}',
                data:{
                    'id':hsetitle_id
                },
                success:function(data){
                        console.log(data);
                        $('#rmnamenumber').html('<option disabled selected value=" ">Select Your Room Name/Number</option>');
                        
                        console.log("the data is ",data);
                        data.forEach((room)=>{
                        console.log(room);
                        $('#rmnamenumber').append('<option value="'+room.id+'">'+room.room_name+'</option>');
                    });
                        
                },error:function(){
                }
            });
        });

        // user can deactivate their account
        // $(document).on('click','#deactivateuseraccount',function(){

        //     var accountuserid=$(this).data('id');

        //     $('#deactivateaccountmodal').modal('toggle');
        //     $('.useraccount_id').val(accountuserid);

        // })

        // $(document).on('change','.deleteuseraccountbutton',function()
        // {
        //     var accountstatus=$(this).prop('checked')==true? 1:0;

        //     var acctuserid=$('.useraccount_id').val();

        //     $.ajax({
        //         type:"GET",
        //         dataType:"json",
        //         url:'{{ route('deactivate.account') }}',
        //         data:{
        //             'useraccountid':acctuserid,
        //             'accountstatus':accountstatus
        //         },
        //         success:function(res){
        //             console.log(res);
        //             window.location=res.url;
        //             alertify.set('notifier','position', 'top-right');
        //             alertify.success(res.message);
        //         }
        //     });
        // });
    </script>
@stop





