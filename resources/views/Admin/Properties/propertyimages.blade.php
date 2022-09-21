@extends('Admin.adminmaster')
@section('title','Property Images')
@section('content')
@section('addpropertyimagesstyles')
    <style>
        .importantnotes{
            padding: 2px;
            border-radius: 50%;
            font-size: 15px;
            text-align: center;    
            background: #080808;
            color: #fff;
        }
    </style>
@stop
    {{-- Add Rental House Extra Images--}}
    
    <div class="row" style="
    display: flex;
    justify-content: center;">
        <div class="col-md-3">
            <a class="btn btn-dark" href="{{ route('inactive.properties') }}">Inactive Properties</a>
        </div>
        <div class="col-md-3">
            <a class="btn btn-dark" href="{{ route('active.properties') }}">Active Properties</a>
        </div>
        <div class="col-md-3">
            <a class="btn btn-dark" href="{{ route('add.property') }}">Add a New Property</a>
        </div>
        <div class="col-md-3">
            <a class="btn btn-dark" href="{{ url('admin/propertiescategories') }}">Property Categories Management</a>
        </div>
    </div>
    <div class="panel-heading mt-5" style="text-align: center; font-size:17px; padding:10px; background-color:black;"> 
        <h3 class="panel-title">Add More Images of the Property To Publish it</h3> 
    </div>
    <div class="row">
        <div class="col-md-6">
            <input type="hidden" id="propertyimages_id" class="propertyimageid" value="{{ $propertydata->id }}" >
            <div class="form_group">
                <div class="d-flex">
                    <label>1.Property Name</label>:&nbsp;&nbsp;&nbsp;{{ $propertydata->property_name }}
                </div>
            </div>
            
            <div class="form_group">
                <div class="d-flex">
                    <label>2.Property Location</label>:&nbsp;&nbsp;&nbsp;{{ $propertydata->propertylocation['location_title'] }}
                </div>
            </div>
            <form id="property_dropzone" action="{{ url('admin/propertyimages/'.$propertydata->id) }}" class="dropzone form-horizontal" role="form" method="POST" enctype="multipart/form-data">
                @csrf
            </form>
        </div>
        <div class="col-md-6">
            <div class="pull-right p-10">
                <h3>Important Notes</h3>
                <ol type="1">
                    <li class="font-bold text-uppercase text-danger">The property is still inactive if no image has been added</li>
                    <li class="font-bold text-uppercase text-danger">A Maximum of 7 images should be added for each Property</li>
                </ol>
            </div>

            @if (!empty($propertydata->property_video))

                <h3>Change video for the Property house</h3>
                <div class="changepropertyvideo">
                    <form action="{{ url('admin/addpropertyvideo/'.$propertydata->id) }}" class="dropzone form-horizontal dropzone-propertyform" role="form" method="POST" enctype="multipart/form-data">
                        @csrf
                    </form>
                </div>
                <video class="video-js" controls preload="auto" width="100%" height="100" margin-top="10px" data-setup="{}">
                    <source src="/videos/propertyvideos/{{$propertydata->property_video}}" type='video/mp4'>
                </video>
                <a class="confirmvideodelete" href="javascript:void(0)" data-id="{{ $propertydata->id }}">Delete Video and Replace it</a> 
            @else
                <h3>Add a video for the Property<span class="font-type:italics;">(optional)</span></h3>
                <form action="{{ url('admin/addpropertyvideo/'.$propertydata->id) }}" class="dropzone form-horizontal dropzone-propertyform" role="form" method="POST" enctype="multipart/form-data">
                    @csrf
                </form>
            @endif
        </div>
    </div>
    <div class="row" style="margin-top: 50px;">
        <div class="col-md-9 mx-auto">
            <table id="propertyimagestable" class="table table-striped table-bordered" style="width: 100%;">
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
    </div>

@endsection

@section('propertyimagesscript')
    <script>
        // add a property video for the property on sale using dropzone.js
        Dropzone.autoDiscover = false;
        var dzonepropertyvideo = new Dropzone(".dropzone-propertyform",{
            maxFilesize: 20000,
            maxFiles: 1,
            acceptedFiles: ".Mp4"
        });

        dzonepropertyvideo.on("success",function(file,response){
            console.log(response)
            if(response.status == 200)
            {
                alertify.set('notifier','position', 'top-right');
                alertify.success(response.message);
                
            }
        });

        // Delete house video from the db
        $(document).on('click','.confirmvideodelete',function(){

            var deletepropertyvideoid=$(this).data('id');

            $('.admindeletemodal').modal('show');
            $('.modal-title').html('Delete Property Video');
            $('#propertyvideo_id').val(deletepropertyvideoid);

        })

        $(document).on('click','#deletemodalbutton',function()
        {

            var propertyvideoid=$('#propertyvideo_id').val();

            $.ajax({
                type:"DELETE",
                url:'{{ url("admin/delete_propertyvideo",'') }}' + '/' + propertyvideoid,
                data:{propertyvideo_id: propertyvideoid},
                success:function(response)
                {
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(response.message);
                    $('.changepropertyvideo').show("1000");
                    $('.video-js').hide("1000");
                    $('.confirmvideodelete').hide("2000");
                    $('.admindeletemodal').modal('hide');
                    $('#propertyvideo_id').val('');
                }
            })
        })

        // show all images of the property in a datatable
        var propertyimgid=$('.propertyimageid').val();
        var url = '{{ route("get_property.images", ":id") }}';
                url = url.replace(':id', propertyimgid);

        var propertyimgstable = $('#propertyimagestable').DataTable({
        
            processing:true,
            serverside:true,
            reponsive:true,

            ajax:
            {
                url:url,
                type: 'get',
                dataType: 'json',
                data:{
                    'id':propertyimgid
                },
            },
            columns: [
                { data: 'id' },
                { data: 'image',
                    render: function ( data, type, full, meta, row) {
                        return "<img src=\"/imagesforthewebsite/properties/propertyxtraimages/small/" + data + "\" height=\"80px\" height=\"80px\"/>"
                    }
                },
                { data: 'status',
                    render: function ( data, type, row ) {
                        if ( type === 'display' ) {
                            return '<input type="checkbox" checked data-toggle="toggle" data-id="' + row.id + '" class="propertyimgstatus" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
                        }
                        return data;
                    }
                },
                { data: 'delete',name:'delete',orderable:false,searchable:false },
            ],

            rowCallback: function ( row, data ) {
                $('input.propertyimgstatus', row)
                .prop( 'checked', data.status == 1 )
                .bootstrapToggle();
            }
        });
        
        // add images using dropzone and add on the datatable without page refresh
        Dropzone.autoDiscover = false;
        var dzonepropertyimages = new Dropzone("#property_dropzone",{
            maxFilesize: 2,
            maxFiles: 7,
            acceptedFiles: ".jpeg,.jpg,.png"
        });

        dzonepropertyimages.on("success",function(file,response){
            console.log(response.message)
            if(response.success == 1)
            {
                alertify.set('notifier','position', 'top-right');
                alertify.success(response.message);
                propertyimgstable.ajax.reload();
                
            }
        });

        //  updateproperty images status from active to inactive
        $(document).on('change','.propertyimgstatus',function(e)
        {
            var propertyimgstatus=$(this).prop('checked')==true? 1:0;
            var propertyid=$(this).data('id');
            
            $.ajax({
                type:"GET",
                dataType:"json",
                url:'{{ route('updatepropertyimages.status') }}',
                data:{
                    'status':propertyimgstatus,
                    'id':propertyid
                },
                success:function(res){
                    console.log(res);
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(res.message);
                }
            });
        });

        // Delete an property image 
        $(document).on('click','#deletepropertyimg',function(){

            var propertyimgid=$(this).data('id');

            $('.admindeletemodal').modal('show');
            $('.modal-title').html('Delete The Property Image');

            $('#propertyimage_id').val(propertyimgid);

        })

        $(document).on('click','#deletemodalbutton',function()
        {
            var propertyimg_id=$('#propertyimage_id').val();

            var url = '{{ route("delete.propertyimage", ":id") }}';
                    url = url.replace(':id', propertyimg_id);
            $.ajax({
                url:url,
                type: 'DELETE',
                dataType: 'JSON',
                data:{
                    'propertyimageid': propertyimg_id,
                    '_token': '{{ csrf_token() }}',
                },
                success:function(response)
                {
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(response.message);
                    propertyimgstable.ajax.reload();
                    $('.admindeletemodal').modal('hide');
                    $('.modal-title').html('');

                    $('#propertyimage_id').val('');
                }
            })
        })

        
    </script>
@stop



