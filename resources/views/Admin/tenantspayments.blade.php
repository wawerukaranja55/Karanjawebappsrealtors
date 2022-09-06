@extends('Admin.adminmaster')
@section('title','All Mpesa Payments By Registered Tenants')
@section('content')
<div class="row" style="margin-top: 50px;">
    <div class="col-md-3" style="margin: 3px;">
        <a class="btn btn-success" href="{{ url('admin/rental_houses') }}">All Rental Houses</a>  
    </div>
    <div class="col-md-3" style="margin: 3px;">
        <a class="btn btn-success" href="{{ url('admin/properties') }}">All Properties to Sell</a> 
    </div>
    <div class="col-md-3" style="margin: 3px;">
        <a class="btn btn-success" href="{{ url('admin/mpesa_payments') }}">All Mpesa Payments</a> 
    </div>
    <div class="col-md-3" style="margin: 3px;">
        <a class="btn btn-success" href="{{ url('admin/registered_users') }}">All Registered Tenants</a> 
    </div>
</div>
<div class="row" style="margin-top: 50px;">
    <div class="col-md-12">
        <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">All Mpesa Payments by Registered Tenants</h3>

        <div class="col-md-12">
            <table id="mpesapaymentstable" class="table table-striped table-bordered" style="width:100%; margin-top:50px;">
                <thead>
                    <tr>
                        <td>id</td>
                        <td>Tenant Name</td>
                        <td>Number That Paid</td>
                        <td>Amount Paid</td>
                        <td>Payment Confirmed By Tenant</td>
                        <td>Date Paid</td>
                        <td>Mpesa Transaction Code</td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection


@section('mpesapaymentscript')
  <script>

    // show all the mpesa payments
    var mpesapaymentstable = $('#mpesapaymentstable').DataTable({
          processing:true,
          serverside:true,
          responsive:true,

          ajax:"{{ route('get_mpesa.payments') }}",
          columns: [
              { data: 'id' },
              { data: 'tenant_name' },
              { data: 'phone' },
              { data: 'amount' },
              { data: 'mpesastatus',
                      render: function ( data, type, row ) {
                          if ( type === 'display' ) {
                              return '<input class="mpesapaymentstatus" type="checkbox" checked data-toggle="toggle" data-id="' + row.id + '" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
                          }
                          return data;
                      }
                  },
            //   { data: 'mpesastatus',name:'mpesastatus',orderable:false,searchable:false },
              { data: 'created_at',name:'created_at',orderable:false,searchable:false },
              { data: 'mpesatransaction_id' },
          ],

          rowCallback: function ( row, data ) {
            $('input.mpesapaymentstatus', row)
            .prop( 'checked', data.mpesastatus == 1 )
            .bootstrapToggle();
          }
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


