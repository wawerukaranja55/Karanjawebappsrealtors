@extends('Admin.adminmaster')
@section('title','Assign User A Certain Role')
@section('content')

<div class="row" style="margin: 18px 0;">
  <div class="col-lg-3" style="
  display: flex;
  justify-content: center;">
      <div class="pull-left p-10">
          <a class="btn btn-success" href="{{ url('admin/activerentals') }}">All Activated Rental Houses</a>
      </div>
  </div>
  <div class="col-lg-9">
    <div class="row" style="margin: 18px 0;">
      <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">Tenant Status Management</h3>
      <div class="col-lg-12">
        <table id="tenantstatusestable" class="table table-striped table-bordered" style="width:80%; margin:50px;">
          <thead>
            <tr>
              <td>id</td>
              <td>Tenant status Title</td>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="row" style="margin: 18px 0;">
  <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">Assign a User a Role</h3>
  <table id="assignusersrole" class="table table-striped table-bordered" style="width:100%; margin-top:50px;">
    <thead>
      <tr>
        <td>id</td>
        <td>User Name</td>
        <td>Profile image</td>
        <td>Phone</td>
        <td>House Name</td>
        <td>House Number</td>
        <td>User Role</td>
        <td>Account Status</td>
        <td>User Status</td>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>
@endsection

@section('assignusersrolesscript')
    <script>
        // show all users and their roles
        var managesignedupuserstable = $('#assignusersrole').DataTable({
          processing:true,
          serverside:true,
          responsive:true,
          ajax:"{{ route('get_usersroles.assign') }}",
            columns: [
              { data: 'id' }, 
              { data: 'name' },
              { data: 'avatar',
                render: function ( data, type, full, meta, row) {
                  return "<img src=\"/imagesforthewebsite/usersimages/" + data + "\" width=\"60px\" height=\"60px\"/>"
                }
              },
              { data: 'phone' },
              { data: 'house_id', name:'house_id.rentalhses.rental_name', orderable:true,searchable:true},
              { data:
                function (row) {
                let userrooms= [];
                  $(row.hserooms).each(function (i, e) {
                    userrooms.push(e.room_name);
                    });
                  return userrooms.join(", ")
                }, name: 'hserooms.room_name'
              },
              { data:
                function (row) {
                let userroles= [];
                  $(row.roles).each(function (i, e) {
                    userroles.push(e.role_name);
                    });
                    return '<input readonly=" " class="userrole bg-dark text-white" value="' + userroles + '" data-id="' + row.id + '"><br><button type="button" value="' + row.id + '" class="btn-primary assignrole">Assign the User A New Role</button>';
                }, name: 'roles.role_name'
              },
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
              { data: 'is_approved',
                render: function ( data, type, row ) {
                  if ( type === 'display' ) {
                    return '<input disabled class="userstatus" type="checkbox" checked data-toggle="toggle" data-id="' + row.id + '" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
                  }
                  return data;
                }
              },
            ],

            rowCallback: function ( row, data ) {
                $('input.userstatus', row)
                .prop( 'checked', data.is_approved == 1 )
                .bootstrapToggle();
            }
        });

        // show tenant statuses ina datatable
        var tenantstatusestable = $('#tenantstatusestable').DataTable({
          processing:true,
          serverside:true,
          responsive:true,

          ajax:"{{ route('tenants.statuses') }}",
          columns:
          [
            { data: 'id' },
            { data: 'tenantstatus_title' },
          ],

          // rowCallback: function ( row, data ) {
          //   $('input.tenantstatus', row)
          //   .prop( 'checked', data.status == 1 )
          //   .bootstrapToggle();
          // }
          });

          // show form for assigning the admin another role
          $(document).on('click','.assignrole',function(e){
            e.preventDefault();

            var user_roleid=$(this).val();
            var url = '{{ route("getadmin_role", ":id") }}';
                   url = url.replace(':id', user_roleid);
            $('#assignadminmodal').modal('show');

            $.ajax({
              type:"GET",
              url:url,
              processData: false,
              contentType: false,
              success:function(response)
              {
                console.log(response.admindata.roles);
                if (response.status==404)
                {
                    alert(response.message);
                    $('#assignadminmodal').modal('hide');
                } 
                else
                {
                    $('#edit_name').val(response.admindata.name);
                    $('#adminrole_id').val(user_roleid);

                    // $("#roleid").val(response.admindata.roles);
                    var roleobj = response.admindata.roles;
                    var arr = $.map(roleobj, function(el) { 
                      return el['id']; 
                    });
                    //pass array object value to select2
                    console.log(arr);
                    $('#roleid').val(arr);
                              
                }
              }
            })
          })

          // Update role for an admin
          $(document).on('submit','#assignadminarole',function(e){
              e.preventDefault();

              var adminroleid=$('#adminrole_id').val();
              var url = '{{ route("assign_role", ":id") }}';
                    url = url.replace(':id', adminroleid);
              var rolename = $('#roleid').val();
              
              $.ajax({
                type:"POST",
                url:url,
                data:$("#assignadminarole").serialize(),
                success:function(response)
                {
                  if(response.status==400)
                  {
                    $('#update_erroradmin').html("");
                    $('#update_erroradmin').removeClass('d-none');
                    $.each(response.errors,function(key,err_value)
                    {
                      $('#update_erroradmin').append('<li>'+err_value+'</li>');
                    });
                  } 
                  else if (response.status==404)
                  {
                      alert(response.message);

                  } 
                  else if (response.status==200)
                  {
                      $('#assignadminmodal').modal('hide');
                      managesignedupuserstable.ajax.reload();
                      alertify.set('notifier','position', 'top-right');
                      alertify.success(response.message);
                      $('#roleid').val('');
                  }
                }
              })
          })

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
                    $('#tenantstat_id').val(arr).trigger('change');
                              
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
                    managesignedupuserstable.ajax.reload();
                    $('#tenant_name').val('');
                    $('#tenantuser_id').val('');
                    $("#tenantstat_id").val('');
                    $('#activateusermodal').modal('hide');
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(response.message);
                }
                else if (response.status==200)
                {
                    managesignedupuserstable.ajax.reload();
                    $('#tenant_name').val('');
                    $('#tenantuser_id').val('');
                    $("#tenantstat_id").val('');
                    $('#activateusermodal').modal('hide');
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(response.message);
                }
                else if (response.status==404)
                {
                    managesignedupuserstable.ajax.reload();
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
    </script>
@stop



