
@extends('Admin.adminmaster')
@section('title','All Registered Users')
@section('content')


<div class="row" style="margin: 18px 0;">
  <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">Manage Registered Users</h3>
  <table id="registeredtenantstable" class="table table-striped table-bordered" style="width:100%; margin-top:50px;">
    <thead>
      <tr>
        <td>id</td>
        <td>Name</td>
        <td>Phone</td>
        <td>House Name</td>
        <td>House Number</td>
        <td>User Status</td>
        <td>Delete</td>
      </tr>
    </thead>
    <tbody>
      {{-- @foreach ($registered_users as $user )
        <tr class="user{{$user->id}}">
          <td>{{ $user->id }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->phone }}</td>
          <td>{{ $user->rentalhses->rental_name }}</td>
          @foreach ( $user->hserooms as $room)
            <td>{{ $room->room_name }}</td>
          @endforeach
          <td>
            @foreach ( $user->tenantstatus as $tenantstat)
            <input readonly=" " class="showtenantstatus bg-dark text-white" value="{{ $tenantstat->tenantstatus_title }}" data-id="{{ $tenantstat->id }}">
            <br>
            <button type="button" value="{{ $user->id }}" class="activatetenant">Change status</button>
            @endforeach
          </td>
        </tr>
      @endforeach --}}
    </tbody>
  </table>
</div>
@endsection

@section('registeredtenantscript')
    <script>
      // show all registered users in a datatable
        var registeredtenantstable = $('#registeredtenantstable').DataTable({
          processing:true,
          serverside:true,
          responsive:true,
          ajax:"{{ route('get_registered.tenants') }}",
            columns: [
              { data: 'id' },
              { data: 'name' },
              
              { data:
                function (row) {
                let tenantstatuses= [];
                  $(row.tenantstatus).each(function (i, e) {
                    tenantstatuses.push(e.tenantstatus_title);
                    });
                  return '<input readonly=" " class="showtenantstatus bg-dark text-white" value="' + tenantstatuses + '" data-id="' + row.id + '"><br><button type="button" value="' + row.id + '" class="activatetenant">Change status</button>';
                  // tenantstatuses.join(", ")
                }, name: 'tenantstatus.tenantstatus_title'
              },
            ],
        });

        // show modal to activate a user active upon registering
        $(document).on('click','.activatetenant',function(e){
          e.preventDefault();

          var tenanstatusid=$(this).val();
          var url = '{{ route("gettenant.status", ":id") }}';
                  url = url.replace(':id', tenanstatusid);
          $('#activateusermodal').modal('show');

          $.ajax({
            type:"GET",
            url:url,
            processData: false,
            contentType: false,
            success:function(response)
            {
              console.log(response);
              if (response.status==404)
              {
                  alert(response.message);
                  $('#activateusermodal').modal('hide');
              } 
              else
              {
                  $('#tenant_name').val(response.tenantdata.name);
                  $('#tenantuser_id').val(tenanstatusid);

                  $("#tenantstat_id").select2();
                  // $("#tenantstat_id").val(response.tenantdata.tenantstatus);

                  var tenantstatusobject = response.tenantdata.tenantstatus;
                  var arr = $.map(tenantstatusobject, function(el) { 
                    return el['id']; 
                  });
                  //pass array object value to select2
                  console.log(arr);
                  $('#tenantstat_id').val(arr).trigger('change');;
                            
              }
            }
          })
        })

          // activate a user method
        $(document).on('submit','#activateuserform',function(e){
            e.preventDefault();

            var tenantuser_id=$('#tenantuser_id').val();
            var url = '{{ route("assigntenant.status", ":id") }}';
                   url = url.replace(':id', tenantuser_id);
            var tenantstatusname = $('#tenantstat_id').val();
            
            $.ajax({
              type:"POST",
              url:url,
              data:$("#activateuserform").serialize(),
              success:function(response)
              {
                console.log(response);
                if(response.status==400)
                {
                    registeredtenantstable.ajax.reload();
                    $('#tenant_name').val('');
                    $('#tenantuser_id').val('');
                    $("#tenantstat_id").val('');
                    $('#activateusermodal').modal('hide');
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(response.message);
                }
                else if (response.status==200)
                {
                    registeredtenantstable.ajax.reload();
                    $('#tenant_name').val('');
                    $('#tenantuser_id').val('');
                    $("#tenantstat_id").val('');
                    $('#activateusermodal').modal('hide');
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(response.message);
                }
                else if (response.status==404)
                {
                    registeredtenantstable.ajax.reload();
                    $('#tenant_name').val('');
                    $('#tenantuser_id').val('');
                    $("#tenantstat_id").val('');
                    $('#activateusermodal').modal('hide');
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(response.message);
                }
              }
            })
        })

          // Add A new Tenant Status
        $(document).on('click','#newtenantstatus',function(){

          $('.tenantstatusmodal').modal('show');
          var url = '{{ route("addtenant.status") }}';        
          $(".tenantstatus_form").on("submit",function(e){
              e.preventDefault();
              $.ajax({
                  url:url,
                  type:"POST",
                  data:$(".tenantstatus_form").serialize(),
                  success:function(response){
                      console.log(response.message);
                      rentalhousestagstable.ajax.reload();
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

        })

        // show all tenant statuses
        $(document).ready( function () {

        });

        // update tenat status from active to inactive
        $(document).on('change','.tenantstatus',function(e)
        {
            var tenantstatus=$(this).prop('checked')==true? 1:0;

            var tenantid=$(this).data('id');

            $.ajax({
                type:"GET",
                dataType:"json",
                url:'{{ route('tenants.updatestatus') }}',
                data:{
                    'status':tenantstatus,
                    'id':tenantid
                },
                success:function(res){
                    console.log(res);
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(res.message);
                }
            });
        });

        
    </script>
@stop



