
@extends('Admin.adminmaster')
@section('title','Edit Alternate Images,Room names and House Sizes')
@section('content')

<?php use App\Models\Rentalhousesize; ?>

<div class="row" style="
    display: flex;
    justify-content: center;">
   <div class="col-md-3">
      <a class="btn btn-dark" href="{{ url('admin/inactiverentals') }}">Inactive Rental Houses</a>
   </div>
   <div class="col-md-3">
    <a class="btn btn-dark" href="{{ url('admin/activerentals') }}">Activated Rental Houses</a>
 </div>
   <div class="col-md-3">
      <a class="btn btn-dark" href="{{ route('addrentalhse') }}">Add a New Rental House</a>
   </div>
   <div class="col-md-3">
      <a class="btn btn-dark" href="{{ route('alllocations.index') }}">Add a New Location</a>
   </div>
</div>
    {{-- Add Rental House Extra Images--}}
    <div class="panel-heading mt-5" style="text-align: center; font-size:18px; background-color:black;"> 
        <h3 class="panel-title">Edit the Rental Houses Rooms,Images and House Sizes</h3> 
    </div>

    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-6">
            @if (!empty($rentaldata->rental_video))

                <h3>Change video for the Rental house</h3>
                <div class="changehsevideo">
                    <form action="{{ url('admin/addrentalvideo/'.$rentaldata->id) }}" class="dropzone form-horizontal dropzone-videoform" role="form" method="POST" enctype="multipart/form-data">
                        @csrf
                    </form>
                </div>
                <video class="video-js" controls preload="auto" width="100%" height="100" margin-top="10px" data-setup="{}">
                    <source src="/videos/rentalvideos/{{$rentaldata->rental_video}}" type='video/mp4'>
                </video>
                <a class="confirmvideodelete" href="javascript:void(0)" data-id="{{ $rentaldata->id }}">Delete Video and Replace it</a> 
            @else
                <h3>Add a video for the Rental house <span class="font-type:italics;">(optional)</span></h3>
                <form action="{{ url('admin/addrentalvideo/'.$rentaldata->id) }}" class="dropzone form-horizontal dropzone-videoform" role="form" method="POST" enctype="multipart/form-data">
                    @csrf
                </form>
            @endif
            
        </div>
    </div>
    {{-- @if ($hsermsizes>0)
        <div class="row">
            <div class="col-lg-8">
                <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">Edit Room Sizes for Rental House {{ $rentaldata->rental_name }}</h3>
                <form action="javascript:void(0)" class="form-horizontal" id="updateroomsizesform" role="form" method="POST">
                    @csrf
                    <div class="card product-card">
                        <div class="card-body">
                            <div class="form-group">
                                <table id="editrentalhsesizes" class="table table-striped table-bordered nowrap" style="width:90%;">
                                    <thead>
                                        <tr>
                                            <th>Rentalhouse id</th>
                                            <th>Room Size</th>
                                            <th>Total Rooms</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <button type="submit" id="updateroomsizesbtn" class="btn btn-success">Update the Room Size Price</button>
                        <ul class="alert alert-warning d-none" id="update_hsesizelist"></ul>
                    </div>
                </form>
            </div>
        </div>
    @endif --}}

    <div class="row">
        <div class="col-md-5">
            <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">Add Extra images for {{ $rentaldata->rental_name }}</h3>
            <input type="hidden" id="editimages_id" class="editroomimageid" value="{{ $rentaldata->id }}" >
            <div class="form_group">
                <div class="d-flex">
                    <label>1.House Name</label>:&nbsp;&nbsp;&nbsp;{{ $rentaldata->rental_name }}
                </div>
            </div>
            
            <div class="form_group">
                <div class="d-flex">
                    <label>2.House Location</label>:&nbsp;&nbsp;&nbsp;{{ $rentaldata->houselocation['location_title'] }}
                </div>
            </div>
            <form id="editdropzone-form" action="{{ url('admin/alternateimages/'.$rentaldata->id) }}" class="dropzone form-horizontal" role="form" method="POST" enctype="multipart/form-data">
                @csrf
            </form>

            <table id="editrentalhseimages" class="table table-striped table-bordered nowrap addimages" style="width:18%; margin-top:70px;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="col-md-7">
            <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">Room Names Management</h3>
            <div class="col-md-12">
                <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Room Size</th>
                            <th>Room Size Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('editimagesroomsscripts')
    <script>
        
        // scroll to the edit form div
        // $("#editrentaldetails").on('click',function() {
            
        //     $('html, body').animate({
        //         'scrollTop' : $("#edithousedata").position().top
        //     });
        // });

        // upload a house video for that rental house using dropzone.js
        Dropzone.autoDiscover = false;
        var dzonerentalvideo = new Dropzone(".dropzone-videoform",{
            maxFilesize: 20000,
            maxFiles: 1,
            acceptedFiles: ".Mp4"
        });

        dzonerentalvideo.on("success",function(file,response){
            console.log(response)
            if(response.status == 200)
            {
                alertify.set('notifier','position', 'top-right');
                alertify.success(response.message);
                
            }
        });

        // Delete house video from the db
        $(document).on('click','.confirmvideodelete',function(){

            var deletehsevideoid=$(this).data('id');

            $('.admindeletemodal').modal('show');
            $('.modal-title').html('Delete House Video');
            $('#housevideo_id').val(deletehsevideoid);

        })

        $(document).on('click','#deletemodalbutton',function()
        {

            var housevideoid=$('#housevideo_id').val();

            $.ajax({
                type:"DELETE",
                url:'{{ url("admin/delete-rentalvideo",'') }}' + '/' + housevideoid,
                data:{housevideo_id: housevideoid},
                success:function(response)
                {
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(response.message);
                    $('.changehsevideo').show("1000");
                    $('.video-js').hide("1000");
                    $('.confirmvideodelete').hide("2000");
                    $('.admindeletemodal').modal('hide');
                    $('#housevideo_id').val('');
                }
            })
        })

        // show all rooms of the house in a datatable
        var roomhseid=$('.editroomimageid').val();
        var url = '{{ route("get_roomnames", ":id") }}';
        url = url.replace(':id', roomhseid);
        var roomnamestable = $('.roomnamestable').DataTable({
            processing:true,
            serverside:true,
            reponsive:true,

            ajax:
            {
                url:url,
                type: 'get',
                dataType: 'json',
                data:{
                    'id':roomhseid
                },
            },
            columns: [
                { data: 'id' },
                { data: 'room_name' },
                { data: 'is_roomsize', name:'is_roomsize.roomhsesizes', orderable:true,searchable:true},
                { data: 'roomsize_price', name:'roomsize_price', orderable:true,searchable:true},
                { data: 'status',
                    render: function ( data, type, row ) {
                        if ( type === 'display' ) {
                            return '<input class="toggle-demo" type="checkbox" checked data-toggle="toggle" data-id="' + row.id + '" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
                        }
                        return data;
                    }
                },
                // { data: 'status',
                //     render: function ( data, type, full, meta, row) {
                //     return '<input class="toggle-demo" type="checkbox" checked data-toggle="toggle" data-id="#" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
                //     }
                // },
                { data: 'action',name:'action',orderable:false,searchable:false },
            ],

            rowCallback: function ( row, data ) {
                $('input.toggle-demo', row)
                .prop( 'checked', data.status == 1 )
                .bootstrapToggle();
            }
        });

        // edit room details
        $(document).on('click','.editroomname',function(e){
            e.preventDefault();
            var roomid=$(this).data('id');

            $.ajax({
                url:'{{ url("admin/roomname",'') }}' + '/' + roomid + '/edit',
                method:'GET',
                success:function(response){
                    console.log(response);
                    $('#admineditmodal').modal('show');
                    $('#propertycat_id').val('');
                    $('#rentaltag_id').val('');
                    $('#property_category').hide();
                    $('#rental_tagname').hide();
                    $('#location_name').hide();
                    $('#room_id').val(response.room_name.id);

                    $('.modal-title').html('Edit Room Name');
                    $('.catlabel').html('Room Name Title');
                    $('.save_button').html('Update Room Name');

                    $('#editroom_name').val(response.room_name.room_name);

                        // show and hide the dropdown for room sizes
                    if (response.room_name.roomhsesizes.is_roomsize=='0')
                    {
                        $('#editchangeroomsizes').hide();
                        $('#editselectrmsize').val('');
                        
                    } 
                    else
                    {
                        // var roomsizesobject = response.roomhsesizes;
                        // var rmsizesarr = $.map(roomsizesobject, function(el) { 
                        //     return el['id']; 
                        // });
                        // //pass array object value to select2
                        // console.log(rmsizesarr);
                        $('#editselectrmsize').val(response.room_name.roomhsesizes.id).trigger('change');
                        // add room sizes for a house in the room sizes editing modal
                        console.log(response.roomsizesforahouse);
                        $('#editselectrmsize').html('<option disabled value=" ">Select Another Room Size</option>');
                            
                        console.log("the data is ",response.roomsizesforahouse);
                        response.roomsizesforahouse.forEach((rmsize)=>{
                            console.log(rmsize);
                            $('#editselectrmsize').append('<option value="'+rmsize.id+'">'+rmsize.room_size+'</option>');
                        });
                    }

                        // show and hide the input for room size prices
                    if (response.room_name.roomsize_price=='0')
                    {
                        $('#editchangeroomsize_price').hide();
                        $('#editroomsize_price').val('');
                        
                    } 
                    else
                    {
                        $('#editroomsize_price').val(response.room_name.roomsize_price).trigger('change');   
                    }
                

                }
            })
        });
        
        // show all house sizes for a house in a datatable
            // var roomhseid=$('.editroomimageid').val();
            // var url = '{{ route("get_roomsizes", ":id") }}';
            // url = url.replace(':id', roomhseid);
            // var editroomhsesizestable = $('#editrentalhsesizes').DataTable({
            //     processing:true,
            //     serverside:true,
            //     reponsive:true,

            //     ajax:
            //     {
            //         url:url,
            //         type: 'get',
            //         dataType: 'json',
            //         data:{
            //             'id':roomhseid
            //         },
            //     },
            //     columns: [
            //         { data: 'rentalhse_id',
            //             render: function ( data, type, row ) {
            //                 if ( type === 'display' ) {
            //                     return '<input readonly=" " name="rentalhse_id[]" style="width:150px" value="' + row.rentalhse_id + '">';
            //                 }
            //                 return data;
            //             },
            //         },
            //         { data: 'room_size' },
            //         // { data: 'roomsize_price',
            //         //     render: function ( data, type, row ) {
            //         //         if ( type === 'display' ) {
            //         //         return '<input type="number" name="roomsize_price[]" style="width:150px" value="' + row.roomsize_price + '">';
            //         //         }
            //         //         return data;
            //         //     }
            //         // },
            //         { data: 'total_rooms',
            //             render: function ( data, type, row ) {
            //                 if ( type === 'display' ) {
            //                 return '<input type="number" name="total_rooms[]" style="width:150px" value="' + row.total_rooms + '">';
            //                 }
            //                 return data;
            //             }
            //         },
            //     ],
            // });

        //   update room size details for a house
        $(document).on('submit','#updateroomsizesform',function()
        {
            var url = '{{ route("update.housesizedetails", ":id") }}';
            updatehseurl = url.replace(':id',roomhseid);

            var form = $('#updateroomsizesform')[0];
            var formdata=new FormData(form);

            $.ajax({
               url:updatehseurl,
               method:'POST',
               processData:false,
               contentType:false,
               data:formdata,
               success:function(response)
               {
                    console.log(response);
                    if (response.status==400)
                    {
                        $('#update_housesizelist').html(" ");
                        $('#update_housesizelist').removeClass('d-none');
                        $.each(response.message,function(key,err_value)
                        {
                            $('#update_housesizelist').append('<li>' + err_value + '</li>');
                            $("#update_housesizelist").fadeOut(10000);
                        })
                    } 
                    else if (response.status==404)
                    {
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(response.message);
                    }
                    else if (response.status==500)
                    {
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(response.message);
                    }
                    else if (response.status==200)
                    {
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(response.message);

                        $('#nav-profile-tab').removeClass("disabled").addClass("active");
                        $('#nav-home-tab').removeClass("active").addClass("disabled");

                        $('#nav-home').hide();
                        $('#nav-profile').show();

                        $('#selectrmsize').html('<option disabled selected value=" ">Select a Room Size to add Room Name/Number</option>');
                    
                        console.log("the data is ",response.data);
                        $.each(response.data, function(key, roomsize)
                        {
                            console.log(roomsize);
                            $('#selectrmsize').append('<option value="'+roomsize.room_size+'">'+roomsize.room_size+'</option>');
                        });
                        
                    }
               }
            });
        });

        
         // show all rooms of the house in a datatable
        var roomid=$('.editroomimageid').val();
        var url = '{{ route("get_roomnames", ":id") }}';
        url = url.replace(':id', roomid);
        var editroomnamestable = $('#editroomnamestable').DataTable({
            processing:true,
            serverside:true,
            reponsive:true,

            ajax:
            {
                url:url,
                type: 'get',
                dataType: 'json',
                data:{
                    'id':roomid
                },
            },
            columns: [
                { data: 'id' },
                { data: 'room_name' },
                { data: 'house_size' },
                { data: 'status',
                    render: function ( data, type, row ) {
                        if ( type === 'display' ) {
                            return '<input class="rmtoggle-demo" type="checkbox" checked data-toggle="toggle" data-id="' + row.id + '" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
                        }
                        return data;
                    }
                },
                { data: 'action',name:'action',orderable:false,searchable:false },
            ],

            rowCallback: function ( row, data ) {
                $('input.rmtoggle-demo', row)
                .prop( 'checked', data.status == 1 )
                .bootstrapToggle();
            }
        });

        // edit room details
        $(document).on('click','.editroomname',function(e){
            e.preventDefault();
            var roomid=$(this).data('id');

            $.ajax({
                url:'{{ url("admin/roomname",'') }}' + '/' + roomid + '/edit',
                method:'GET',
                success:function(response){
                $('#admineditmodal').modal('show');
                $('#propertycat_id').val('');
                $('#rentaltag_id').val('');
                $('#property_category').hide();
                $('#rental_tagname').hide();
                $('#location_name').hide();
                $('#roomsize_name').hide();
                $('#room_id').val(response.id);

                $('.modal-title').html('Edit Room Name');
                $('.catlabel').html('Room Name Title');
                $('.save_button').html('Update Room Name');

                $('#room_id').val(response.id);
                // $('#roomsize_name').val(response.house_size);
                $('#room_name').val(response.room_name);

                }
            })
        });

            //   update room details
        $(document).on('click','.save_button',function(e){
            e.preventDefault();
            
            var rmid=$('#room_id').val();

            var url = '{{ route("updateroomname", ":id") }}';
            updateroomurl = url.replace(':id', rmid);

            var form = $('.adminedit_form')[0];
            var formdata=new FormData(form);

            $.ajax({
                url:updateroomurl,
                method:'POST',
                processData:false,
                contentType:false,
                data:formdata,
                success:function(response)
                {
                    console.log(response);
                    if (response.status==400)
                    {
                        $('#admineditmodal').modal('hide');
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(response.message);
                        
                    } else if (response.status==200)
                    {
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(response.message);
                        editroomnamestable.ajax.reload();
                        $('#admineditmodal').modal('hide');
                            
                    }
                }
            });
        })

        // Delete xtra image from the db
        $(document).on('click','.deletehsextraimg',function(){

            var deletehseimgid=$(this).data('id');

            $('.admindeletemodal').modal('show');
            $('.modal-title').html('Delete Image');
            $('#xtraimg_id').val(deletehseimgid);

        })

        $(document).on('click','#deletemodalbutton',function()
        {

            var deleteimgid=$('#xtraimg_id').val();

            $.ajax({
            type:"DELETE",
            url:'{{ url("admin/delete_xtraimage",'') }}' + '/' + deleteimgid,
            dataType:"json",
            success:function(response)
            {
                alertify.set('notifier','position', 'top-right');
                alertify.success(response.message);
                alternateimagestable.ajax.reload();
                $('.admindeletemodal').modal('hide');
                $('#xtraimg_id').val('');
            }
            })
        })

        // show all images of the house in a datatable
        var roomimgid=$('.editroomimageid').val();
        var url = '{{ route("get_extraimages", ":id") }}';
            url = url.replace(':id', roomimgid);

        var alternateimagestable = $('#editrentalhseimages').DataTable({
        
            processing:true,
            serverside:true,
            reponsive:true,

            ajax:
            {
                url:url,
                type: 'get',
                dataType: 'json',
                data:{
                    'id':roomimgid
                },
            },
            columns: [
                { data: 'id' },
                { data: 'image',
                    render: function ( data, type, full, meta, row) {
                        return "<img src=\"/imagesforthewebsite/rentalhouses/alternateimages/small/" + data + "\" height=\"80px\" height=\"80px\"/>"
                    }
                },
                { data: 'status',
                    render: function ( data, type, row ) {
                        if ( type === 'display' ) {
                            return '<input class="activateimg" type="checkbox" checked data-toggle="toggle" data-id="' + row.id + '" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
                        }
                        return data;
                    }
                },
                { data: 'delete',name:'delete',orderable:false,searchable:false },
            ],

            rowCallback: function ( row, data ) {
                $('input.activateimg', row)
                .prop( 'checked', data.status == 1 )
                .bootstrapToggle();
            }
        });
        
        // add images using dropzone and add on the datatable without page refresh
        Dropzone.autoDiscover = false;
        var dzonerentalimages = new Dropzone("#editdropzone-form",{
            maxFilesize: 2,
            maxFiles: 5,
            acceptedFiles: ".jpeg,.jpg,.png"
        });

        dzonerentalimages.on("success",function(file,response){
            console.log(response.message)
            if(response.success == 1)
            {
                alertify.set('notifier','position', 'top-right');
                alertify.success(response.message);
                alternateimagestable.ajax.reload();
                
            }
        });

        //  update room status from active to inactive
        $(document).on('change','.rmtoggle-demo',function(e)
        {
            var rmstatus=$(this).prop('checked')==true? 1:0;

            var rentalhseid=$(this).data('id');
            $.ajax({
                type:"GET",
                dataType:"json",
                url:'{{ route('updateroomname.status') }}',
                data:{
                    'status':rmstatus,
                    'id':rentalhseid
                },
                success:function(res){
                    console.log(res);
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(res.message);
                }
            });
        });  

        //  update room status from active to inactive
        $(document).on('change','.activateimg',function(e)
        {
            var imgstatus=$(this).prop('checked')==true? 1:0;

            var rentalhseid=$(this).data('id');
            $.ajax({
                type:"GET",
                dataType:"json",
                url:'{{ route('updatextraimages.status') }}',
                data:{
                    'status':imgstatus,
                    'id':rentalhseid
                },
                success:function(res){
                    console.log(res);
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(res.message);
                }
            });
        });   

        // edit room details
        // $('body').on('click','.editroomname',function(){
        //     var roomid=$(this).data('id');

        //     $.ajax({
        //         url:'{{ url("admin/roomname",'') }}' + '/' + roomid + '/edit',
        //         method:'GET',
        //         success:function(response){
        //         console.log(response);
        //         $('.propertycategory').modal('show');
        //         $('.modal-title').html('Edit Room Name');
        //         $('.catlabel').html('Room Name');
        //         $('.save_button').html('Update Room Name');
        //         $('.rental_tagname').hide('');

        //         $('#propertycat_id').val(response.id);
        //         $('#property_category').val(response.room_name);

        //         },error:function(error){
        //         console.log(error)
        //             // if(error)
        //             // {
        //             //   console.log(error.responseJSON.errors.property_category);
        //             //   $('#catname_error').html(error.responseJSON.errors.property_category);
        //             // }
        //         }
        //     })

        //     //   update room details
        //     $('.save_button').click(function(){

        //         var url = '{{ route("updateroomname", ":id") }}';
        //         updateroomurl = url.replace(':id', roomid);

        //         var form = $('.propertcat_form')[0];
        //         var formdata=new FormData(form);

        //         $.ajax({
        //             url:updateroomurl,
        //             method:'POST',
        //             processData:false,
        //             contentType:false,
        //             data:formdata,
        //             success:function(response)
        //             {
        //                 alertify.set('notifier','position', 'top-right');
        //                 alertify.success(response.message);
        //                 editroomnamestable.ajax.reload();
        //                 $('.propertycategory').modal('hide');
                        
        //                 $('.catinput').val('');
        //                 $('#propertycat_id').val('');

        //             }
        //             ,error:function(error)
        //             {
        //                 console.log(error)
        //                 if(error)
        //                 {
        //                 // console.log(error.responseJSON.errors.property_category);
        //                 $('#catname_error').html(error.responseJSON.errors.property_category);
        //                 }
        //             }
        //         });
        //     })
        // })

        
    </script>
@stop



