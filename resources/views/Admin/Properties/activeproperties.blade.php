@extends('Admin.adminmaster')
@section('title','Activated Properties')
@section('content')

<div class="row" style="
    display: flex;
    justify-content: center;">
   <div class="col-md-3">
      <a class="btn btn-dark" href="{{ route('inactive.properties') }}">In Active Properties</a>
   </div>
   <div class="col-md-3">
      <a class="btn btn-dark" href="{{ url('admin/propertiescategories') }}">Add a Property Category</a>
   </div>
   <div class="col-md-3">
      <a class="btn btn-dark" href="{{ route('add.property') }}">Add a New Property</a>
   </div>
   <div class="col-md-3">
      <a class="btn btn-dark" href="{{ route('alllocations.index') }}">Add a New Location</a>
   </div>
</div>

<h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">Actived Properties</h3>
<div class="row" style="margin-top: 10px;">
   <div class="col-lg-10 mx-auto">
       <table id="activatedpropertiestable" class="table table-striped table-bordered" style="width: 100%;">
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

@section('activepropertiesmgmtscript')
  <script>

    // show all images of the house in a datatable
    var activerentalpropertiestable = $('#activatedpropertiestable').DataTable({
        processing:true,
        serverside:true,
        responsive:true,

        ajax:"{{ route('get_active.properties') }}",
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

   //   show property editing modal
   $(document).on('click','.editpropertydetails',function(){
      var propertydetailsid=$(this).data('id');

      $.ajax({
        url:'{{ url("admin/property",'') }}' + '/' + propertydetailsid + '/edit',
        method:'GET',
        processData: false,
        contentType: false,
        success:function(response)
        {
            console.log(response)
            if (response.status==404)
            {
              alert(response.message);
            } 
            else if(response.status==200)
            {
                $('#editpropertydetailsmodal').modal('toggle');
               $('#propertyid').val(response.editpropertydetails.id);
               $('.edit_propertytitle').html('Edit property details for' + response.editpropertydetails.property_name);
               $('#property_name').val(response.editpropertydetails.property_name);
               $('#property_price').val(response.editpropertydetails.property_price);
               $('#property_slug').val(response.editpropertydetails.property_slug);
               $('#propertydetails').val();

               $('#property_address').val(response.editpropertydetails.property_address);

               $("#property_details_ck").html('<textarea id="propertyeditor" class="propertydetailstextarea" name="property_details">' + response.editpropertydetails.property_details + '</textarea>');

                  ClassicEditor
                  .create( document.querySelector( '#propertyeditor' ),
                  {
                     toolbar: {
                        items: [
                           'heading', '|',
                           'bold', 'italic', '|',
                           'link', '|',
                           'outdent', 'indent', '|',
                           'bulletedList', 'numberedList', '|',
                           'undo', 'redo'
                        ],
                        shouldNotGroupWhenFull: true
                     }
                  })
                  .catch( error => {
                        console.error( error );
                  } );

               // preview an image that was previously uploaded
               $('.sellpropertyimage').val(response.editpropertydetails.property_image);
               var showpropertyimage=$('#showpropertyimage').attr('src', '/imagesforthewebsite/properties/propertyimages/small/' + response.editpropertydetails.property_image);
               $('.propertyimg').html(showpropertyimage);

               $(".propertylocationselect").select2();
               $(".propertylocationselect").val(response.editpropertydetails.propertylocation.id).trigger('change');

               $(".propertycategoryselect").select2();
               $(".propertycategoryselect").val(response.editpropertydetails.propertycategory.id).trigger('change');
              
            }
        }
      })
    });

    //   update Property details
    $(document).on('submit','#updatepropertyform',function()
    {
      var propertyupdateid=$('#propertyid').val();
      var url = '{{ route("updateproperties.details", ":id") }}';
      updatepropertyurl = url.replace(':id',propertyupdateid);

      var form = $('.updatepropertydetails')[0];
      var formdata=new FormData(form);

      $.ajax({
        url:updatepropertyurl,
        method:'POST',
        processData:false,
        contentType:false,
        data:formdata,
        success:function(response)
        {
          console.log(response);
          if (response.status==400)
          {
            $('.updateproperty_errorlist').html(" ");
            $('.updateproperty_errorlist').removeClass('d-none');
            $.each(response.message,function(key,err_value)
            {
                $('.updateproperty_errorlist').append('<li>' + err_value + '</li>');
            })
          } 
          else if (response.status==200)
          {
            alertify.set('notifier','position', 'top-right');
            alertify.success(response.message);
            activerentalpropertiestable.ajax.reload();
            $('#propertyid').val('');
            $('.edit_propertytitle').html('');
            $('#property_name').val('');
            $('#property_price').val('');
            $('#property_slug').val('');
            $('#propertydetails').val('');

            $('#property_address').val('');
            $("#property_details_ck").children("textarea").remove();
            $('.propertydetailstextarea').val('');

            var deleteimage=$('#showpropertyimage').removeAttr('src');
            $('.propertyimg').html('deleteimage');

            $(".propertylocationselect").val('');
            $(".propertycategoryselect").val('');
            $('#editpropertydetailsmodal').modal('hide');
          }
        }
      });
    });
  </script>
@stop