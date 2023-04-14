@extends('Admin.adminmaster')
@section('title','All Payments By Registered Tenants')
@section('content')
<div class="row" style="
    display: flex;
    justify-content: center;">
   <div class="col-md-3">
      <a class="btn btn-dark" href="{{ route('active.properties') }}">Actived Properties</a>
   </div>
   <div class="col-md-3">
      <a class="btn btn-dark" href="{{ url('admin/assign_userroles') }}">All Registered Users</a>
   </div>
   <div class="col-md-3">
      <a class="btn btn-dark" href="{{ url('admin/tenantreviews') }}">All Rental Reviews</a>
   </div>
   <div class="col-md-3">
      <a class="btn btn-dark" href="{{ url('admin/activerentals') }}">Activated Rental Houses</a>
   </div>
</div>

<div class="row">
    <div class="col-lg-7 col-md-7">
        <div class="panel-heading mt-5" style="text-align: center; font-size:18px; background-color:black;"> 
            <h3 class="mb-2 panel-title">Add a House Payment by Tenant</h3> 
        </div>
        <form action="javascript:void(0)" id="addhsepaymentform" class="form-horizontal" role="form" method="POST">
            @csrf
            <div class="card padding-card product-card">
                <div class="card-body">
                    <h3>1.Tenant Details</h3>
                    <div class="row section-groups">
                        <div class="form-group inputdetails col-sm-8">
                            <label for="tenant_name" class="control-label">Tenant Name<span class="text-danger inputrequired">*</span></label><br>
                            <select name="user_id" id="findtenant" class="form-control text-white bg-dark adminselect2" style="width:100%;" required>
                                <option value="" disabled selected>Select A Tenant Name</option>
                                @foreach($tenants as $tenantnme)
                                    <option value="{{ $tenantnme->id }}">{{ $tenantnme->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row section-groups">
                        <div class="form-group inputdetails col-sm-6">
                            <label>House Name For the tenant<span class="text-danger inputrequired">*</span></label>
                            <input type="text" readonly class="form-control text-white bg-dark" required name="rental_name" id="addpayrental_name" placeholder="The Rental House Name for the user">
                        </div>
                        <div class="form-group inputdetails col-sm-6">
                            <label>Rooms For the Tenant<span class="text-danger inputrequired">*</span></label>
                            <input type="text" readonly class="form-control text-white bg-dark" required name="house_rooms" id="addpayhouse_rooms" placeholder="Room Name/s for the tenant">
                        </div>
                        <div class="form-group inputdetails col-sm-6">
                            <label>Total Amount of Rent For the Tenant<span class="text-danger inputrequired">*</span></label>
                            <input type="text" readonly class="form-control text-white bg-dark" required name="total_rent" id="addpaytotal_rent" placeholder="Total Rent for the tenant">
                        </div>
                    </div>

                    <h3>2.Tenant Payment Amount Details</h3>
                    <div class="row section-groups">
                        <div class="form-group inputdetails col-sm-4">
                            <label>Transaction Type<span class="text-danger inputrequired">*</span></label>
                            <select name="transactiontype" class="form-control text-white bg-dark adminselect2" style="width:100%;" required>
                                <option value="" disabled selected>Select A Transaction Type</option>
                                @foreach($transactiontypes as $transactiontyp)
                                    <option value="{{ $transactiontyp->id }}">{{ $transactiontyp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group inputdetails col-sm-4">
                            <label>Amount Paid<span class="text-danger inputrequired">*</span></label>
                            <input type="number" class="form-control text-white bg-dark" required name="amount_paid" id="amount_paid" placeholder="Enter the Amount Paid by The tenant">
                        </div>
                        <div class="form-group inputdetails col-sm-4">
                            <label>Date Paid<span class="text-danger inputrequired">*</span></label>
                            <input type='text' class="form-control" name="date_paid" id="datepicker" placeholder="Enter the Date The Amount was paid"/>
                        </div>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-success">Save The Tenants Amount </button>

            <ul class="alert alert-warning d-none update_errorlist"></ul>
        </form>
    </div>

    <div class="col-lg-5 col-md-5">
        <h3 class="mb-2 mt-5 panel-title ms_heading text-white" style="padding:10px;">Transaction Type Management</h3>

        <form action="javascript:void(0)" id="transactiontypeform" class="form-horizontal" role="form" method="POST">
            @csrf
            <div class="form-group">
                <label for="transactiontype_title" style="font-size: 1.5rem margin-top:5px;" class="control-label">Transaction Type Name</label>
                
                <div class="bg-dark" style="margin-top: 5px;">
                    <input type="text" style="font-size: 1.3rem; background:rgb(255, 242, 242); text-color:rgb(0, 0, 0);" class="form-control text-dark" required name="name" id="transactiontypename" placeholder="Write The Transaction Type Name">
                </div> 
            </div>
            <div class="form-group">
                <label for="transactiontype_number" style="font-size: 1.5rem margin-top:5px;" class="control-label">Payment Number</label>
                
                <div class="bg-dark" style="margin-top: 5px;">
                    <input type="number" style="font-size: 1.3rem; background:rgb(255, 242, 242); text-color:rgb(0, 0, 0);" class="form-control text-dark" required name="number" id="paymentnumber" placeholder="Write The Transaction Payment Number">
                </div> 
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>   
        </form>

        <table id="transactiontypestable" class="table table-striped table-bordered" style="width:100%; margin-top:50px;">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Transaction type Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<div class="row" style="margin-top: 50px;">
    <div class="col-md-12">
        <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">All Payments by Registered Tenants</h3>
        <table id="paymentstable" class="table table-striped table-bordered" style="width:100%; margin-top:50px;">
            <thead>
                <tr>
                    <td>id</td>
                    <td>Tenant Name</td>
                    <td>House Name</td>
                    <td>Paid Via</td>
                    <td>Receipt Number</td>
                    <td>Total Amount to Pay</td>
                    <td>Amount The Tenant Paid</td>
                    <td>Arrears Not Paid</td>
                    <td>Overpaid Amount</td>
                    <td>Date Paid</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@endsection


@section('alltenantspaymentscript')
  <script>

    // show all transaction types for payments in a datatable
    var transactiontypestable = $('#transactiontypestable').DataTable({
        processing:true,
        serverside:true,
        responsive:true,
        ajax:"{{ route('get_transactiontypes') }}",
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'status',
                render: function ( data, type, row ) {
                    if ( type === 'display' ) {
                        return '<input class="toggle-class transactiontypestatus" type="checkbox" checked data-toggle="toggle" data-id="' + row.id + '" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
                    }
                    return data;
                }
            },
            { data: 'action',name:'action',orderable:false,searchable:false },
        ],
        rowCallback: function ( row, data ) {
            $('input.transactiontypestatus', row)
            .prop( 'checked', data.status == 1 )
            .bootstrapToggle();
        }
    });
    
    // show all the tenants payments
    var allpaymentstable = $('#paymentstable').DataTable({
        processing:true,
        serverside:true,
        responsive:true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],

        ajax:"{{ route('get_all.payments') }}",
        columns: [
            { data: 'id' },
            { data: 'user_id', name:'user_id.userpaymentdetails', orderable:true,searchable:true},
            { data: 'rental_name' },
            { data: 'transactiontype_id', name:'transactiontype_id.paymenttransactiontype', orderable:true,searchable:true},
            { data: 'receipt_number' },
        //   { data:
        //     function (row) {
        //     let userroom= [];
        //       $(row.user_id.usersrooms).each(function (i, e) {
        //         userroom.push(e.room_name);
        //         });
        //       return userroom.join(", ")
        //     }, name: 'usersrooms.room_name'
        //   },
            { data: 'total_rent' },
            { data: 'amount_paid' },
            { data: 'total_arrears' },
            { data: 'overpaid_amount' },
            { data: 'date_paid' },
            { data: 'action',name:'action',orderable:false,searchable:false },
        ]
    });

    $(document).ready(function(){
                // add a new transaction type for the rental houses
        $("#transactiontypeform").on("submit",function(e){
            e.preventDefault();
            var url = '{{ route("addtransactiontype") }}';

            $.ajax({
                url:url,
                type:"POST",
                data:$("#transactiontypeform").serialize(),
                success:function(response){
                    console.log(response.message);
                    transactiontypestable.ajax.reload();
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(response.message);
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

        // add a transaction for a certain tenant
        $("#addhsepaymentform").on("submit",function(e){
            e.preventDefault();
            var url = '{{ route("addtenant.payment") }}';
            console.log("data sent reached");

            $.ajax({
                url:url,
                type:"POST",
                data:$("#addhsepaymentform").serialize(),
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
                    } else if (response.status==200)
                    {
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(response.message);
                            allpaymentstable.ajax.reload();
                    }

                }
            });
        })
    });
            
            // edit transaction type
    $(document).on('click','.edittransactiontype',function(e){
        e.preventDefault();
        var transactiontypeid=$(this).data('id');
        $.ajax({
            url:'{{ url("admin/transactiontype",'') }}' + '/' + transactiontypeid + '/edit',
            method:'GET',
            success:function(response){
            console.log(response);
            $('#admineditmodal').modal('show');
            $('.modal-title').html('Edit Transaction Type');
            $('.catlabel').html('Transaction Type Name');
            $('#editroomsizelabel').html('Payment Number');
            $('.save_button').html('Update Transaction Type Name');

           
            $('#propertycat_id').val('');
            $('#rentaltag_id').val('');
            $('#room_id').val('');

            $('#property_category').hide();
            $('#rental_tagname').hide();
            $('#location_name').hide();
            $('#editroom_name').hide();

            $('#editchangeroomsizes').hide();
            
            $('#transactiontype_name').val(response.name);
            $('#transactiontype_name').show();
            $('.transactiontype_id').val(response.id);
            $('#editroomsize_price').val(response.number);
            }
        })
    });
    
        //   update transaction type details
    $(document).on('click','.save_button',function(e){
        e.preventDefault();
        
        $transactiontypeid=$('.transactiontype_id').val();
        var url = '{{ route("updatetransactiontype", ":id") }}';
        updatetrnsactiontypurl = url.replace(':id', $transactiontypeid);

        var form = $('.adminedit_form')[0];
        var formdata=new FormData(form);
        
        $.ajax({
            url:updatetrnsactiontypurl,
            method:'POST',
            processData:false,
            contentType:false,
            data:formdata,
            success:function(response)
            {
                console.log(response.status);
                if (response.status==200)
                {
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(response.message);
                    transactiontypestable.ajax.reload();
                    $('#transactiontype_name').val('');
                    $('#transactiontype_name').hide();
                    $('.transactiontype_id').val('');
                    $('#editroomsizelabel').html('');
                    $('#editroomsize_price').val('');
                    $('.save_button').html('');
                    $('#admineditmodal').modal('hide');

                } else if (response.status==400)
                {
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(response.message);
                }
            }
        });
    })

    //  update transaction type status from active to inactive
    $(document).on('change','.transactiontypestatus',function(e)
    {
        var transactiontypestatus=$(this).prop('checked')==true? 1:0;
        var transactiontypeid=$(this).data('id');
        $.ajax({
            type:"GET",
            dataType:"json",
            url:'{{ route('updatetransactiontypestatus') }}',
            data:{
                'status':transactiontypestatus,
                'id': transactiontypeid
            },
            success:function(res){
                console.log(res);
                alertify.set('notifier','position', 'top-right');
                alertify.success(res.message);
            }
        });
    });
    
    // Delete transaction type from the db
    $(document).on('click','#deletetransactiontype',function(){
        var deletetransactiontypeid=$(this).data('id');
        $('.admindeletemodal').modal('show');
        $('.modal-title').html('Delete Transcaction Type');
        $('.adminmodallabel').html('Are You Sure You Want to Delete this Category?');
        $('#transactiontypid').val(deletetransactiontypeid);
    })
    $(document).on('click','#deletemodalbutton',function()
    {
        var deletetransactiontypeid=$('#transactiontypid').val();  
        $.ajax({
            type:"DELETE",
            url:'{{ url("admin/delete_transactiontype",'') }}' + '/' + deletetransactiontypeid,
            dataType:"json",
            success:function(response)
            {
                alertify.set('notifier','position', 'top-right');
                alertify.success(response.message);
                transactiontypestable.ajax.reload();
                $('.modal-title').html('');
                $('.adminmodallabel').html('');
                $('#transactiontypid').val('');
                $('.admindeletemodal').modal('hide');
            }
        })
    })

    // show the date picker
    $(function(){
        $('#datepicker').datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true
        });
    });


    // get the details of the user upon selecting them
    $(document).on('change','#findtenant',function(){
        var tenantdetails_id=$("#findtenant").val();

        var getuserdetailsurl = '{{ route("gettenant.details") }}'; 
        $.ajax({
            type:'get',
            url:getuserdetailsurl,
            data:{
                'id':tenantdetails_id
            },
            success:function(data){
            data.forEach((user)=>{
                console.log(user);
                $('#addpayrental_name').val(user.rentalhses.rental_name);
                console.log(user.hserooms);

                var roomsobject = user.hserooms;
                var roomsarray = $.map(roomsobject, function(el) { 
                    return el['room_name']; 
                });

                $('#addpayhouse_rooms').val(roomsarray);

                var roomsprice = $.map(roomsobject, function(el) { 
                    return el['roomsize_price']; 
                });

                totalamounttopay = roomsprice.map(Number);

                var total =totalamounttopay.reduce(function(a,b){  return a+b },0);

                var numberofrms=roomsobject.length;
                var totalamountofrent = user.rentalhses.monthly_rent * numberofrms;

                if (numberofrms>1)
                {
                    if(user.rentalhses.is_addedtags == 0)
                    {
                        $('#addpaytotal_rent').val(totalamountofrent);
                    } else 
                    {
                        $('#addpaytotal_rent').val(total);
                    }
                }
                else
                {
                    if(user.rentalhses.is_addedtags == 1)
                    {
                        $('#addpaytotal_rent').val(total);
                    } else 
                    {
                        $('#addpaytotal_rent').val(totalamountofrent);
                    }
                }
            });    
            },error:function(){
            }
        });
    });

    // Activate a payment a user didnt confirm
    $(document).on('change','.mpesapaymentstatus',function(e)
    {
        var status=$(this).prop('checked')==true? 1:0;
        var mpesapayment_id=$(this).data('id');
        $.ajax({
            type:"GET",
            dataType:"json",
            url:'{{ route('updatepayment.status') }}',
            data:
            {'status':status,
            'mpesapayment_id':mpesapayment_id
                },
            success:function(data){
                console.log(data.message);
                alertify.set('notifier','position', 'top-right');
                alertify.success(data.message);
            }
        });
    });
    
  </script>
@stop


