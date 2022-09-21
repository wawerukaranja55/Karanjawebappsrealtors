@extends('Admin.adminmaster')
@section('title','Rental Houses and Property Locations Management')
@section('content')
<h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px; margin-top:30px;">Rental Houses and Property Locations Management</h3>
<div class="row">
    <div class="col-md-5">
        <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">Add A New Location</h3>

        <form action="javascript:void(0)" id="addalocation" class="form-horizontal" role="form" method="POST">
            @csrf
            <div class="form-group">
                <label for="rentallocation_title" style="font-size: 1.5rem margin-top:5px;" class="control-label">Location Name</label>
                
                <div class="bg-dark" style="margin-top: 5px;">
                    <input type="text" style="font-size: 1.3rem" class="form-control text-dark" required name="location_title" id="rentallocation_title" placeholder="Write The Location Name Here">
                </div> 
            </div>
            <br>
            <ul class="alert alert-warning d-none" id="show_errorlist"></ul> 
            <br>
            <div class="form-group">
                <div class="col-sm-10">
                    <button type="submit" id="submit" class="btn btn-primary">Upload</button>
                </div>
            </div>    
        </form>
    </div>

    <div class="col-md-7">
        <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">All Locations</h3>

        <table id="locationstable" class="table table-striped table-bordered" style="width:100%; margin-top:50px;">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Location Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

    </div>
</div>

@endsection

@section('locationsmgmtscript')
    <script>

        // show all rental tags for rental houses in a datatable
        var locationstable = $('#locationstable').DataTable({
          processing:true,
          serverside:true,
          responsive:true,

          ajax:"{{ route('get.locations') }}",
          columns: [
              { data: 'id' },
              { data: 'location_title' },
              { data: 'status',
                    render: function ( data, type, row ) {
                        if ( type === 'display' ) {
                            return '<input class="toggle-class locationstatus" type="checkbox" checked data-toggle="toggle" data-id="' + row.id + '" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
                        }
                        return data;
                    }
                },
              { data: 'action',name:'action',orderable:false,searchable:false },
          ],

          rowCallback: function ( row, data ) {
            $('input.locationstatus', row)
            .prop( 'checked', data.status == 1 )
            .bootstrapToggle();
          }
        });

        
        // manage the locations in the database
        $(document).ready(function(){
            $("#addalocation").on("submit",function(s){
                s.preventDefault();
                $.ajax({
                url:"addalocation",
                type:"POST",
                data:$("#addalocation").serialize(),
                success:function(result){
                    console.log(result);
                        if (result.status==400)
                        {
                            $('#show_errorlist').html(" ");
                            $('#show_errorlist').removeClass('d-none');
                            $.each(result.message,function(key,err_value)
                            {
                                $('#show_errorlist').append('<li>' + err_value + '</li>');
                            })

                        } else if (result.status==404)
                        {
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(result.message);
                        }
                        
                        else if (result.status==200)
                        {
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(result.message);
                            locationstable.ajax.reload();
                        }
                },
                });
            });
        });

        //  update location status from active to inactive
        $(document).on('change','.locationstatus',function(e)
        {
            var locationstatus=$(this).prop('checked')==true? 1:0;

            var locationid=$(this).data('id');
            $.ajax({
                type:"GET",
                dataType:"json",
                url:'{{ route('updatelocation.status') }}',
                data:{
                    'status':locationstatus,
                    'id':locationid
                },
                success:function(res){
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(res.message);
                }
            });
        });

        // show modal for editing Location Details
        $(document).on('click','.editlocation',function(e){
            e.preventDefault();
            var locationid=$(this).data('id');

            $.ajax({
                url:'{{ url("admin/location",'') }}' + '/' + locationid + '/edit',
                method:'GET',
                success:function(response){
                    $('#admineditmodal').modal('show');
                    $('.propertycat_id').html('');
                    $('.rolename_id').html('');
                    $('.room_id').html('');
                    $('#rentaltag_id').val('');
                    

                    $('#property_category').html('');
                    $('#rental_tagname').html('');
                    $('#roomsize_name').html('');
                    $('#room_name').html('');
                    $('#role_name').html('');

                    $('#property_category').hide().prop('required',false);
                    $('#rental_tagname').hide().prop('required',false);
                    $('#roomsize_name').hide().prop('required',false);
                    $('#room_name').hide().prop('required',false);
                    $('#role_name').hide().prop('required',false);

                    $('.modal-title').html('Edit Location Details');
                    $('.catlabel').html('Location Name');
                    $('.save_button').html('Update Location Name');
                
                    $('#location_id').val(response.id);
                    $('#location_name').val(response.location_title);

                }
            })
        });

            //   update location details
        $(document).on('click','.save_button',function(e){
            e.preventDefault();
            
            $locationid=$('#location_id').val();

            var url = '{{ route("update.location", ":id") }}';
            updatelocationurl = url.replace(':id', $locationid);

            var form = $('.adminedit_form')[0];
            var formdata=new FormData(form);

            $.ajax({
                url:updatelocationurl,
                method:'POST',
                processData:false,
                contentType:false,
                data:formdata,
                success:function(response)
                {
                    console.log(response);
                    if (response.status==200)
                    {
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(response.message);
                        locationstable.ajax.reload();
                        $('#admineditmodal').modal('hide');
                    }
                    else if (response.status==404)
                    {
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(response.message);
                        $('#admineditmodal').modal('hide');
                    } 

                }
            });
        });

        // Delete a location from the db
        $(document).on('click','#deletelocation',function(){

            var locationsid=$(this).data('id');

            $('.admindeletemodal').modal('show');
            $('.modal-title').html('Delete The Location');
            $('.adminmodallabel').html('Are You Sure You Want to Delete this Location?');
            $('#locatn_id').val(locationsid);

            })

            $(document).on('click','#deletemodalbutton',function()
            {
            var locationsid=$('#locatn_id').val();  

            $.ajax({
                type:"DELETE",
                url:'{{ url("admin/delete_location",'') }}' + '/' + locationsid,
                dataType:"json",
                success:function(response)
                {
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(response.message);
                    locationstable.ajax.reload();
                    $('.admindeletemodal').modal('hide');
                    $('.modal-title').html('');
                    $('.adminmodallabel').html('');
                    $('#locatn_id').val('');
                    
                }
            })
            })
    </script>
@stop