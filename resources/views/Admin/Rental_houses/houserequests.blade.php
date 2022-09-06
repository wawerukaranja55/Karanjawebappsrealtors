@extends('Admin.adminmaster')
@section('title','House Requests By Users')
@section('content')

<div class="row" style="margin: 18px 0;">
  <div class="col-lg-4" style="
  display: flex;
  justify-content: center;">
      <div class="pull-left p-10">
          <a class="btn btn-success" href="{{ url('admin/activerentals') }}">All Active Rentals</a>
      </div>
  </div>
  <div class="col-lg-4" style="
  display: flex;
  justify-content: center;">
      <div class="pull-left p-10">
        <a class="btn btn-success" href="{{ url('admin/registered_users') }}">All Registered Users</a>
    </div>
  </div>
</div>
<table id="houserequeststable" class="table table-striped table-bordered" style="width:100%; margin-top:50px;">
  <thead>
    <tr>
      <td>id</td>
      <td>Name</td>
      <td>Email</td>
      <td>Phone Number</td>
      <td>Message Request</td>
      <td>Delete</td>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>
@endsection

@section('hserequestmgmtscript')
  <script>

    // show activated houses of the house in a datatable
    var hserequeststable = $('#houserequeststable').DataTable({
        processing:true,
        serverside:true,
        responsive:true,

        ajax:"{{ route('user.houserequests') }}",
        columns: [
          { data: 'id' },
          { data: 'name' },
          { data: 'email' },
          { data: 'phone' },
          { data: 'delete',name:'delete',orderable:false,searchable:false },
        ],
      });

  </script>
@stop



