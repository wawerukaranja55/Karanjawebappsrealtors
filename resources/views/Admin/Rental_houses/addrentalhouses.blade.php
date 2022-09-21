@extends('Admin.adminmaster')
@section('title','Add a Rental House')
@section('content')
{{-- Add A Rental House --}}
<div class="content-wrapper">
    <div class="row" style="
    display: flex;
    justify-content: center;">
        <div class="col-md-4">
            <a class="btn btn-dark" href="{{ url('admin/inactiverentals') }}">Inactive Rental Houses</a>
        </div>
        <div class="col-md-4">
            <a class="btn btn-dark" href="{{ url('admin/activerentals') }}">Activated Rental Houses</a>
        </div>
        {{-- <div class="col-md-4">
            <a class="btn btn-dark" href="{{ route('addrentalhse') }}">Add a New Rental House</a>
        </div> --}}
        <div class="col-md-4">
            <a class="btn btn-dark" href="{{ route('alllocations.index') }}">Add a New Location</a>
        </div>
    </div
    <div class="row" style="margin-bottom: 100px;">    
        <div class="col-lg-8 col-md-8 mx-auto">
            <div class="panel-heading mt-5" style="text-align: center; font-size:18px; background-color:black;"> 
                <h3 class="mb-2 panel-title">Add a New Rental House</h3> 
            </div>
            <form action="{{ route('rental_houses.store') }}" class="form-horizontal" role="form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card padding-card product-card">
                    <div class="card-body">
                        <h5 class="card-title mb-4" style="color: black; font-size:18px;">1.Rental Description</h5>
    
                        <div class="row section-groups">
                            <div class="form-group inputdetails col-sm-6">
                                <label>Rental Name<span class="text-danger inputrequired">*</span></label>
                                <input type="text" class="form-control text-white bg-dark" required name="rental_name" id="rental_name" placeholder="Write The Rental House Name">
                            </div>
    
                            <div class="form-group inputdetails col-sm-6">
                                <label>Rental Monthly Price<span class="text-danger inputrequired">*</span></label>
                                <input type="number" class="form-control text-white bg-dark" required name="monthly_rent" id="monthly_rent" placeholder="Write The Monthly Rent Price">
                            </div>
                        </div>

                        <div class="row section-groups">
                            <div class="form-group inputdetails col-sm-12">
                                <label>RentalName Slug<span class="text-danger inputrequired">*</span></label>
                                <input type="text" class="form-control text-white bg-dark" required name="rental_slug" id="rental_slug" placeholder="Write a slug for the Rental House Name">
                            </div>
                        </div>
    
                        <div class="form-group inputdetails">
                            <label>Rental Details<span class="text-danger inputrequired">*</span></label>
                            <textarea class="form-control text-white bg-dark ckdescription" id="rental_details" name="rental_details" placeholder="Describe the Rental property here.explain it with as more details as possible" rows="4"></textarea>
                        </div>
    
                        <div class="row section-groups">
                            <div class="form-group inputdetails col-sm-6">
                                <label>Rental Location<span class="text-danger inputrequired">*</span></label><br>
                                <select name="location_id" class="adminselect2 form-control text-white bg-dark" required style="width: 100%;">
                                    <option value=" ">Choose a Rental Location</option>
                                    @foreach($allrentallocations as $location)
                                        <option value="{{ $location['id'] }}"
                                            @if (!empty (@old('location_id')) && $location->id==@old('location_id'))
                                                selected=""    
                                            @endif>{{ $location->location_title }}</option>
                                    @endforeach
                                </select>
                            </div>
    
                            <div class="form-group inputdetails col-sm-6">
                                <label>Rental category<span class="text-danger inputrequired">*</span></label><br>
                                <select name="rentalcat_id" class="adminselect2 form-control text-white bg-dark" style="width: 100%;" required>
                                    <option value=" ">Choose a Rental Category</option>
                                    @foreach($allrentalcategories as $category)
                                        <option value="{{ $category['id'] }}"
                                            @if (!empty (@old('category_id')) && $category->id==@old('category_id'))
                                                selected=""    
                                            @endif>{{ $category->rentalcat_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row section-groups">
                            <div class="form-group inputdetails col-sm-12">
                                <label for="rental_tags" class="control-label">Add tags for the rental house</label><br>
                                <select name="rentaltags[]" class="form-control text-white bg-dark rentaltagselect2" multiple="multiple" style="width:100%;" required>
                                    {{-- <option value="">Select Tags for your Rental House</option> --}}
                                    @foreach($allrentaltags as $rentaltag)
                                        <option value="{{ $rentaltag->id }}">{{ $rentaltag->rentaltag_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
    
                        <div class="row section-groups">
                            <div class="form-group inputdetails col-sm-6">
                                <label>Total No. of houses/rooms<span class="text-danger inputrequired">*</span></label>
                                <input type="number" class="form-control text-white bg-dark" required name="total_rooms" placeholder="Write The total number of houses in that rental house">
                            </div>
                            <div class="form-group inputdetails col-sm-6">
                                <div class="custom-control custom-checkbox" style="margin-top: 10px;">
                                    <input type="checkbox" class="custom-control-input" name="is_featured" value="yes" id="osahan-checkbox6">
                                    <label class="custom-control-label" for="osahan-checkbox6">Featured</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="card padding-card product-card">
                    <div class="card-body">
                        <h5 class="card-title mb-4" style="color: black; font-size:18px;">2.Rental Files</h5>
                        <div class="row section-groups">
                            <div class="col-md-6 inputdetails">
                                <h5 class="card-title mb-4">Rental House Profile Image</h5>
                                <input type="file" name="rental_image" accept="image/*" required>
                                <span class="font-italic">Recommended size:width  1040px by height 1200px</span>
                            </div>
                            <div class="form-group inputdetails col-sm-6">
                                <label>House Owner(Landlord)<span class="text-danger inputrequired">*</span></label><br>
                                <select name="landlord_id" class="adminselect2 form-control text-white bg-dark" style="width: 100%;" required>
                                    <option value=" "disabled selected>Choose The House Owner(Landlord)</option>
                                    @foreach($alllandlords as $landlord)
                                        <option value="{{ $landlord['id'] }}">{{ $landlord->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="col-md-6 inputdetails">
                                <h5 class="card-title mb-4">Rental House Profile Video</h5>
                                <input type="file" name="rental_video" accept="video/*">
                            </div> --}}
                        </div>
                    </div>
                </div>
    
                <div class="card padding-card product-card">
                    <div class="card-body">
                        <h5 class="card-title mb-4" style="color: black; font-size:18px;">3.Rental House Amenities</h5>
                        <div class="row section-groups">
                            <div class="col-md-4 inputdetails" style="text-align: left; color:black;">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="wifi" value="yes" id="osahan-checkbox">
                                    <label class="custom-control-label" for="osahan-checkbox">WIFI</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="generator" value="yes" id="osahan-checkbox1">
                                    <label class="custom-control-label" for="osahan-checkbox1">BACKUP GENERATOR</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="balcony" value="yes" id="osahan-checkbox2">
                                    <label class="custom-control-label" for="osahan-checkbox2">BALCONY</label>
                                </div>
    
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="parking" value="yes" id="osahan-checkbox3">
                                    <label class="custom-control-label" for="osahan-checkbox3">PARKING</label>
                                </div>
                            </div>
                            <div class="col-md-4 inputdetails" style="text-align: left">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="cctv_cameras" value="yes" id="osahan-checkbox4">
                                    <label class="custom-control-label" for="osahan-checkbox4">CCTV SECURITY CAMERAS</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="servant_quarters" value="yes" id="osahan-checkbox5">
                                    <label class="custom-control-label" for="osahan-checkbox5">SERVANT QUARTERS</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-success">ADD RENTAL HOUSE</button>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>
        </div>
    </div>       
</div>
@endsection


