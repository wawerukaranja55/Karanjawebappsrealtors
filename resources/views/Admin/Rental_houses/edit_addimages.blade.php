
@extends('Admin.adminmaster')
@section('title','Add Alternate Images')
@section('content')
@section('addimagesandroomsstyles')
    <style>
        .importantnotes{
            padding: 2px;
            border-radius: 50%;
            font-size: 15px;
            text-align: center;    
            background: #080808;
            color: #fff;
        }
    </style>
@stop
<?php use App\Models\Rentalhousesize; ?>

<div class="row" style="
    display: flex;
    justify-content: center;">
   <div class="col-md-3">
      <a class="btn btn-dark" href="{{ url('admin/inactiverentals') }}">Inactive Rental Houses</a>
   </div>
   <div class="col-md-3">
    <a class="btn btn-dark" href="{{ url('admin/activerentals') }}">Activated Rental Houses</a>
 </div>
   <div class="col-md-3">
      <a class="btn btn-dark" href="{{ route('addrentalhse') }}">Add a New Rental House</a>
   </div>
   <div class="col-md-3">
      <a class="btn btn-dark" href="{{ route('alllocations.index') }}">Add a New Location</a>
   </div>
</div>
    {{-- Add Rental House Extra Images--}}
    
    <div class="panel-heading mt-5" style="text-align: center; font-size:18px; background-color:black;"> 
        <h3 class="panel-title">Add Extra Images and Room Names To Publish The Rental House</h3> 
    </div>      
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-6">
            @if (!empty($rentaldata->rental_video))

                <h3>Change video for the Rental house</h3>
                <div class="changehsevideo">
                    <form action="{{ url('admin/addrentalvideo/'.$rentaldata->id) }}" class="dropzone form-horizontal dropzone-videoform" role="form" method="POST" enctype="multipart/form-data">
                        @csrf
                    </form>
                </div>
                <video class="video-js" controls preload="auto" width="100%" height="100" margin-top="10px" data-setup="{}">
                    <source src="/videos/rentalvideos/{{$rentaldata->rental_video}}" type='video/mp4'>
                </video>
                <a class="confirmvideodelete" href="javascript:void(0)" data-id="{{ $rentaldata->id }}">Delete Video and Replace it</a> 
            @else
                <h3>Add a video for the Rental house <span class="font-type:italics;">(optional)</span></h3>
                <form action="{{ url('admin/addrentalvideo/'.$rentaldata->id) }}" class="dropzone form-horizontal dropzone-videoform" role="form" method="POST" enctype="multipart/form-data">
                    @csrf
                </form>
            @endif
            
        </div>
        <div class="col-lg-6">
            <div class="pull-right p-10">
                <h3>Important Notes</h3>
                <ol type="1">
                    <li class="font-bold text-uppercase text-danger">Add <span class="importantnotes">{{ $rentaldata->total_rooms }}</span> room names and a maximum of 5 extra images for this house to publish the rental House</li>
                    <li class="font-bold text-uppercase text-danger">The House is still inactive if all the rooms and images arent added</li>
                    <li class="font-bold text-uppercase text-danger">Add The Extra Images for the Rental house</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">Add Extra images for {{ $rentaldata->rental_name }}</h3>
            <input type="hidden" id="images_id" class="roomimageid" value="{{ $rentaldata->id }}" >
            <div class="form_group">
                <div class="d-flex">
                    <label>1.House Name</label>:&nbsp;&nbsp;&nbsp;{{ $rentaldata->rental_name }}
                </div>
            </div>
            
            <div class="form_group">
                <div class="d-flex">
                    <label>2.House Location</label>:&nbsp;&nbsp;&nbsp;{{ $rentaldata->houselocation['location_title'] }}
                </div>
            </div>
            <form id="dropzone-form" action="{{ url('admin/alternateimages/'.$rentaldata->id) }}" class="dropzone form-horizontal" role="form" method="POST" enctype="multipart/form-data">
                @csrf
            </form>

            <table id="rentalhseimages" class="table table-striped table-bordered nowrap addimages" style="width:18%; margin-top:70px;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="col-md-7">
            @if($hsesizes === [1,2,6])
                <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">House Sizes and Room Names Management</h3>
                @if ((int)$roomsizescount !== $rentaldata->total_rooms)
                    <section id="tabs" class="project-tab">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <nav>
                                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active home-tab" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                                <span class="createhsesizeform">1.</span>Add A House Size</a>
                                            <a class="nav-item nav-link disabled" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                                                <span class="createroomsform">2.</span>Add Room names and their Sizes</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                        <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                            {{ $rntalhsetags->rentaltag_title }}</span>,
                                                        @endforeach</p>
                                                    <form action="javascript:void(0)" class="form-horizontal" id="uploadroomsizesform" role="form" method="POST">
                                                        @csrf
                                                        <div class="card product-card">
                                                            <div class="card-body">
                                                            <div class="form-group">
                                                                <div class="field_wrapper">
                                                                    <div>
                                                                        <input id="house_id" type="hidden" name="rentalhouseid" value="{{ $rentaldata->id }}"/>
                                                                        <input id="rentalroom_size" type="text"  name="room_size[]" placeholder="Room size" style="width:150px"/>
                                                                        <input id="rentalroomsize_price" type="number" name="roomsize_price[]" placeholder="Room Size Price" style="width:150px"/>
                                                                        <input id="totalrooms" type="number" name="total_rooms[]" placeholder="Total Rooms" style="width:150px"/>
                            
                                                                        <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" id="uploadroomsizesbtn" class="btn btn-success">Upload the House Sizes</button>
                                                        <ul class="alert alert-warning d-none" id="update_housesizelist"></ul>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                            <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                    {{ $rntalhsetags->rentaltag_title }}</span>,
                                                @endforeach</p>
                                            <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                                                @csrf
                                                <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                                                
                                                <div class="card padding-card product-card">
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                                        <div class="row section-groups">
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                                                <br>
                                                                <select id="selectrmsize" name="rentalhousermsize" style="width: 100%;" class="adminselect2 form-control text-white bg-dark" required>
                                                                </select>
                                                            </div>
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                                                <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit"  class="btn btn-success">Create A Room Name</button>
                                            </form>
                            
                                            <div class="col-md-12">
                                                <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Name</th>
                                                            <th>Room Size</th>
                                                            <th>Status</th>
                                                            <th>Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @else
                    <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                        @csrf
                        <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                        
                        <div class="card padding-card product-card">
                            <div class="card-body">
                                <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                <div class="row section-groups">
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                        <br>
                                        <select name="rentalhousermsize" class="adminselect2 form-control text-white bg-dark" style="width:100%;" required>
                                            <option value="0" disabled="true" selected="true">Choose Your Rental House</option>
                                            <?php
                                                $addedhousesizes=Rentalhousesize::where('rentalhse_id',$rentaldata->id)->get();
                                            ?>
                                            @foreach($addedhousesizes as $housesize)
                                                <option value="{{ $housesize->room_size }}">
                                                    {{ $housesize->room_size }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                        <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit"  class="btn btn-success">Create A Room Name</button>
                    </form>

                    <div class="col-md-12">
                        <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Room Size</th>
                                    <th>Status</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                @endif   
            @elseif($hsesizes === [1,6])
                <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">House Sizes and Room Names Management</h3>
                @if ((int)$roomsizescount !== $rentaldata->total_rooms)
                    <section id="tabs" class="project-tab">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <nav>
                                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active home-tab" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                                <span class="createhsesizeform">1.</span>Add A House Size</a>
                                            <a class="nav-item nav-link disabled" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                                                <span class="createroomsform">2.</span>Add Room names and their Sizes</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                        <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                            {{ $rntalhsetags->rentaltag_title }}</span>,
                                                        @endforeach</p>
                                                    <form action="javascript:void(0)" class="form-horizontal" id="uploadroomsizesform" role="form" method="POST">
                                                        @csrf
                                                        <div class="card product-card">
                                                            <div class="card-body">
                                                            <div class="form-group">
                                                                <div class="field_wrapper">
                                                                    <div>
                                                                        <input id="house_id" type="hidden" name="rentalhouseid" value="{{ $rentaldata->id }}"/>
                                                                        <input id="rentalroom_size" type="text"  name="room_size[]" placeholder="Room size" style="width:150px"/>
                                                                        <input id="rentalroomsize_price" type="number" name="roomsize_price[]" placeholder="Room Size Price" style="width:150px"/>
                                                                        <input id="totalrooms" type="number" name="total_rooms[]" placeholder="Total Rooms" style="width:150px"/>
                            
                                                                        <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" id="uploadroomsizesbtn" class="btn btn-success">Upload the House Sizes</button>
                                                        <ul class="alert alert-warning d-none" id="update_housesizelist"></ul>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                            <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                    {{ $rntalhsetags->rentaltag_title }}</span>,
                                                @endforeach</p>
                                            <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                                                @csrf
                                                <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                                                
                                                <div class="card padding-card product-card">
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                                        <div class="row section-groups">
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                                                <br>
                                                                <select id="selectrmsize" name="rentalhousermsize" style="width: 100%;" class="adminselect2 form-control text-white bg-dark" required>
                                                                </select>
                                                            </div>
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                                                <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit"  class="btn btn-success">Create A Room Name</button>
                                            </form>
                            
                                            <div class="col-md-12">
                                                <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Name</th>
                                                            <th>Room Size</th>
                                                            <th>Status</th>
                                                            <th>Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @else
                    <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                        @csrf
                        <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                        
                        <div class="card padding-card product-card">
                            <div class="card-body">
                                <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                <div class="row section-groups">
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                        <br>
                                        <select name="rentalhousermsize" class="adminselect2 form-control text-white bg-dark" style="width:100%;" required>
                                            <option value="0" disabled="true" selected="true">Choose Your Rental House</option>
                                            <?php
                                                $addedhousesizes=Rentalhousesize::where('rentalhse_id',$rentaldata->id)->get();
                                            ?>
                                            @foreach($addedhousesizes as $housesize)
                                                <option value="{{ $housesize->room_size }}">
                                                    {{ $housesize->room_size }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                        <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit"  class="btn btn-success">Create A Room Name</button>
                    </form>

                    <div class="col-md-12">
                        <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Room Size</th>
                                    <th>Status</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                @endif
            @elseif($hsesizes === [5,6])
                <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">House Sizes and Room Names Management</h3>
                @if ((int)$roomsizescount !== $rentaldata->total_rooms)
                    <section id="tabs" class="project-tab">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <nav>
                                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active home-tab" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                                <span class="createhsesizeform">1.</span>Add A House Size</a>
                                            <a class="nav-item nav-link disabled" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                                                <span class="createroomsform">2.</span>Add Room names and their Sizes</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                        <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                            {{ $rntalhsetags->rentaltag_title }}</span>,
                                                        @endforeach</p>
                                                    <form action="javascript:void(0)" class="form-horizontal" id="uploadroomsizesform" role="form" method="POST">
                                                        @csrf
                                                        <div class="card product-card">
                                                            <div class="card-body">
                                                            <div class="form-group">
                                                                <div class="field_wrapper">
                                                                    <div>
                                                                        <input id="house_id" type="hidden" name="rentalhouseid" value="{{ $rentaldata->id }}"/>
                                                                        <input id="rentalroom_size" type="text"  name="room_size[]" placeholder="Room size" style="width:150px"/>
                                                                        <input id="rentalroomsize_price" type="number" name="roomsize_price[]" placeholder="Room Size Price" style="width:150px"/>
                                                                        <input id="totalrooms" type="number" name="total_rooms[]" placeholder="Total Rooms" style="width:150px"/>
                            
                                                                        <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" id="uploadroomsizesbtn" class="btn btn-success">Upload the House Sizes</button>
                                                        <ul class="alert alert-warning d-none" id="update_housesizelist"></ul>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                            <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                    {{ $rntalhsetags->rentaltag_title }}</span>,
                                                @endforeach</p>
                                            <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                                                @csrf
                                                <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                                                
                                                <div class="card padding-card product-card">
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                                        <div class="row section-groups">
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                                                <br>
                                                                <select id="selectrmsize" name="rentalhousermsize" style="width: 100%;" class="adminselect2 form-control text-white bg-dark" required>
                                                                </select>
                                                            </div>
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                                                <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit"  class="btn btn-success">Create A Room Name</button>
                                            </form>
                            
                                            <div class="col-md-12">
                                                <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Name</th>
                                                            <th>Room Size</th>
                                                            <th>Status</th>
                                                            <th>Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @else
                    <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                        @csrf
                        <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                        
                        <div class="card padding-card product-card">
                            <div class="card-body">
                                <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                <div class="row section-groups">
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                        <br>
                                        <select name="rentalhousermsize" class="adminselect2 form-control text-white bg-dark" style="width:100%;" required>
                                            <option value="0" disabled="true" selected="true">Choose Your Rental House</option>
                                            <?php
                                                $addedhousesizes=Rentalhousesize::where('rentalhse_id',$rentaldata->id)->get();
                                            ?>
                                            @foreach($addedhousesizes as $housesize)
                                                <option value="{{ $housesize->room_size }}">
                                                    {{ $housesize->room_size }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                        <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit"  class="btn btn-success">Create A Room Name</button>
                    </form>

                    <div class="col-md-12">
                        <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Room Size</th>
                                    <th>Status</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                @endif
            @elseif($hsesizes === [1,2,3])
                <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">House Sizes and Room Names Management</h3>
                @if ((int)$roomsizescount !== $rentaldata->total_rooms)
                    <section id="tabs" class="project-tab">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <nav>
                                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active home-tab" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                                <span class="createhsesizeform">1.</span>Add A House Size</a>
                                            <a class="nav-item nav-link disabled" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                                                <span class="createroomsform">2.</span>Add Room names and their Sizes</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                        <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                            {{ $rntalhsetags->rentaltag_title }}</span>,
                                                        @endforeach</p>
                                                    <form action="javascript:void(0)" class="form-horizontal" id="uploadroomsizesform" role="form" method="POST">
                                                        @csrf
                                                        <div class="card product-card">
                                                            <div class="card-body">
                                                            <div class="form-group">
                                                                <div class="field_wrapper">
                                                                    <div>
                                                                        <input id="house_id" type="hidden" name="rentalhouseid" value="{{ $rentaldata->id }}"/>
                                                                        <input id="rentalroom_size" type="text"  name="room_size[]" placeholder="Room size" style="width:150px"/>
                                                                        <input id="rentalroomsize_price" type="number" name="roomsize_price[]" placeholder="Room Size Price" style="width:150px"/>
                                                                        <input id="totalrooms" type="number" name="total_rooms[]" placeholder="Total Rooms" style="width:150px"/>
                            
                                                                        <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" id="uploadroomsizesbtn" class="btn btn-success">Upload the House Sizes</button>
                                                        <ul class="alert alert-warning d-none" id="update_housesizelist"></ul>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                            <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                    {{ $rntalhsetags->rentaltag_title }}</span>,
                                                @endforeach</p>
                                            <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                                                @csrf
                                                <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                                                
                                                <div class="card padding-card product-card">
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                                        <div class="row section-groups">
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                                                <br>
                                                                <select id="selectrmsize" name="rentalhousermsize" style="width: 100%;" class="adminselect2 form-control text-white bg-dark" required>
                                                                </select>
                                                            </div>
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                                                <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit"  class="btn btn-success">Create A Room Name</button>
                                            </form>
                            
                                            <div class="col-md-12">
                                                <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Name</th>
                                                            <th>Room Size</th>
                                                            <th>Status</th>
                                                            <th>Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @else
                    <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                        @csrf
                        <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                        
                        <div class="card padding-card product-card">
                            <div class="card-body">
                                <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                <div class="row section-groups">
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                        <br>
                                        <select name="rentalhousermsize" class="adminselect2 form-control text-white bg-dark" style="width:100%;" required>
                                            <option value="0" disabled="true" selected="true">Choose Your Rental House</option>
                                            <?php
                                                $addedhousesizes=Rentalhousesize::where('rentalhse_id',$rentaldata->id)->get();
                                            ?>
                                            @foreach($addedhousesizes as $housesize)
                                                <option value="{{ $housesize->room_size }}">
                                                    {{ $housesize->room_size }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                        <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit"  class="btn btn-success">Create A Room Name</button>
                    </form>

                    <div class="col-md-12">
                        <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Room Size</th>
                                    <th>Status</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                @endif
            @elseif($hsesizes === [1,2])
                <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">House Sizes and Room Names Management</h3>
                @if ((int)$roomsizescount !== $rentaldata->total_rooms)
                    <section id="tabs" class="project-tab">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <nav>
                                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active home-tab" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                                <span class="createhsesizeform">1.</span>Add A House Size</a>
                                            <a class="nav-item nav-link disabled" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                                                <span class="createroomsform">2.</span>Add Room names and their Sizes</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                        <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                            {{ $rntalhsetags->rentaltag_title }}</span>,
                                                        @endforeach</p>
                                                    <form action="javascript:void(0)" class="form-horizontal" id="uploadroomsizesform" role="form" method="POST">
                                                        @csrf
                                                        <div class="card product-card">
                                                            <div class="card-body">
                                                            <div class="form-group">
                                                                <div class="field_wrapper">
                                                                    <div>
                                                                        <input id="house_id" type="hidden" name="rentalhouseid" value="{{ $rentaldata->id }}"/>
                                                                        <input id="rentalroom_size" type="text"  name="room_size[]" placeholder="Room size" style="width:150px"/>
                                                                        <input id="rentalroomsize_price" type="number" name="roomsize_price[]" placeholder="Room Size Price" style="width:150px"/>
                                                                        <input id="totalrooms" type="number" name="total_rooms[]" placeholder="Total Rooms" style="width:150px"/>
                            
                                                                        <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" id="uploadroomsizesbtn" class="btn btn-success">Upload the House Sizes</button>
                                                        <ul class="alert alert-warning d-none" id="update_housesizelist"></ul>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                            <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                    {{ $rntalhsetags->rentaltag_title }}</span>,
                                                @endforeach</p>
                                            <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                                                @csrf
                                                <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                                                
                                                <div class="card padding-card product-card">
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                                        <div class="row section-groups">
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                                                <br>
                                                                <select id="selectrmsize" name="rentalhousermsize" style="width: 100%;" class="adminselect2 form-control text-white bg-dark" required>
                                                                </select>
                                                            </div>
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                                                <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit"  class="btn btn-success">Create A Room Name</button>
                                            </form>
                            
                                            <div class="col-md-12">
                                                <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Name</th>
                                                            <th>Room Size</th>
                                                            <th>Status</th>
                                                            <th>Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @else
                    <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                        @csrf
                        <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                        
                        <div class="card padding-card product-card">
                            <div class="card-body">
                                <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                <div class="row section-groups">
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                        <br>
                                        <select name="rentalhousermsize" class="adminselect2 form-control text-white bg-dark" style="width:100%;" required>
                                            <option value="0" disabled="true" selected="true">Choose Your Rental House</option>
                                            <?php
                                                $addedhousesizes=Rentalhousesize::where('rentalhse_id',$rentaldata->id)->get();
                                            ?>
                                            @foreach($addedhousesizes as $housesize)
                                                <option value="{{ $housesize->room_size }}">
                                                    {{ $housesize->room_size }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                        <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit"  class="btn btn-success">Create A Room Name</button>
                    </form>

                    <div class="col-md-12">
                        <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Room Size</th>
                                    <th>Status</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                @endif
            @elseif($hsesizes === [2,3])
                <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">House Sizes and Room Names Management</h3>
                @if ((int)$roomsizescount !== $rentaldata->total_rooms)
                    <section id="tabs" class="project-tab">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <nav>
                                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active home-tab" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                                <span class="createhsesizeform">1.</span>Add A House Size</a>
                                            <a class="nav-item nav-link disabled" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                                                <span class="createroomsform">2.</span>Add Room names and their Sizes</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                        <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                            {{ $rntalhsetags->rentaltag_title }}</span>,
                                                        @endforeach</p>
                                                    <form action="javascript:void(0)" class="form-horizontal" id="uploadroomsizesform" role="form" method="POST">
                                                        @csrf
                                                        <div class="card product-card">
                                                            <div class="card-body">
                                                            <div class="form-group">
                                                                <div class="field_wrapper">
                                                                    <div>
                                                                        <input id="house_id" type="hidden" name="rentalhouseid" value="{{ $rentaldata->id }}"/>
                                                                        <input id="rentalroom_size" type="text"  name="room_size[]" placeholder="Room size" style="width:150px"/>
                                                                        <input id="rentalroomsize_price" type="number" name="roomsize_price[]" placeholder="Room Size Price" style="width:150px"/>
                                                                        <input id="totalrooms" type="number" name="total_rooms[]" placeholder="Total Rooms" style="width:150px"/>
                            
                                                                        <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" id="uploadroomsizesbtn" class="btn btn-success">Upload the House Sizes</button>
                                                        <ul class="alert alert-warning d-none" id="update_housesizelist"></ul>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                            <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                    {{ $rntalhsetags->rentaltag_title }}</span>,
                                                @endforeach</p>
                                            <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                                                @csrf
                                                <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                                                
                                                <div class="card padding-card product-card">
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                                        <div class="row section-groups">
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                                                <br>
                                                                <select id="selectrmsize" name="rentalhousermsize" style="width: 100%;" class="adminselect2 form-control text-white bg-dark" required>
                                                                </select>
                                                            </div>
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                                                <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit"  class="btn btn-success">Create A Room Name</button>
                                            </form>
                            
                                            <div class="col-md-12">
                                                <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Name</th>
                                                            <th>Room Size</th>
                                                            <th>Status</th>
                                                            <th>Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @else
                    <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                        @csrf
                        <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                        
                        <div class="card padding-card product-card">
                            <div class="card-body">
                                <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                <div class="row section-groups">
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                        <br>
                                        <select name="rentalhousermsize" class="adminselect2 form-control text-white bg-dark" style="width:100%;" required>
                                            <option value="0" disabled="true" selected="true">Choose Your Rental House</option>
                                            <?php
                                                $addedhousesizes=Rentalhousesize::where('rentalhse_id',$rentaldata->id)->get();
                                            ?>
                                            @foreach($addedhousesizes as $housesize)
                                                <option value="{{ $housesize->room_size }}">
                                                    {{ $housesize->room_size }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                        <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit"  class="btn btn-success">Create A Room Name</button>
                    </form>

                    <div class="col-md-12">
                        <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Room Size</th>
                                    <th>Status</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                @endif
            @elseif($hsesizes === [6,7])
                <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">House Sizes and Room Names Management</h3>
                @if ((int)$roomsizescount !== $rentaldata->total_rooms)
                    <section id="tabs" class="project-tab">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <nav>
                                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active home-tab" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                                <span class="createhsesizeform">1.</span>Add A House Size</a>
                                            <a class="nav-item nav-link disabled" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                                                <span class="createroomsform">2.</span>Add Room names and their Sizes</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                        <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                            {{ $rntalhsetags->rentaltag_title }}</span>,
                                                        @endforeach</p>
                                                    <form action="javascript:void(0)" class="form-horizontal" id="uploadroomsizesform" role="form" method="POST">
                                                        @csrf
                                                        <div class="card product-card">
                                                            <div class="card-body">
                                                            <div class="form-group">
                                                                <div class="field_wrapper">
                                                                    <div>
                                                                        <input id="house_id" type="hidden" name="rentalhouseid" value="{{ $rentaldata->id }}"/>
                                                                        <input id="rentalroom_size" type="text"  name="room_size[]" placeholder="Room size" style="width:150px"/>
                                                                        <input id="rentalroomsize_price" type="number" name="roomsize_price[]" placeholder="Room Size Price" style="width:150px"/>
                                                                        <input id="totalrooms" type="number" name="total_rooms[]" placeholder="Total Rooms" style="width:150px"/>
                            
                                                                        <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" id="uploadroomsizesbtn" class="btn btn-success">Upload the House Sizes</button>
                                                        <ul class="alert alert-warning d-none" id="update_housesizelist"></ul>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                            <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                    {{ $rntalhsetags->rentaltag_title }}</span>,
                                                @endforeach</p>
                                            <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                                                @csrf
                                                <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                                                
                                                <div class="card padding-card product-card">
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                                        <div class="row section-groups">
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                                                <br>
                                                                <select id="selectrmsize" name="rentalhousermsize" style="width: 100%;" class="adminselect2 form-control text-white bg-dark" required>
                                                                </select>
                                                            </div>
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                                                <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit"  class="btn btn-success">Create A Room Name</button>
                                            </form>
                            
                                            <div class="col-md-12">
                                                <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Name</th>
                                                            <th>Room Size</th>
                                                            <th>Status</th>
                                                            <th>Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @else
                    <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                        @csrf
                        <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                        
                        <div class="card padding-card product-card">
                            <div class="card-body">
                                <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                <div class="row section-groups">
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                        <br>
                                        <select name="rentalhousermsize" class="adminselect2 form-control text-white bg-dark" style="width:100%;" required>
                                            <option value="0" disabled="true" selected="true">Choose Your Rental House</option>
                                            <?php
                                                $addedhousesizes=Rentalhousesize::where('rentalhse_id',$rentaldata->id)->get();
                                            ?>
                                            @foreach($addedhousesizes as $housesize)
                                                <option value="{{ $housesize->room_size }}">
                                                    {{ $housesize->room_size }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                        <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit"  class="btn btn-success">Create A Room Name</button>
                    </form>

                    <div class="col-md-12">
                        <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Room Size</th>
                                    <th>Status</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                @endif
            @elseif($hsesizes === [1,2,10])
                <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">House Sizes and Room Names Management</h3>
                @if ((int)$roomsizescount !== $rentaldata->total_rooms)
                    <section id="tabs" class="project-tab">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <nav>
                                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active home-tab" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                                <span class="createhsesizeform">1.</span>Add A House Size</a>
                                            <a class="nav-item nav-link disabled" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                                                <span class="createroomsform">2.</span>Add Room names and their Sizes</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                        <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                            {{ $rntalhsetags->rentaltag_title }}</span>,
                                                        @endforeach</p>
                                                    <form action="javascript:void(0)" class="form-horizontal" id="uploadroomsizesform" role="form" method="POST">
                                                        @csrf
                                                        <div class="card product-card">
                                                            <div class="card-body">
                                                            <div class="form-group">
                                                                <div class="field_wrapper">
                                                                    <div>
                                                                        <input id="house_id" type="hidden" name="rentalhouseid" value="{{ $rentaldata->id }}"/>
                                                                        <input id="rentalroom_size" type="text"  name="room_size[]" placeholder="Room size" style="width:150px"/>
                                                                        <input id="rentalroomsize_price" type="number" name="roomsize_price[]" placeholder="Room Size Price" style="width:150px"/>
                                                                        <input id="totalrooms" type="number" name="total_rooms[]" placeholder="Total Rooms" style="width:150px"/>
                            
                                                                        <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" id="uploadroomsizesbtn" class="btn btn-success">Upload the House Sizes</button>
                                                        <ul class="alert alert-warning d-none" id="update_housesizelist"></ul>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                            <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                    {{ $rntalhsetags->rentaltag_title }}</span>,
                                                @endforeach</p>
                                            <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                                                @csrf
                                                <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                                                
                                                <div class="card padding-card product-card">
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                                        <div class="row section-groups">
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                                                <br>
                                                                <select id="selectrmsize" name="rentalhousermsize" style="width: 100%;" class="adminselect2 form-control text-white bg-dark" required>
                                                                </select>
                                                            </div>
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                                                <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit"  class="btn btn-success">Create A Room Name</button>
                                            </form>
                            
                                            <div class="col-md-12">
                                                <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Name</th>
                                                            <th>Room Size</th>
                                                            <th>Status</th>
                                                            <th>Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @else
                    <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                        @csrf
                        <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                        
                        <div class="card padding-card product-card">
                            <div class="card-body">
                                <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                <div class="row section-groups">
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                        <br>
                                        <select name="rentalhousermsize" class="adminselect2 form-control text-white bg-dark" style="width:100%;" required>
                                            <option value="0" disabled="true" selected="true">Choose Your Rental House</option>
                                            <?php
                                                $addedhousesizes=Rentalhousesize::where('rentalhse_id',$rentaldata->id)->get();
                                            ?>
                                            @foreach($addedhousesizes as $housesize)
                                                <option value="{{ $housesize->room_size }}">
                                                    {{ $housesize->room_size }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                        <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit"  class="btn btn-success">Create A Room Name</button>
                    </form>

                    <div class="col-md-12">
                        <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Room Size</th>
                                    <th>Status</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                @endif
            @elseif($hsesizes === [1,2,3,10])
                <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">House Sizes and Room Names Management</h3>
                @if ((int)$roomsizescount !== $rentaldata->total_rooms)
                    <section id="tabs" class="project-tab">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <nav>
                                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active home-tab" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                                <span class="createhsesizeform">1.</span>Add A House Size</a>
                                            <a class="nav-item nav-link disabled" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                                                <span class="createroomsform">2.</span>Add Room names and their Sizes</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                        <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                            {{ $rntalhsetags->rentaltag_title }}</span>,
                                                        @endforeach</p>
                                                    <form action="javascript:void(0)" class="form-horizontal" id="uploadroomsizesform" role="form" method="POST">
                                                        @csrf
                                                        <div class="card product-card">
                                                            <div class="card-body">
                                                            <div class="form-group">
                                                                <div class="field_wrapper">
                                                                    <div>
                                                                        <input id="house_id" type="hidden" name="rentalhouseid" value="{{ $rentaldata->id }}"/>
                                                                        <input id="rentalroom_size" type="text"  name="room_size[]" placeholder="Room size" style="width:150px"/>
                                                                        <input id="rentalroomsize_price" type="number" name="roomsize_price[]" placeholder="Room Size Price" style="width:150px"/>
                                                                        <input id="totalrooms" type="number" name="total_rooms[]" placeholder="Total Rooms" style="width:150px"/>
                            
                                                                        <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" id="uploadroomsizesbtn" class="btn btn-success">Upload the House Sizes</button>
                                                        <ul class="alert alert-warning d-none" id="update_housesizelist"></ul>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                            <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                    {{ $rntalhsetags->rentaltag_title }}</span>,
                                                @endforeach</p>
                                            <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                                                @csrf
                                                <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                                                
                                                <div class="card padding-card product-card">
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                                        <div class="row section-groups">
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                                                <br>
                                                                <select id="selectrmsize" name="rentalhousermsize" style="width: 100%;" class="adminselect2 form-control text-white bg-dark" required>
                                                                </select>
                                                            </div>
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                                                <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit"  class="btn btn-success">Create A Room Name</button>
                                            </form>
                            
                                            <div class="col-md-12">
                                                <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Name</th>
                                                            <th>Room Size</th>
                                                            <th>Status</th>
                                                            <th>Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @else
                    <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                        @csrf
                        <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                        
                        <div class="card padding-card product-card">
                            <div class="card-body">
                                <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                <div class="row section-groups">
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                        <br>
                                        <select name="rentalhousermsize" class="adminselect2 form-control text-white bg-dark" style="width:100%;" required>
                                            <option value="0" disabled="true" selected="true">Choose Your Rental House</option>
                                            <?php
                                                $addedhousesizes=Rentalhousesize::where('rentalhse_id',$rentaldata->id)->get();
                                            ?>
                                            @foreach($addedhousesizes as $housesize)
                                                <option value="{{ $housesize->room_size }}">
                                                    {{ $housesize->room_size }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                        <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit"  class="btn btn-success">Create A Room Name</button>
                    </form>

                    <div class="col-md-12">
                        <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Room Size</th>
                                    <th>Status</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                @endif
            @elseif($hsesizes === [6,7,10])
                <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">House Sizes and Room Names Management</h3>
                @if ((int)$roomsizescount !== $rentaldata->total_rooms)
                    <section id="tabs" class="project-tab">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <nav>
                                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active home-tab" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                                <span class="createhsesizeform">1.</span>Add A House Size</a>
                                            <a class="nav-item nav-link disabled" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                                                <span class="createroomsform">2.</span>Add Room names and their Sizes</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                        <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                            {{ $rntalhsetags->rentaltag_title }}</span>,
                                                        @endforeach</p>
                                                    <form action="javascript:void(0)" class="form-horizontal" id="uploadroomsizesform" role="form" method="POST">
                                                        @csrf
                                                        <div class="card product-card">
                                                            <div class="card-body">
                                                            <div class="form-group">
                                                                <div class="field_wrapper">
                                                                    <div>
                                                                        <input id="house_id" type="hidden" name="rentalhouseid" value="{{ $rentaldata->id }}"/>
                                                                        <input id="rentalroom_size" type="text"  name="room_size[]" placeholder="Room size" style="width:150px"/>
                                                                        <input id="rentalroomsize_price" type="number" name="roomsize_price[]" placeholder="Room Size Price" style="width:150px"/>
                                                                        <input id="totalrooms" type="number" name="total_rooms[]" placeholder="Total Rooms" style="width:150px"/>
                            
                                                                        <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" id="uploadroomsizesbtn" class="btn btn-success">Upload the House Sizes</button>
                                                        <ul class="alert alert-warning d-none" id="update_housesizelist"></ul>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                            <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                    {{ $rntalhsetags->rentaltag_title }}</span>,
                                                @endforeach</p>
                                            <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                                                @csrf
                                                <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                                                
                                                <div class="card padding-card product-card">
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                                        <div class="row section-groups">
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                                                <br>
                                                                <select id="selectrmsize" name="rentalhousermsize" style="width: 100%;" class="adminselect2 form-control text-white bg-dark" required>
                                                                </select>
                                                            </div>
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                                                <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit"  class="btn btn-success">Create A Room Name</button>
                                            </form>
                            
                                            <div class="col-md-12">
                                                <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Name</th>
                                                            <th>Room Size</th>
                                                            <th>Status</th>
                                                            <th>Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @else
                    <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                        @csrf
                        <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                        
                        <div class="card padding-card product-card">
                            <div class="card-body">
                                <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                <div class="row section-groups">
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                        <br>
                                        <select name="rentalhousermsize" class="adminselect2 form-control text-white bg-dark" style="width:100%;" required>
                                            <option value="0" disabled="true" selected="true">Choose Your Rental House</option>
                                            <?php
                                                $addedhousesizes=Rentalhousesize::where('rentalhse_id',$rentaldata->id)->get();
                                            ?>
                                            @foreach($addedhousesizes as $housesize)
                                                <option value="{{ $housesize->room_size }}">
                                                    {{ $housesize->room_size }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                        <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit"  class="btn btn-success">Create A Room Name</button>
                    </form>

                    <div class="col-md-12">
                        <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Room Size</th>
                                    <th>Status</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                @endif
            @elseif($hsesizes === [1,2,7,10])
                <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">House Sizes and Room Names Management</h3>
                @if ((int)$roomsizescount !== $rentaldata->total_rooms)
                    <section id="tabs" class="project-tab">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <nav>
                                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active home-tab" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                                <span class="createhsesizeform">1.</span>Add A House Size</a>
                                            <a class="nav-item nav-link disabled" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                                                <span class="createroomsform">2.</span>Add Room names and their Sizes</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                        <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                            {{ $rntalhsetags->rentaltag_title }}</span>,
                                                        @endforeach</p>
                                                    <form action="javascript:void(0)" class="form-horizontal" id="uploadroomsizesform" role="form" method="POST">
                                                        @csrf
                                                        <div class="card product-card">
                                                            <div class="card-body">
                                                            <div class="form-group">
                                                                <div class="field_wrapper">
                                                                    <div>
                                                                        <input id="house_id" type="hidden" name="rentalhouseid" value="{{ $rentaldata->id }}"/>
                                                                        <input id="rentalroom_size" type="text"  name="room_size[]" placeholder="Room size" style="width:150px"/>
                                                                        <input id="rentalroomsize_price" type="number" name="roomsize_price[]" placeholder="Room Size Price" style="width:150px"/>
                                                                        <input id="totalrooms" type="number" name="total_rooms[]" placeholder="Total Rooms" style="width:150px"/>
                            
                                                                        <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" id="uploadroomsizesbtn" class="btn btn-success">Upload the House Sizes</button>
                                                        <ul class="alert alert-warning d-none" id="update_housesizelist"></ul>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                            <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                    {{ $rntalhsetags->rentaltag_title }}</span>,
                                                @endforeach</p>
                                            <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                                                @csrf
                                                <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                                                
                                                <div class="card padding-card product-card">
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                                        <div class="row section-groups">
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                                                <br>
                                                                <select id="selectrmsize" name="rentalhousermsize" style="width: 100%;" class="adminselect2 form-control text-white bg-dark" required>
                                                                </select>
                                                            </div>
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                                                <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit"  class="btn btn-success">Create A Room Name</button>
                                            </form>
                            
                                            <div class="col-md-12">
                                                <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Name</th>
                                                            <th>Room Size</th>
                                                            <th>Status</th>
                                                            <th>Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @else
                    <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                        @csrf
                        <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                        
                        <div class="card padding-card product-card">
                            <div class="card-body">
                                <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                <div class="row section-groups">
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                        <br>
                                        <select name="rentalhousermsize" class="adminselect2 form-control text-white bg-dark" style="width:100%;" required>
                                            <option value="0" disabled="true" selected="true">Choose Your Rental House</option>
                                            <?php
                                                $addedhousesizes=Rentalhousesize::where('rentalhse_id',$rentaldata->id)->get();
                                            ?>
                                            @foreach($addedhousesizes as $housesize)
                                                <option value="{{ $housesize->room_size }}">
                                                    {{ $housesize->room_size }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                        <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit"  class="btn btn-success">Create A Room Name</button>
                    </form>

                    <div class="col-md-12">
                        <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Room Size</th>
                                    <th>Status</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                @endif
            @elseif($hsesizes === [8,10])
                <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">House Sizes and Room Names Management</h3>
                @if ((int)$roomsizescount !== $rentaldata->total_rooms)
                    <section id="tabs" class="project-tab">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <nav>
                                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active home-tab" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                                <span class="createhsesizeform">1.</span>Add A House Size</a>
                                            <a class="nav-item nav-link disabled" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                                                <span class="createroomsform">2.</span>Add Room names and their Sizes</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                        <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                            {{ $rntalhsetags->rentaltag_title }}</span>,
                                                        @endforeach</p>
                                                    <form action="javascript:void(0)" class="form-horizontal" id="uploadroomsizesform" role="form" method="POST">
                                                        @csrf
                                                        <div class="card product-card">
                                                            <div class="card-body">
                                                            <div class="form-group">
                                                                <div class="field_wrapper">
                                                                    <div>
                                                                        <input id="house_id" type="hidden" name="rentalhouseid" value="{{ $rentaldata->id }}"/>
                                                                        <input id="rentalroom_size" type="text"  name="room_size[]" placeholder="Room size" style="width:150px"/>
                                                                        <input id="rentalroomsize_price" type="number" name="roomsize_price[]" placeholder="Room Size Price" style="width:150px"/>
                                                                        <input id="totalrooms" type="number" name="total_rooms[]" placeholder="Total Rooms" style="width:150px"/>
                            
                                                                        <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" id="uploadroomsizesbtn" class="btn btn-success">Upload the House Sizes</button>
                                                        <ul class="alert alert-warning d-none" id="update_housesizelist"></ul>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                            <p style="font-size:15px; font-weight:700; color:rgb(147, 15, 165)">The room sizes for this house are 
                                                <span>@foreach ($rentaldata->housetags as $rntalhsetags)
                                                    {{ $rntalhsetags->rentaltag_title }}</span>,
                                                @endforeach</p>
                                            <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                                                @csrf
                                                <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                                                
                                                <div class="card padding-card product-card">
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                                        <div class="row section-groups">
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                                                <br>
                                                                <select id="selectrmsize" name="rentalhousermsize" style="width: 100%;" class="adminselect2 form-control text-white bg-dark" required>
                                                                </select>
                                                            </div>
                                                            <div class="form-group inputdetails col-sm-6">
                                                                <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                                                <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit"  class="btn btn-success">Create A Room Name</button>
                                            </form>
                            
                                            <div class="col-md-12">
                                                <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Name</th>
                                                            <th>Room Size</th>
                                                            <th>Status</th>
                                                            <th>Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @else
                    <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                        @csrf
                        <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                        
                        <div class="card padding-card product-card">
                            <div class="card-body">
                                <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Room Sizes Details for the Rental House</h5>
                                <div class="row section-groups">
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Sizes For this House<span class="text-danger inputrequired">*</span></label>
                                        <br>
                                        <select name="rentalhousermsize" class="adminselect2 form-control text-white bg-dark" style="width:100%;" required>
                                            <option value="0" disabled="true" selected="true">Choose Your Rental House</option>
                                            <?php
                                                $addedhousesizes=Rentalhousesize::where('rentalhse_id',$rentaldata->id)->get();
                                            ?>
                                            @foreach($addedhousesizes as $housesize)
                                                <option value="{{ $housesize->room_size }}">
                                                    {{ $housesize->room_size }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group inputdetails col-sm-6">
                                        <label>Room Name/Number<span class="text-danger inputrequired">*</span></label>
                                        <input type="text" class="form-control text-white bg-dark" required required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                                </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit"  class="btn btn-success">Create A Room Name</button>
                    </form>

                    <div class="col-md-12">
                        <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Room Size</th>
                                    <th>Status</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                @endif
            @else
                <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">Room Names Management</h3>
                <form action="javascript:void(0)" id="addaroomname" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
                    @csrf
                    <input type="hidden" name="rentalhouseid" id="rentalhse_id" value="{{ $rentaldata->id }}" >
                    <div class="form-group">
                        <label for="room_number" style="font-size: 1.5rem margin-top:5px;" class="control-label">Room Name/No.</label>
                        
                        <input type="hidden" name="rentalhousermsize" value="no_room_size">
                        
                        <div class="bg-dark" style="margin-top: 5px;">
                            <input type="text" style="font-size: 1.3rem" class="form-control text-dark" required name="room_numbername" id="room_name" placeholder="Write The Room name here">
                        </div> 
                    </div>
                    <button type="submit" class="btn btn-primary">Create A Room Name</button>   
                </form>

                <div class="col-md-12" style="margin-top: :20px;">
                    <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">Room Names For the Room Sizes</h3>
                    <table class="table table-striped table-bordered roomnamestable" style="width:18%; margin-top:10px;">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Room Size</th>
                                <th>Status</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

@endsection

@section('addimagesscripts')
    <script>
        
        // scroll to the edit form div
        // $("#editrentaldetails").on('click',function() {
            
        //     $('html, body').animate({
        //         'scrollTop' : $("#edithousedata").position().top
        //     });
        // });

        // upload a house video for that rental house using dropzone.js
        Dropzone.autoDiscover = false;
        var dzonerentalvideo = new Dropzone(".dropzone-videoform",{
            maxFilesize: 20000,
            maxFiles: 1,
            acceptedFiles: ".Mp4"
        });

        dzonerentalvideo.on("success",function(file,response){
            console.log(response)
            if(response.status == 200)
            {
                alertify.set('notifier','position', 'top-right');
                alertify.success(response.message);
                
            }
        });
        
        $(document).ready(function(){
            
            // add inputs to the inputs modal
            var maxField = 5; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var fieldHTML = 
            '<div><div style="height:10px;"></div><input type="text" name="room_size[]" style="width:150px" placeholder="Room Size"/>&nbsp;<input type="number" name="roomsize_price[]" style="width:150px" placeholder="Room Size Price"/>&nbsp;<input id="totalrooms[]" type="number" name="total_rooms[]" placeholder="Total Rooms" style="width:150px"/>&nbsp;<a href="javascript:void(0);" class="remove_button">Remove</a></div>';
                            //New input field html 

            var x = 1; //Initial field counter is 1
            
            //Once add button is clicked
            $(addButton).click(function(){
                //Check maximum number of input fields
                if(x < maxField){ 
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });
            
            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e){
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });

            // upload room sizes for the house to the database
            var rentalhseid=$('#house_id').val();
            var url = '{{ route("housesizes.house", ":id") }}';
                url = url.replace(':id', rentalhseid);

            $("#uploadroomsizesform").on("submit",function(e){
                e.preventDefault();
                var uploadroomsizes = $('#uploadroomsizesform')[0];
                var formdata=new FormData(uploadroomsizes);
                $.ajax({
                    url:url,
                    type:"POST",
                    processData:false,
                    contentType:false,
                    data:formdata,
                    success:function(response){
                        console.log(response);
                        if (response.status==400)
                        {
                            $('#update_housesizelist').html(" ");
                            $('#update_housesizelist').removeClass('d-none');
                            $.each(response.message,function(key,err_value)
                            {
                                $('#update_housesizelist').append('<li>' + err_value + '</li>');
                                $("#update_housesizelist").fadeOut(10000);
                            })
                        } 
                        else if (response.status==404)
                        {
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(response.message);
                        }
                        else if (response.status==500)
                        {
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(response.message);
                        }
                        else if (response.status==200)
                        {
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(response.message);

                            $('#nav-profile-tab').removeClass("disabled").addClass("active");

                            $('#nav-home-tab').removeClass("active").addClass("disabled");
                            
                            $('#nav-profile').show();

                            $('#nav-home').hide();

                            $('#selectrmsize').html('<option disabled selected value=" ">Select a Room Size to add Room Name/Number</option>');
                     
                            console.log("the data is ",response.data);
                            $.each(response.data, function(key, roomsize)
                            {
                                console.log(roomsize);
                                $('#selectrmsize').append('<option value="'+roomsize.room_size+'">'+roomsize.room_size+'</option>');
                            });
                            
                        }
                    }
                });

            })
        });

        // Delete house video from the db
        $(document).on('click','.confirmvideodelete',function(){

            var deletehsevideoid=$(this).data('id');

            $('.admindeletemodal').modal('show');
            $('.modal-title').html('Delete House Video');
            $('#housevideo_id').val(deletehsevideoid);

        })

        $(document).on('click','#deletemodalbutton',function()
        {

            var housevideoid=$('#housevideo_id').val();

            $.ajax({
                type:"DELETE",
                url:'{{ url("admin/delete-rentalvideo",'') }}' + '/' + housevideoid,
                data:{housevideo_id: housevideoid},
                success:function(response)
                {
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(response.message);
                    $('.changehsevideo').show("1000");
                    $('.video-js').hide("1000");
                    $('.confirmvideodelete').hide("2000");
                    $('.admindeletemodal').modal('hide');
                    $('#housevideo_id').val('');
                }
            })
        })

        // show all images of the house in a datatable
        var roomimgid=$('.roomimageid').val();
        var url = '{{ route("get_extraimages", ":id") }}';
                url = url.replace(':id', roomimgid);

        var alternateimagestable = $('#rentalhseimages').DataTable({
        
            processing:true,
            serverside:true,
            reponsive:true,

            ajax:
            {
                url:url,
                type: 'get',
                dataType: 'json',
                data:{
                    'id':roomimgid
                },
            },
            columns: [
                { data: 'id' },
                { data: 'image',
                    render: function ( data, type, full, meta, row) {
                        return "<img src=\"/imagesforthewebsite/rentalhouses/alternateimages/small/" + data + "\" height=\"80px\" height=\"80px\"/>"
                    }
                }, 
                { data: 'status',
                    render: function ( data, type, row ) {
                        if ( type === 'display' ) {
                            return '<input class="extraimg" type="checkbox" checked data-toggle="toggle" data-id="' + row.id + '" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
                        }
                        return data;
                    }
                },
                { data: 'delete',name:'delete',orderable:false,searchable:false },
            ],

            rowCallback: function ( row, data ) {
                $('input.extraimg', row)
                .prop( 'checked', data.status == 1 )
                .bootstrapToggle();
            }
        });
        
        // add images using dropzone and add on the datatable without page refresh
        Dropzone.autoDiscover = false;
        var dzonerentalimages = new Dropzone("#dropzone-form",{
            maxFilesize: 2,
            maxFiles: 5,
            acceptedFiles: ".jpeg,.jpg,.png"
        });

        dzonerentalimages.on("success",function(file,response){
            console.log(response.message)
            if(response.success == 1)
            {
                alertify.set('notifier','position', 'top-right');
                alertify.success(response.message);
                alternateimagestable.ajax.reload();
                
            }
        });

        // update house rental details using ajax
        $(document).on('submit','.updaterentaldetails',function(e)
        {
            e.preventDefault();
            var rentalid=$('#rentalhouseid').val();
            var url = '{{ route("updaterentaldetails", ":id") }}';
                    url = url.replace(':id', rentalid);

            let updaterentaldata=new FormData($('.updaterentaldetails')[0]);

            $.ajax({
                type:"POST",
                url:url,
                data:updaterentaldata,
                contentType:false,
                processData:false,
                success:function(response){
                    if (response.status==400)
                    {
                        $('#update_errorlist').html("");
                        $('#update_errorlist').removeClass('d-none');
                        $.each(response.errors,function(key,err_value){
                        $('#update_errorlist').append('<li>'+err_value+'</li>');
                        })
                    } else if (response.status==404)
                    {
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(response.message);

                    } else if (response.status==200)
                    {
                        $('#update_errorlist').html("");
                        $('#update_errorlist').addClass('d-none');
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(response.message);
                    }
                }
            })
        })

        //  update rental house images status from active to inactive
        $(document).on('change','.rentalhousestatus',function(e)
        {
            var hsestatus=$(this).prop('checked')==true? 1:0;

            var rentalhseid=$(this).data('id');
            $.ajax({
                type:"GET",
                dataType:"json",
                url:'{{ route('updatextraimages.status') }}',
                data:{
                    'status':hsestatus,
                    'id':rentalhseid
                },
                success:function(res){
                    console.log(res);
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(res.message);
                }
            });
        });

        // Delete an Alternative image
        $(document).on('click','#deletextraimage',function(){

            var deleteimageid=$(this).data('id');

            $('.removepropertycategory').modal('show');
            $('.modal-title').html('Delete An Alternate Image For a Product');
            $('#propertycategory_id').val('');
            $('#roomname_id').val(deleteimageid);

        })

        $('body').on('click','#deletepropertycategory',function()
        {

            var deleteimgsid=$('#roomname_id').val();

            $.ajax({
            type:"POST",
            url:'{{ url("admin/delete_xtraimage",'') }}' + '/' + deleteimgsid,
            dataType:"json",
            success:function(response)
                {
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(response.message);
                    alternateimagestable.ajax.reload();
                    $('.removepropertycategory').modal('hide');

                    $('#roomname_id').val('');
                }
            })
        })      

        // show all rooms of the house in a datatable
        var roomid=$('.roomimageid').val();
        var url = '{{ route("get_roomnames", ":id") }}';
        url = url.replace(':id', roomid);
        var roomnamestable = $('.roomnamestable').DataTable({
            processing:true,
            serverside:true,
            reponsive:true,

            ajax:
            {
                url:url,
                type: 'get',
                dataType: 'json',
                data:{
                    'id':roomid
                },
            },
            columns: [
                { data: 'id' },
                { data: 'room_name' },
                { data: 'house_size' },
                { data: 'status',
                    render: function ( data, type, row ) {
                        if ( type === 'display' ) {
                            return '<input class="toggle-demo" type="checkbox" checked data-toggle="toggle" data-id="' + row.id + '" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
                        }
                        return data;
                    }
                },
                // { data: 'status',
                //     render: function ( data, type, full, meta, row) {
                //     return '<input class="toggle-demo" type="checkbox" checked data-toggle="toggle" data-id="#" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
                //     }
                // },
                { data: 'action',name:'action',orderable:false,searchable:false },
            ],

            rowCallback: function ( row, data ) {
                $('input.toggle-demo', row)
                .prop( 'checked', data.status == 1 )
                .bootstrapToggle();
            }
        });

        
            // add a room name for the house
        $(document).ready(function(){
            var rentalhouseid=$('#rentalhse_id').val();

            var url = '{{ route("addroomname", ":id") }}';
             url = url.replace(':id', rentalhouseid);
                    
            $("#addaroomname").on("submit",function(e){
                e.preventDefault();
                $.ajax({
                    url:url,
                    type:"POST",
                    data:$("#addaroomname").serialize(),
                    success:function(response){
                        console.log(response)
                        if (response.status==400)
                        {
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(response.message);
                        } else if (response.status==404)
                        {
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(response.message);

                        } else if (response.status==200)
                        {
                            roomnamestable.ajax.reload();
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(response.message);
                        }
                    }
                });
            })
        });

        // edit room details
        $(document).on('click','.editroomname',function(e){
            e.preventDefault();
            var roomid=$(this).data('id');

            $.ajax({
                url:'{{ url("admin/roomname",'') }}' + '/' + roomid + '/edit',
                method:'GET',
                success:function(response){
                $('#admineditmodal').modal('show');
                $('#propertycat_id').val('');
                $('#rentaltag_id').val('');
                $('#property_category').hide();
                $('#rental_tagname').hide();
                $('#location_name').hide();
                $('#room_id').val(response.id);

                $('.modal-title').html('Edit Room Name');
                $('.catlabel').html('Room Name Title');
                $('.save_button').html('Update Room Name');

                $('#room_id').val(response.id);
                $('#roomsize_name').val(response.house_size);
                $('#room_name').val(response.room_name);

                }
            })
        });

            //   update room details
        $(document).on('click','.save_button',function(e){
            e.preventDefault();
            
            var rmid=$('#room_id').val();

            var url = '{{ route("updateroomname", ":id") }}';
            updateroomurl = url.replace(':id', rmid);

            var form = $('.adminedit_form')[0];
            var formdata=new FormData(form);

            $.ajax({
                url:updateroomurl,
                method:'POST',
                processData:false,
                contentType:false,
                data:formdata,
                success:function(response)
                {
                    console.log(response);
                    if (response.status==400)
                    {
                        $('#admineditmodal').modal('hide');
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(response.message);
                        
                    } else if (response.status==200)
                    {
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(response.message);
                        editroomnamestable.ajax.reload();
                        $('#admineditmodal').modal('hide');
                            
                    }
                }
            });
        })

        
    </script>
@stop



