@extends('Admin.adminmaster')
@section('title','Properties to Activate')
@section('content')

<div class="row" style="
    display: flex;
    justify-content: center;">
   <div class="col-md-3">
      <a class="btn btn-dark" href="{{ route('active.properties') }}">Active Properties</a>
   </div>
   <div class="col-md-3">
      <a class="btn btn-dark" href="#">Active Properties</a>
   </div>
   <div class="col-md-3">
      <a class="btn btn-dark" href="#">Add a New Property</a>
   </div>
   <div class="col-md-3">
      <a class="btn btn-dark" href="#">Property Categories Management</a>
   </div>
</div>

<h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">In Active Properties</h3>
<div class="row" style="margin-top: 10px;">
   <div class="col-lg-10 mx-auto">
       <table id="activatepropertiestable" class="table table-striped table-bordered" style="width: 100%;">
           <thead>
               <tr>
                  <td>id</td>
                  <td>Property Name</td>
                  <td>Property Price(sh.)</td>
                  <td>Property Location</td>
                  <td>Property Category</td>
                  <td>Property Image</td>
                  <td>Action</td>
               </tr>
           </thead>
           <tbody></tbody>
       </table>
   </div>
</div>
@endsection

@section('inactivepropertiesmgmtscript')
  <script>

    // show all images of the house in a datatable
    var inactiverentalpropertiestable = $('#activatepropertiestable').DataTable({
        processing:true,
        serverside:true,
        responsive:true,

        ajax:"{{ route('get_inactive.properties') }}",
        columns: [
            { data: 'id' },
            { data: 'property_name' },
            { data: 'property_price' },
            { data: 'propertylocation_id', name:'propertylocation_id.propertylocation', orderable:true,searchable:true},
            { data: 'propertycat_id', name:'propertycat_id.propertycategory', orderable:true,searchable:true},
            { data: 'property_image',
                render: function ( data, type, full, meta, row) {
                return "<img src=\"/imagesforthewebsite/properties/propertyimages/small/" + data + "\" height=\"80px\"/>"
                }
            }, 
            { data: 'action',name:'action',orderable:false,searchable:false },
        ],
    });

  </script>
@stop