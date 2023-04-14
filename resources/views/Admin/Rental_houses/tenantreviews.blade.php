@extends('Admin.adminmaster')
@section('title','Tenants Reviews and Ratings Management')
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
      <a class="btn btn-dark" href="{{ url('admin/mpesa_payments') }}">All Mpesa Payments</a>
   </div>
   <div class="col-md-3">
      <a class="btn btn-dark" href="{{ url('admin/activerentals') }}">Activated Rental Houses</a>
   </div>
</div>
<div class="row" style="margin-top: 50px;">
    <div class="col-md-12">
        <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">House Reviews and Rating Management</h3>

        <div class="col-md-12">
            <table id="housereviewstable" class="table table-striped table-bordered" style="width:100%; margin-top:50px;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Rental House</th>
                        <th>Tenant Name</th>
                        <th>House Review</th>
                        <th>House Rating</th>
                        <th>Reviewed Made at</th>
                        <th>Status</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('housereviewsmgtscript')
    <script>
        
        $(document).ready( function () {
            // show all rental reviews and ratings in a datatable
            var housereviewsmgttable = $('#housereviewstable').DataTable({
                processing:true,
                serverside:true,
                responsive:true,

                ajax:"{{ route('get_tenant.reviews') }}",
                columns: [
                    { data: 'id' },
                    {data: 'hse_id', name:'hse_id.rentalhouse', orderable:true,searchable:true},
                    {data: 'user_id', name:'user_id.userrating', orderable:true,searchable:true},
                    { data: 'house_review' },
                    { data: 'house_rating' },
                    { data: 'rating_isactive',name:'rating_isactive',orderable:false,searchable:false },
                    { data: 'created_at',name:'created_at',orderable:false,searchable:false },
                    { data: 'delete',name:'delete',orderable:false,searchable:false },
                ],

                "fnDrawCallback": function( row ) {
                    $('.hsereviewstatus')
                    .prop( 'checked', row.status == 1 )
                    .bootstrapToggle();
                }
            });
        });

        //  update rental tag status from active to inactive
        $(document).on('change','.hsereviewstatus',function(e)
        {
            var hsereviewstatus=$(this).prop('checked')==true? 1:0;

            var ratingreviewid=$(this).data('id');
            $.ajax({
                type:"GET",
                dataType:"json",
                url:'{{ route('updatereview.status') }}',
                data:{
                    'status':hsereviewstatus,
                    'id':ratingreviewid
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

            $('.removepropertycategory').modal('show');
            $('.modal-title').html('Delete Rental Category');
            $('#rentalcatg_id').val(deletecatid);

        })

        $(document).on('click','#deletepropertycategory',function()
        {
            var deletecatid=$('#rentalcatg_id').val();

            $.ajax({
                type:"DELETE",
                url:'{{ url("admin/delete_rentalcat",'') }}' + '/' + deletecatid,
                dataType:"json",
                success:function(response)
                {
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(response.message);
                    rentalhousescatstable.ajax.reload();
                    $('.removepropertycategory').modal('hide');
                    $('#rentalcatg_id').val('');
                }
            })
        })
    </script>
@stop