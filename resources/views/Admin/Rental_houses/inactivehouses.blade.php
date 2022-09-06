
@extends('Admin.adminmaster')
@section('title','Inactive Rental Houses')
@section('content')

<div class="row" style="
    display: flex;
    justify-content: center;">
   <div class="col-md-3">
      <a class="btn btn-dark" href="{{ url('admin/activerentals') }}">Activated Rental Houses</a>
   </div>
   <div class="col-md-3">
      <a class="btn btn-dark" href="{{ route('addrentalhse') }}">Add a New Rental House</a>
   </div>
   <div class="col-md-3">
      <a class="btn btn-dark" href="{{ route('tagscatmngt') }}">Add a New Tag/Category</a>
   </div>
   <div class="col-md-3">
      <a class="btn btn-dark" href="{{ route('alllocations.index') }}">Add a New Location</a>
   </div>
</div>

<h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">In Active Rental Houses</h3>
<div class="row" style="margin-top: 10px;">
   <div class="col-lg-10 mx-auto">
      <table id="activaterentalstable" class="table table-striped table-bordered" style="width:100%; margin-top:50px;">
         <thead>
           <tr>
             <td>id</td>
             <td>Rental Name</td>
             <td>Monthly Rent Price</td>
             <td>Rental Location</td>
             <td>Rental Category</td>
             <td>Number of Rooms</td>
             <td>Rental Image</td>
             <td>Rental Status</td>
             <td>Action</td>
           </tr>
         </thead>
         <tbody>
         </tbody>
       </table>
   </div>
</div>
@endsection

@section('inactivehsesmgmtscript')
  <script>

    // show all images of the house in a datatable
    var inactiverentalhousestable = $('#activaterentalstable').DataTable({
        processing:true,
        serverside:true,
        responsive:true,

        ajax:"{{ route('get_inactiverentals') }}",
        columns: [
          { data: 'id' },
          { data: 'rental_name' },
          { data: 'monthly_rent' },
          {data: 'location_id', name:'location_id.houselocation', orderable:true,searchable:true},
          {data: 'rentalcat_id', name:'rentalcat_id.housecategory', orderable:true,searchable:true},
          { data: 'total_rooms' },
          { data: 'rental_image',
            render: function ( data, type, full, meta, row) {
              return "<img src=\"/imagesforthewebsite/rentalhouses/rentalimages/small/" + data + "\" height=\"80px\"/>"
            }
          }, 
          { data: 'rental_status',
              render: function ( data, type, row ) {
                if ( type === 'display' ) {
                      return '<input class="toggle-class rentalhsestatus" type="checkbox" checked data-toggle="toggle" data-id="' + row.id + '" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
                }
                return data;
              }
          },
          { data: 'action',name:'action',orderable:false,searchable:false },
        ],

        rowCallback: function ( row, data ) {
          $('input.rentalhsestatus', row)
          .prop( 'checked', data.rental_status == 1 )
          .bootstrapToggle();
        }
      });

  </script>
@stop


