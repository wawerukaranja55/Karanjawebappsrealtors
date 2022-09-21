@extends('Admin.adminmaster')
@section('title','Properties Management')
@section('content')

    {{-- Add Rental House Extra Images--}}
    
    <div class="row">
        <div class="col-lg-8" style="
            display: flex;
            justify-content: center;">
            <div class="panel-heading mt-5" style="text-align: center; font-size:18px; background-color:black;"> 
                <h3 class="panel-title">Property Categories Management</h3> 
            </div>
        </div>
    </div>
    <div class="row mx-auto">
      <div class="col-md-5">
          <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">Add A New Property Category</h3>

          <form action="javascript:void(0)" id="addapropertycategory" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
              @csrf
              {{-- property category name --}}
              <div class="form-group">
                  <label for="propertycategory_name" style="font-size: 1.5rem margin-top:5px;" class="control-label">Property Category Name</label>
                  
                  <div class="bg-dark" style="margin-top: 5px;">
                      <input type="text" style="font-size: 0.8rem" class="form-control text-white bg-dark" required name="propertycat_title" id="propertycat_title" placeholder="Write The Property Category Name">
                  </div> 
              </div>

              {{-- property category slug --}}
              <div class="form-group">
                <label for="propertycategory_slug" style="font-size: 1.5rem margin-top:5px;" class="control-label">Property Category Slug</label>
                
                <div class="bg-dark" style="margin-top: 5px;">
                    <input type="text" style="font-size: 0.8rem" class="form-control text-white bg-dark" required name="propertycat_url" id="propertycat_url" placeholder="Write The Property Category Slug">
                </div> 
            </div>
              <button type="submit" class="btn btn-primary">Upload</button>   
          </form>
      </div>
      <div class="col-md-7">
        <table id="propertycategories" class="table table-striped table-bordered" style="width:100%; margin-top:10px;">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    </div>

@endsection

@section('propertycategoriesscripts')
    <script>
        $(document).ready(function(){

            var url = '{{ route("storepropertycat") }}';
                    
            $("#addapropertycategory").on("submit",function(e){
                e.preventDefault();
                $.ajax({
                    url:url,
                    type:"POST",
                    data:$("#addapropertycategory").serialize(),
                    success:function(response){
                        console.log(response)
                        if (response.status==200)
                        {
                            propertycategoriestable.ajax.reload();
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(response.message);
                        }
                    }
                });
            })
        });

        // show all property categories in a datatable
        var propertycategoriestable = $('#propertycategories').DataTable({
          processing:true,
          serverside:true,
          responsive:true,

          ajax:"{{ route('propertiescategories') }}",
          columns: [
              { data: 'id' },
              { data: 'propertycat_title' },
              { data: 'propertycat_url' },
              { data: 'status',
                    render: function ( data, type, row ) {
                        if ( type === 'display' ) {
                            return '<input class="toggle-class propertycats_status" type="checkbox" checked data-toggle="toggle" data-id="' + row.id + '" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
                        }
                        return data;
                    }
                },
                { data: 'edit',name:'edit',orderable:false,searchable:false },
            ],
            rowCallback: function ( row, data ) {
                $('input.propertycats_status', row)
                .prop( 'checked', data.status == 1 )
                .bootstrapToggle();
            }
        });

        //  update property category status from active to inactive
        $(document).on('change','.propertycats_status',function(e)
        {
            var propertycatstatus=$(this).prop('checked')==true? 1:0;

            var propertycatid=$(this).data('id');
            $.ajax({
                type:"GET",
                dataType:"json",
                url:'{{ route('updatepropertycategorystatus') }}',
                data:{
                    'status':propertycatstatus,
                    'id':propertycatid
                },
                success:function(res){
                    console.log(res);
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(res.message);
                }
            });
        });

        // edit and update property category details
        $(document).on('click','.editpropcatbutton',function(e){
            e.preventDefault();
            var propertycatid=$(this).data('id');
            console.log(propertycatid);

            $.ajax({
                url:'{{ url("admin/propertycategories",'') }}' + '/' + propertycatid + '/edit',
                method:'GET',
                success:function(response){
                    console.log(response);
                    $('#rentalhsecategorymodal').modal('show');
                    
                    $('#rentalhsecat_id').html('');
                    
                    

                    $('#property_category').html('');
                    $('#rental_tagname').html('');
                    $('#roomsize_name').html('');
                    $('#room_name').html('');
                    $('#role_name').html('');


                    $('.modal-title').html('Edit Property Category Details');
                    $('.catlabel').html('Property Category Title');
                    $('.catsluglabel').html('Property Category Slug');
                    $('#propertycategory_id').val(response.id);
                    $('.catinput').val(response.propertycat_title);
                    $('#rentalcategory_slug').val(response.propertycat_url);
                    $('.update_button').html('Update Property Category');
                }
            })
        });

            //   update location details
        $(document).on('click','.update_button',function(e){
            e.preventDefault();
            
            $propertycategoryid=$('#propertycategory_id').val();

            var url = '{{ route("update.propertycategory", ":id") }}';
            updatepropertycaturl = url.replace(':id', $propertycategoryid);

            var form = $('.updatepropertcat_form')[0];
            var formdata=new FormData(form);

            $.ajax({
                url:updatepropertycaturl,
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
                        propertycategoriestable.ajax.reload();
                        $('#rentalhsecategorymodal').modal('hide');
                    }
                    else if (response.status==400)
                    {
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(response.message);
                        propertycategoriestable.ajax.reload();
                        $('#rentalhsecategorymodal').modal('hide');
                    } 

                }
            });
        });
    </script>
@stop



