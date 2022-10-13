
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
                    return '<input class="toggle-class rentalhsestatus" disabled type="checkbox" checked data-toggle="toggle" data-id="' + row.id + '" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
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

    //   show editing modal
    $(document).on('click','.editrentalhsedetails',function(){
      var rentalhsedetailsid=$(this).data('id');
      $('#editrentalhsedetailsmodal').modal('toggle');

      $.ajax({
        url:'{{ url("admin/activerental",'') }}' + '/' + rentalhsedetailsid + '/edit',
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
              $('#rentalhouseid').val(response.editrentalhsedetail.id);
              $('.edit_title').html('Edit details for' + response.editrentalhsedetail.rental_name);
              $('#rental_title').val(response.editrentalhsedetail.rental_name);
              $('#rental_slug').val(response.editrentalhsedetail.rental_slug);
              $('#monthly_rent').val(response.editrentalhsedetail.monthly_rent);
            
              $("#rental_details_ck").html('<textarea id="editor" class="hsedetailstextarea" name="rental_details">' + response.editrentalhsedetail.rental_details + '</textarea>');

              ClassicEditor
              .create( document.querySelector( '#editor' ),
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
                    console.error( error )
              } );

              $('#totalrooms').val(response.editrentalhsedetail.total_rooms);
              $('.rentalhseimage').val(response.editrentalhsedetail.rental_image);
              
              $('.rentalhsevideo').val(response.editrentalhsedetail.rental_video);

              $(".rentalselectcat").select2();
              $(".rentalselectcat").val(response.editrentalhsedetail.housecategory.id).trigger('change');

              $(".rentalhsevacancy").select2();
              $(".rentalhsevacancy").val(response.editrentalhsedetail.is_vacancy).trigger('change');

              $(".rentalhselocation").select2();
              $(".rentalhselocation").val(response.editrentalhsedetail.houselocation.id).trigger('change');

              
              var tagsobject = response.editrentalhsedetail.housetags;
              var tagsarray = $.map(tagsobject, function(el) { 
                  return el['id']; 
              });
              //pass array object value to select2
              $(".rentaltagselect2").select2();
              $('.rentaltagselect2').val(tagsarray).trigger('change');

              // preview an image that was previously uploaded
              var showimage=$('#showimage').attr('src', '/imagesforthewebsite/rentalhouses/rentalimages/small/' + response.editrentalhsedetail.rental_image);
              $('.rentalimg').html(showimage);

              $('input[name^="edit_is_featured"][value="' + response.editrentalhsedetail.is_featured + '"]').prop('checked', true);

              $('input[name^="edit_wifi"][value="' + response.editrentalhsedetail.wifi + '"]').prop('checked', true);

              $('input[name^="edit_generator"][value="'+response.editrentalhsedetail.generator+'"]').prop('checked', true);

              $('input[name^="edit_balcony"][value="'+response.editrentalhsedetail.balcony+'"]').prop('checked', true);

              $('input[name^="edit_parking"][value="'+response.editrentalhsedetail.parking+'"]').prop('checked', true);

              $('input[name^="edit_cctv_cameras"][value="'+response.editrentalhsedetail.cctv_cameras+'"]').prop('checked', true);

              $('input[name^="edit_servant_quarters"][value="'+response.editrentalhsedetail.servant_quarters+'"]').prop('checked', true);
            }
        }
      })
    });

    //   update rental house details
    $(document).on('submit','#updatehsesform',function()
    {
      var hseupdateid=$('#rentalhouseid').val();
      var url = '{{ route("updaterentaldetails", ":id") }}';
      updatehseurl = url.replace(':id',hseupdateid);

      var form = $('.updaterentaldetails')[0];
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
            $('.update_errorlist').html(" ");
            $('.update_errorlist').removeClass('d-none');
            $.each(response.message,function(key,err_value)
            {
                $('.update_errorlist').append('<li>' + err_value + '</li>');
            })
          } 
          else if (response.status==200)
          {
            alertify.set('notifier','position', 'top-right');
            alertify.success(response.message);
            inactiverentalhousestable.ajax.reload();
            $('#rentalhouseid').val('');
            $('.edit_title').html('');
            $('#rental_title').val('');
            $('#rental_slug').val('');
            $('#monthly_rent').val('');

            $("#rental_details_ck").children("textarea").remove();
            $('.hsedetailstextarea').val('');

            $('#totalrooms').val('');
            
            $('.rentalhsevideo').val('');

            $(".rentalselectcat").val('');

            $(".rentalhsevacancy").val('');

            $(".rentalhselocation").val('');

            //pass array object value to select2
            $('.rentaltagselect2').val('');

            // preview an image that was previously uploaded
            var deleteimage=$('#showimage').removeAttr('src');
            $('.rentalhseimage').html('deleteimage');

            // $('.editcheckbox').prop('checked', false);

            $('input[name^="edit_is_featured"]').prop('checked', false);

            $('input[name^="edit_wifi"]').prop('checked', false);

            $('input[name^="edit_generator"]').prop('checked', false);

            $('input[name^="edit_balcony"]').prop('checked', false);

            $('input[name^="edit_parking"]').prop('checked', false);

            $('input[name^="edit_cctv_cameras"]').prop('checked', false);

            $('input[name^="edit_servant_quarters"]').prop('checked', false);
            $('#editrentalhsedetailsmodal').modal('hide');
          }
        }
      });
    });

  </script>
@stop


