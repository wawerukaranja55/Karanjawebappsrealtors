@extends('Admin.adminmaster')
@section('title','User Roles Management')
@section('content')
<div class="row" style="
    display: flex;
    justify-content: center;">
   <div class="col-md-3">
      <a class="btn btn-dark" href="{{ url('admin/assign_userroles') }}">All Tenants and Admins</a>
   </div>
   <div class="col-md-3">
      <a class="btn btn-dark" href="{{ route('activerentalhses') }}">Activated Rental Houses</a>
   </div>
   <div class="col-md-3">
      <a class="btn btn-dark" href="{{ route('active.properties') }}">Activated Properties</a>
   </div>
</div>

<div class="row">
  <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">Tenant Status Management</h3>
  <div class="col-lg-12">
    <table id="userrolestable" class="table table-striped table-bordered" style="width:100%; margin:50px;">
      <thead>
        <tr>
          <th>Id</th>
          <th>Name</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>
@endsection

@section('userrolesmgmtscript')
    <script>
        
        // show all rental tags for rental houses in a datatable
        var userrolestable = $('#userrolestable').DataTable({
          processing:true,
          serverside:true,
          responsive:true,

          ajax:"{{ route('get_user.roles') }}",
          columns: [
              { data: 'id' },
              { data: 'role_name' },
              { data: 'status',
                render: function ( data, type, row ) {
                    if ( type === 'display' ) {
                        return '<input class="toggle-class userrolestatus" type="checkbox" checked data-toggle="toggle" data-id="' + row.id + '" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
                    }
                    return data;
                }
            }
          ],

          rowCallback: function ( row, data ) {
            $('input.userrolestatus', row)
            .prop( 'checked', data.status == 1 )
            .bootstrapToggle();
          }
        });

        //  update role_name status from active to inactive
        $(document).on('change','.userrolestatus',function(e)
        {
            var rolenamestatus=$(this).prop('checked')==true? 1:0;

            var rolenameid=$(this).data('id');

            $.ajax({
                type:"GET",
                dataType:"json",
                url:'{{ route('updaterole.status') }}',
                data:{
                    'status':rolenamestatus,
                    'id':rolenameid
                },
                success:function(res){
                    console.log(res);
                    userrolestable.ajax.reload();
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(res.message);
                }
            });
        });


        // show modal for editin role name
        $(document).on('click','.editrolename',function(){
            var userroleid=$(this).data('id');

            $.ajax({
                url:'{{ url("admin/userrole",'') }}' + '/' + userroleid + '/edit',
                method:'GET',
                success:function(response){
                    console.log(response);
                    $('#admineditmodal').modal('show');
                    $('#property_category').hide();
                    $('#rental_tagname').hide();
                    $('#location_name').hide();
                    $('#roomsize_name').hide();
                    $('#room_name').hide();

                    $('.modal-title').html('Edit User Role');
                    $('.catlabel').html('Role Name');
                    $('.save_button').html('Update User Role');
                    $('#role_name').val(response.role_name);
                    $('#rolename_id').val(response.id);

                }
            })
        });

        //   update Role name details
        $(document).on('submit','.save_button',function()
        {

            var url = '{{ route("userrole.update", ":id") }}';
            updateroleurl = url.replace(':id', userroleid);

            var form = $('.adminedit_form')[0];
            var formdata=new FormData(form);
        
            $.ajax({
                url:updateroleurl,
                method:'POST',
                processData:false,
                contentType:false,
                data:formdata,
                success:function(response)
                {
                    console.log(response.status);
                    if (response.status==400)
                    {
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(response.message);
                        $('.modal-title').html('');
                        $('.catlabel').html('');
                        $('.save_button').html('');
                        $('#admineditmodal').modal('hide');

                    } else if (response.status==200)
                    {
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(response.message);
                        userrolestable.ajax.reload();
                        $('.modal-title').html('');
                        $('.catlabel').html('');
                        $('.save_button').html('');
                        $('#admineditmodal').modal('hide');
                    }

                }
            });
        });


    </script>
@stop