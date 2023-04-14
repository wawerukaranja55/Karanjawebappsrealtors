
<!-- content left -->
<div class="row">
    <div class="col-md-10"></div>
    <div class="col-md-2" style="margin-top:25px">
        {{ $propertycategory->count() }} Properties Found
    </div>
</div>
<div class="row">
    @if ($propertycategory->isEmpty())
    <div style="text-align: center; padding:50px 0px; width:100%;">
        <h5>Property Unvailable but coming soon</h5>
     </div>
    @else 

        @foreach ($propertycategory as $property)
        <div class="col-lg-10 col-md-10 mx-auto" style="margin:10px; box-shadow: 0px 0px 7px 3px #46e961;">
            <div class="card card-list card-list-view">
                <div class="row no-gutters">
                    <div class="col-lg-5 col-md-5">
                        <span class="badge badge-danger">For Sale</span>
                        <img class="card-img-top"  style="object-fit:cover; height: 200px;" src="{{ asset ('imagesforthewebsite/properties/propertyimages/medium/'.$property->property_image) }}" alt="{{ $property->property_name }}">
                    </div>
                    <div class="col-lg-5 col-md-5">
                        <div class="card-body">
                            <h5 class="card-title">{{ $property->property_name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted"><i class="fa fa-map-marker"></i>{{ $property->propertylocation->location_title }}</h6>
                            <h2 class="text-success mb-0 mt-3">sh.{{ $property->property_price }}</h2>
                        </div>
                        <div class="card-footer">
                            <div class="viewprice" style="display: flex;
                                justify-content: space-between; margin:0px !important;">
                                <section class="viewlink">
                                    <a href="#" id="requestproperty" class="btn btn-sm btn-danger" data-id="{{ $property->id }}">Contact Admin</a>
                                </section>
                                <section class="viewlink">
                                    <a class="btn btn-sm btn-warning" href="{{ url('property/'.$property->property_slug.'/'.$property->id) }}" role="button" >
                                        View Details
                                    </a>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>
<div class="d-flex justify-content-center">
    {{  $propertycategory->links('vendor.pagination.bootstrap-4')  }}
</div>
