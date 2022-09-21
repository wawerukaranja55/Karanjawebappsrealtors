@extends('Admin.adminmaster')
@section('title','Add a New Property')
@section('content')
<div class="content-wrapper">
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
      <a class="btn btn-dark" href="{{ route('alllocations.index') }}">Add a New Location</a>
   </div>
</div>
    <div class="row" style="margin-bottom: 100px;">    
        <div class="col-lg-8 col-md-8 mx-auto">
            <div class="panel-heading mt-5" style="text-align: center; font-size:18px; background-color:black;"> 
                <h3 class="mb-2 panel-title">Add a New Property</h3> 
            </div>
            @if ($errors)
                @foreach ($errors->all() as $error)
                    <p class="text-danger">{{ $error }}</p>
                @endforeach
            @endif
            <form action="{{ route('property.store') }}" class="form-horizontal" role="form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card padding-card product-card">
                    <div class="card-body">
                        <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Property Details</h5>
    
                        <div class="row section-groups">
                            <div class="form-group inputdetails col-sm-6">
                                <label>Property Name<span class="text-danger inputrequired">*</span></label>
                                <input type="text" class="form-control text-white bg-dark" required name="property_name" id="property_name" placeholder="Write The Property Name Here">
                            </div>
    
                            <div class="form-group inputdetails col-sm-6">
                                <label>Property Price<span class="text-danger inputrequired">*</span></label>
                                <input type="number" class="form-control text-white bg-dark" required name="property_price" id="proprty_price" placeholder="Write The Price Of the Property Here">
                            </div>
                        </div>

                        <div class="row section-groups">
                            <div class="form-group inputdetails col-sm-12">
                                <label>Property Name Slug<span class="text-danger inputrequired">*</span></label>
                                <input type="text" class="form-control text-white bg-dark" required name="property_slug" id="property_slug" placeholder="Write a slug for the Property Name">
                            </div>
                        </div>
    
                        <div class="form-group inputdetails">
                            <label>Property Description<span class="text-danger inputrequired">*</span></label>
                            <textarea class="form-control text-white bg-dark ckdescription" id="property-details" name="property_details" placeholder="Describe the Property details here.explain it with as more details as possible"></textarea>
                        </div>
    
                        <div class="row section-groups">
                            <div class="form-group inputdetails col-sm-6">
                                <label>Property Location<span class="text-danger inputrequired">*</span></label><br>
                                <select name="propertyhouselocation" class="rentaltagselect2 form-control text-white bg-dark" required style="width:100%;">
                                    <option disabled class="active">Choose the Location of the Property</option>
                                    @foreach($alllocations as $propertylocation)
                                        <option value="{{ $propertylocation->id }}">{{ $propertylocation->location_title }}</option>
                                    @endforeach
                                </select>
                            </div>
    
                            <div class="form-group inputdetails col-sm-6">
                                <label>Property Category<span class="text-danger inputrequired">*</span></label><br>
                                <select name="propertycategory" class="rentaltagselect2 form-control text-white bg-dark" required style="width:100%;">
                                    <option disabled class="active">Choose a Property Category</option>
                                    @foreach($allpropertycategories as $propertycat)
                                        <option value="{{ $propertycat->id }}">{{ $propertycat->propertycat_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="card padding-card product-card">
                    <div class="card-body">
                        <h5 class="card-title mb-4" style="color: black; font-size:18px;">2.Property Files</h5>
                        <div class="row section-groups">
                            <div class="col-md-6 inputdetails">
                                <h5 class="card-title mb-4">Property Profile Image</h5>
                                <input type="file" name="property_image" accept="image/*" required>
                                <span class="font-italic">Recommended size:width  1040px by height 1200px</span>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">ADD PROPERTY</button>
            </form>
        </div>
    </div>       
</div>
@endsection



