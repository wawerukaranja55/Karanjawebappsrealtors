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
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    </div>

@endsection

@section('propertycategoriesscripts')
    <script>
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
              { data: 'status',name:'status',orderable:false,searchable:false },
              { data: 'action',name:'action',orderable:false,searchable:false },
          ],

          "fnDrawCallback": function( row ) {
            $('.propertycats_status')
            .prop( 'checked', row.status !== 1 )
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
                        console.log(response.message);
                        rentalhousestable.ajax.reload();
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
        $('body').on('click','.editrentaltag',function(){
            var rentaltagid=$(this).data('id');

            $.ajax({
                url:'{{ url("admin/rentaltag",'') }}' + '/' + rentaltagid + '/edit',
                method:'GET',
                success:function(response){
                console.log(response);
                $('.propertycategory').modal('show');
                $('.modal-title').html('Edit Rental Tag');
                $('.catlabel').html('Rental Tag');
                $('.save_button').html('Update Rental Tag');
                $('#property_category').hide('');
                $('#rental_tagname').show();
                $('.taginput').val(response.rentaltag_title);

                $('#rentaltag_id').val(response.id);

                }
            })

            //   update rental tags details
            $('.save_button').click(function(){

                var url = '{{ route("updaterentaltag", ":id") }}';
                updatetagurl = url.replace(':id', rentaltagid);

                var form = $('.propertcat_form')[0];
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
                            $('.propertycategory').modal('hide');
                            
                            $('.catinput').val('');
                            $('#propertycat_id').val('');

                        } else if (response.status==200)
                        {
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(response.message);
                            rentalhousestagstable.ajax.reload();
                            $('.propertycategory').modal('hide'); 
                            $('.catinput').val('');
                            $('#propertycat_id').val('');
                        }

                    }
                });
            })
        })
        
        // Delete rental tag from the db
        $(document).on('click','#deleterentaltag',function(){

            var deletetagid=$(this).data('id');

            $('.removepropertycategory').modal('show');
            $('.modal-title').html('Delete Rental Tag');
            $('#propertycategory_id').val(deletetagid);

        })

        $(document).on('click','#deletepropertycategory',function()
        {
            var deletetagid=$('#propertycategory_id').val();

            $.ajax({
                type:"DELETE",
                url:'{{ url("admin/delete_rentaltag",'') }}' + '/' + deletetagid,
                dataType:"json",
                success:function(response)
                {
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(response.message);
                    rentalhousestagstable.ajax.reload();
                    $('.removepropertycategory').modal('hide');
                    $('#propertycategory_id').val('');
                }
            })
        })
    </script>
@stop



