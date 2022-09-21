@extends('Admin.adminmaster')
@section('title','Tags And Category Management')
@section('content')

<div class="row">
    <div class="col-md-6">
        <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">Rental Tags Management</h3>

        <form action="javascript:void(0)" id="addatag" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
            @csrf
            <div class="form-group">
                <label for="tagtitle" style="font-size: 1.5rem margin-top:5px;" class="control-label">Rental Tag</label>
                
                <div class="bg-dark" style="margin-top: 5px;">
                    <input type="text" style="font-size: 1.3rem" class="form-control text-dark" required name="rentaltagtitle" id="rental_tagtitle" placeholder="Write A New Tag Here">
                </div> 
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>   
        </form>

        <table id="rentalhsetags" class="table table-striped table-bordered nowrap" style="width:100%; margin-top:50px;">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Tag Name</th>
                    <th>Status</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <div class="col-md-6">
        <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">Rental Categories Management</h3>

        <form action="javascript:void(0)" id="rentalcategory" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
            @csrf
            <div class="form-group">
                <label for="rental_cat" style="font-size: 1.5rem margin-top:5px;" class="control-label">Rental Hse Category</label>
                
                <div class="bg-dark" style="margin-top: 5px;">
                    <input type="text" style="font-size: 1.3rem" class="form-control text-dark" required name="rentalhsecategory" id="rentalhsecat" placeholder="Write The Rental House Category">
                </div> 
            </div>
            <div class="form-group">
                <label for="rental_cat" style="font-size: 1.5rem margin-top:5px;" class="control-label">Rental Category Slug</label>
                
                <div class="bg-dark" style="margin-top: 5px;">
                    <input type="text" style="font-size: 1.3rem" class="form-control text-dark" required name="rentalcategoryslug" id="rentalcategoryslug" placeholder="Write The Rental House Category">
                </div> 
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>   
        </form>

        <div class="col-md-12">
            <table id="rentalcatstable" class="table table-striped table-bordered" style="width:100%; margin-top:50px;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Rental House Category</th>
                        <th>Status</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('rentaltagsmgmtscript')
    <script>
            
        // show all rental tags for rental houses in a datatable
        var rentalhousestagstable = $('#rentalhsetags').DataTable({
            processing:true,
            serverside:true,
            responsive:true,
            ajax:"{{ route('get_rentaltags') }}",
            columns: [
                { data: 'id' },
                { data: 'rentaltag_title' },
                { data: 'status',
                        render: function ( data, type, row ) {
                            if ( type === 'display' ) {
                                return '<input class="toggle-class rentaltagstatus" type="checkbox" checked data-toggle="toggle" data-id="' + row.id + '" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
                            }
                            return data;
                        }
                    },
                { data: 'edit',name:'edit',orderable:false,searchable:false },
            ],
            rowCallback: function ( row, data ) {
                $('input.rentaltagstatus', row)
                .prop( 'checked', data.status == 1 )
                .bootstrapToggle();
            }
        });

        //  update rental tag status from active to inactive
        $(document).on('change','.rentaltagstatus',function(e)
        {
            var tagstatus=$(this).prop('checked')==true? 1:0;
            var rentaltagid=$(this).data('id');
            $.ajax({
                type:"GET",
                dataType:"json",
                url:'{{ route('updaterentaltagstatus') }}',
                data:{
                    'status':tagstatus,
                    'id':rentaltagid
                },
                success:function(res){
                    console.log(res);
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(res.message);
                }
            });
        });
                // add a new tag for the rental houses
        $(document).ready(function(){
            var url = '{{ route("addrentaltag") }}';        
            $("#addatag").on("submit",function(e){
                e.preventDefault();
                $.ajax({
                    url:url,
                    type:"POST",
                    data:$("#addatag").serialize(),
                    success:function(response){
                        rentalhousestagstable.ajax.reload();
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
        });
        
            // show modal for editin rental tag
        $(document).on('click','.editrentaltag',function(e){
            e.preventDefault();
            var rentaltagid=$(this).data('id');
            $.ajax({
                url:'{{ url("admin/rentaltag",'') }}' + '/' + rentaltagid + '/edit',
                method:'GET',
                success:function(response){
                console.log(response);
                $('.adminedit').modal('show');
                    $('.adminedit').modal('show');
                    $('.propertycat_id').html('');
                    $('.location_id').html('');
                    $('.rolename_id').html('');
                    $('.room_id').html('');

                    $('#property_category').html('');
                    $('#location_name').html('');
                    $('#roomsize_name').html('');
                    $('#room_name').html('');
                    $('#role_name').html('');

                    $('#property_category').hide().prop('required',false);
                    $('#location_name').hide().prop('required',false);
                    $('#roomsize_name').hide().prop('required',false);
                    $('#room_name').hide().prop('required',false);
                    $('#role_name').hide().prop('required',false);
                    
                    $('.modal-title').html('Edit Tag Details');
                    $('.catlabel').html('Rental Tag Name');
                    $('.save_button').html('Update Rental Tag');
                    $('#rentaltag_id').val(response.id);
                    $('#rental_tagname').val(response.rentaltag_title);
                }
            })
        });

            //   update rental tags details
        $(document).on('click','.save_button',function(e){
            e.preventDefault();
            
            $tagid=$('#rentaltag_id').val();
            var url = '{{ route("updaterentaltag", ":id") }}';

            updatetagurl = url.replace(':id', $tagid);
            var form = $('.adminedit_form')[0];
            var formdata=new FormData(form);
            
            $.ajax({
                url:updatetagurl,
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
                        $('.adminedit').modal('hide');
                    } else if (response.status==200)
                    {
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(response.message);
                        rentalhousestagstable.ajax.reload();
                        $('.adminedit').modal('hide');
                    }
                }
            });
        })
        
        
        // Delete rental tag from the db
        // $(document).on('click','#deleterentaltag',function(){
        //     var deletetagid=$(this).data('id');
        //     $('.admindeletemodal').modal('show');
        //     $('.modal-title').html('Delete Rental Tag');
        //     $('.adminmodallabel').html('Are You Sure You Want to Delete this Tag?');
        //     $('#rentaltag_id').val(deletetagid);
        // })
        // $(document).on('click','#deletemodalbutton',function()
        // {
        //     var deletetagid=$('#rentaltag_id').val();
        //     $.ajax({
        //         type:"DELETE",
        //         url:'{{ url("admin/delete_rentaltag",'') }}' + '/' + deletetagid,
        //         dataType:"json",
        //         success:function(response)
        //         {
        //             alertify.set('notifier','position', 'top-right');
        //             alertify.success(response.message);
        //             rentalhousestagstable.ajax.reload();
        //             $('.admindeletemodal').modal('hide');
        //             $('.modal-title').html('');
        //             $('.adminmodallabel').html('');
        //             $('#rentaltag_id').val('');
        //         }
        //     })
        // })
                // Rental Categories Management
        // show all rental categories for rental houses in a datatable
        var rentalhousescatstable = $('#rentalcatstable').DataTable({
            processing:true,
            serverside:true,
            responsive:true,
            ajax:"{{ route('get_rentalcats') }}",
            columns: [
                { data: 'id' },
                { data: 'rentalcat_title' },
                { data: 'status',
                    render: function ( data, type, row ) {
                        if ( type === 'display' ) {
                            return '<input class="toggle-class rentalcatstatus" type="checkbox" checked data-toggle="toggle" data-id="' + row.id + '" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
                        }
                        return data;
                    }
                },
                { data: 'edit',name:'edit',orderable:false,searchable:false },
            ],
            rowCallback: function ( row, data ) {
                $('input.rentalcatstatus', row)
                .prop( 'checked', data.status == 1 )
                .bootstrapToggle();
            }
        });
        
                // add a new category for the rental houses
        $(document).ready(function(){
                  
            $("#rentalcategory").on("submit",function(e){
                e.preventDefault();
                var url = '{{ route("addrentalcat") }}';

                $.ajax({
                    url:url,
                    type:"POST",
                    data:$("#rentalcategory").serialize(),
                    success:function(response){
                        console.log(response.message);
                        rentalhousescatstable.ajax.reload();
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
        });
                
                // edit rental category
        $(document).on('click','.editrentalcat',function(e){
            e.preventDefault();
            var rentalcatid=$(this).data('id');
            $.ajax({
                url:'{{ url("admin/rentalcat",'') }}' + '/' + rentalcatid + '/edit',
                method:'GET',
                success:function(response){
                console.log(response);
                $('.rentalhsecategory').modal('show');
                $('.modal-title').html('Edit Rental Category');
                $('.catlabel').html('Rental Category Name');
                $('.catinput').val(response.rentalcat_title);
                $('.catsluglabel').html('Rental Slug Category');
                $('.catsluginput').val(response.rentalcat_url);
                $('#rentalhsecat_id').val(response.id);
                }
            })
        });
        
            //   update rental category details
        $(document).on('click','.update_button',function(e){
            e.preventDefault();
            
            $catid=$('#rentalhsecat_id').val();
            var url = '{{ route("updaterentalcat", ":id") }}';
            updatecaturl = url.replace(':id', $catid);

            var form = $('.updatepropertcat_form')[0];
            var formdata=new FormData(form);
            
            $.ajax({
                url:updatecaturl,
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
                        rentalhousescatstable.ajax.reload();
                        $('.rentalhsecategory').modal('hide');
                        $('.rentalhsecat_id').val('');
                        $('#rentalhse_category').val('');
                    } else if (response.status==400)
                    {
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(response.message);
                        $('.rentalhsecategory').modal('hide');
                        $('.rentalhsecat_id').val('');
                        $('#rentalhse_category').val('');
                    }
                }
            });
        })

        //  update rental category status from active to inactive
        $(document).on('change','.rentalcatstatus',function(e)
        {
            var catstatus=$(this).prop('checked')==true? 1:0;
            var rentalcatid=$(this).data('id');
            $.ajax({
                type:"GET",
                dataType:"json",
                url:'{{ route('updaterentalcatstatus') }}',
                data:{
                    'status':catstatus,
                    'id':rentalcatid
                },
                success:function(res){
                    console.log(res);
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(res.message);
                }
            });
        });
        // Delete Rental category from the db
        $(document).on('click','#deleterentalcat',function(){
            var deletecatid=$(this).data('id');
            $('.admindeletemodal').modal('show');
            $('.modal-title').html('Delete Rental Category');
            $('.adminmodallabel').html('Are You Sure You Want to Delete this Category?');
            $('#rentalcat_id').val(deletecatid);
        })
        $(document).on('click','#deletemodalbutton',function()
        {
            var deletecatid=$('#rentalcat_id').val();  
            $.ajax({
                type:"DELETE",
                url:'{{ url("admin/delete_rentalcat",'') }}' + '/' + deletecatid,
                dataType:"json",
                success:function(response)
                {
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(response.message);
                    rentalhousescatstable.ajax.reload();
                    $('.admindeletemodal').modal('hide');
                    $('.modal-title').html('');
                    $('.adminmodallabel').html('');
                    $('#rentalcat_id').val('');
                    
                }
            })
        })
    </script>
@stop