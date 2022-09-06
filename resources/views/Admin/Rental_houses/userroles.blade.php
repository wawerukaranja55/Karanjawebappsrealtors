@extends('Admin.adminmaster')
@section('title','User Roles Management')
@section('content')
<div class="row" style="padding:5px;">
    <div class="col-md-12">
        <div class="panel-heading mt-5" style="text-align: center;"> 
            <h3 class="mb-2 text-dark panel-title">Add a New User Role</h3> 
        </div>
        
        <div class="panel-body">
            <form action="javascript:void(0)" id="addarole" class="form-horizontal addrole" role="form" method="POST">
                @csrf
                <div class="form-group">
                    <label for="role_name" style="font-size: 1.5rem margin-top:5px;" class="control-label">User Role Name</label>
                    
                    <div class="col-sm-10 bg-dark" style="margin-top: 5px; border:2px solid black">
                        <input type="text" style="font-size: 1.3rem" class="form-control text-dark" required name="role_name" id="role_name" placeholder="Write The Role name here">
                    </div> 
                </div>      
                <br>
                <div class="form-group">
                    <div class="col-sm-10">
                        <button type="submit" id="submit" class="btn btn-primary">Upload</button>
                    </div>
                </div>    
            </form>
        </div>

        <div class="row shadow mb-5 bg-black rounded">
            <div class="col-lg-12">
                <div class="panel-heading mt-5" style="text-align: center;"> 
                    <h3 class="mb-2">All User Roles</h3> 
                </div>
                <table id="userrolestable" class="table table-striped table-bordered" style="width:120%; margin-top:5px; margin-right:100px;">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
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
              { data: 'status',name:'status',orderable:false,searchable:false },
              { data: 'action',name:'action',orderable:false,searchable:false },
          ],

          rowCallback: function ( row, data ) {
                $('input.rentalcatstatus', row)
                .prop( 'checked', data.status == 1 )
                .bootstrapToggle();
            }
        });

        //  update role_name status from active to inactive
        // $(document).on('change','.userrolestatus',function(e)
        // {
        //     var rolenamestatus=$(this).prop('checked')==true? 1:0;

        //     var rolenameid=$(this).data('id');

        //     $.ajax({
        //         type:"GET",
        //         dataType:"json",
        //         url:'{{ route('updaterolename.status') }}',
        //         data:{
        //             'status':rolenamestatus,
        //             'id':rolenameid
        //         },
        //         success:function(res){
        //             console.log(res);
        //             userolestable.ajax.reload();
        //             alertify.set('notifier','position', 'top-right');
        //             alertify.success(res.message);
        //         }
        //     });
        // });

                // add a new role for the users
        $(document).ready(function(){
            var url = '{{ route("addrole.name") }}';        
            $("#addarole").on("submit",function(e){
                e.preventDefault();
                $.ajax({
                    url:url,
                    type:"POST",
                    data:$("#addarole").serialize(),
                    success:function(response){

                        console.log(response.status);
                        if (response.status==400)
                        {
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(response.message);

                        } else if (response.status==200)
                        {
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(response.message);
                            userrolestable.ajax.reload();
                        }
                    }
                });
            })
        });

        // show modal for editin role name
        $(document).on('click','.edituserrole',function(){
            var userroleid=$(this).data('id');

            $.ajax({
                url:'{{ url("admin/userrole",'') }}' + '/' + userroleid + '/edit',
                method:'GET',
                success:function(response){
                console.log(response);
                $('.propertycategory').modal('show');
                $('.modal-title').html('Edit User Role');
                $('.catlabel').html('Role Name');
                $('.save_button').html('Update User Role');
                $('#property_category').hide('');
                $('#rental_tagname').show();
                $('.taginput').val(response.role_name);
                $('#rentaltag_id').val(response.id);

                }
            })
        });

            //   update rental tags details
        $(document).on('click','.save_button',function(){

            var userroleid=$('#rentaltag_id').val();

            var url = '{{ route("userrole.update", ":id") }}';
            updateroleurl = url.replace(':id', userroleid);

            var form = $('.propertcat_form')[0];
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
                        $('.propertycategory').modal('hide');
                        
                        $('.catinput').val('');
                        $('#propertycat_id').val('');

                    } else if (response.status==200)
                    {
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(response.message);
                        userrolestable.ajax.reload();
                        $('.propertycategory').modal('hide'); 
                        $('.catinput').val('');
                        $('#propertycat_id').val('');
                    }

                }
            });
        })
        
        // Delete role from the db
        $(document).on('click','#deleterentalrole',function(){

            var deleteroleid=$(this).data('id');

            $('.removepropertycategory').modal('show');
            $('.modal-title').html('Delete Role');
            $('.propertycatlabel').html('Are You Sure You Want To Delete this Role?');
            $('#userrole_id').val(deleteroleid);
        });

        $(document).on('click','#deletepropertycategory',function(){
                var deleteuserroleid=$('#userrole_id').val();

                $.ajax({
                    type:"DELETE",
                    url:'{{ url("admin/delete_userrole",'') }}' + '/' + deleteuserroleid,
                    dataType:"json",
                    success:function(response)
                    {
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(response.message);
                        userrolestable.ajax.reload();
                        $('.modal-title').html('');
                        $('.propertycatlabel').html('');
                        $('.removepropertycategory').modal('hide');
                    }
                });
            });


    </script>
@stop