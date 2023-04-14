
<div class="rentalhses">
    <div class="row">
        <div class="col-md-3">
            
        </div>
        <div class="col-md-9">
            <!-- form-group // -->
            <div class="float-right">
                {{ $housescategory->count() }} Houses Found
            </div>
        </div>
    </div>
    <!-- content left -->
    <div class="row">
        @if ($housescategory->isEmpty())
            <div class="col-lg-6">
                No houses Found At the Moment
            </div>
        @else 
    
            @foreach ($housescategory as $rentalhse)
            <div class="col-lg-6 col-md-6">
                <h5 class="card-title">{{ $rentalhse->id }}</h5>
                <div class="card card-list" style="box-shadow: 0px 0px 7px 3px #d3b8b8;">
                    @if($rentalhse->vacancy_status==1)
                       <span class="badge badge-primary badge-sm">Vacants Available</span> 
                    @elseif($rentalhse->vacancy_status==2)
                        <span class="badge badge-success badge-sm">Fully Booked</span>
                    @endif
                    <img class="card-img-top" src="{{ asset ('imagesforthewebsite/rentalhouses/rentalimages/medium/'.$rentalhse->rental_image) }}" alt="{{ $rentalhse->rental_name }}"
                     style="width:inherit; height: 230px; box-shadow: 0px 0px 7px 3px #b1adad; object-fit:contain;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $rentalhse->rental_name }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <i class="fa fa-map-marker" aria-hidden="true"></i> {{ $rentalhse->houselocation->location_title }}</h6>
                        <h2 class="text-dark mb-0 mt-3">sh.{{ $rentalhse->monthly_rent }} <small>/month</small></h2>
                        <h2 class="text-dark mb-0 mt-3">
                            @foreach ($rentalhse->housetags as $rmtype )
                                <p>{{ $rmtype->rentaltag_title }}</p>
                             @endforeach</h2>
                    </div>
                    <div class="card-footer">
                        <section style="display: flex;
                        justify-content: space-between; padding:2px; margin-bottom:2px;">
                            <div class="name-icon">
                                @if ($rentalhse->cctv_cameras == 'yes')
                                    <span>CCtv Security Cameras</span>
                                    <div class="icon">
                                        <i class="fa fa-camera-retro"></i>
                                        <span>Available</span>
                                    </div>
                                @endif
                            </div>
                            <div class="name-icon">
                                @if ($rentalhse->parking == 'yes')
                                    <span>Parking</span>
                                    <div class="icon">
                                        <i class='fas fa-parking'></i>
                                        <span>Available</span>
                                    </div>
                                @endif
                            </div>
                            <div class="name-icon">
                                @if ($rentalhse->generator == 'yes')
                                    <span>Backup Generator</span>
                                    <div class="icon">
                                        <i class="fa fa-bolt"></i>
                                        <span>Available</span>
                                    </div>
                                @endif
                            </div>
                        </section>
                        <div style="display: flex;
                        justify-content: space-between; margin:0px !important;">
                            <section class="viewlink">
                                <a href="#" id="requesthouse" class="btn btn-sm btn-danger" data-id="{{ $rentalhse->id }}">Contact Admin</a>
                            </section>
                            <section class="viewlink">
                                
                                <a class="btn btn-sm btn-warning" href="{{ url('rentalhse/'.$rentalhse->rental_slug.'/'.$rentalhse->id) }}" role="button" >
                                    View Details
                                </a>
                            </section>
                        </div>
                    </div>
                </div>
                </div>
    
            {{-- <div class="col-lg-4">
                <section class="card hsecard">
                    <figure>
                        <div class="img-overlay hot-home">
                            @if($rentalhse->vacancy_status==1)
                                <span class="badge badge-info p-2 rounded-0 statusbadge">Vacants Available</span>   
                            @elseif($rentalhse->vacancy_status==2)
                                <span class="badge badge-success p-2 rounded-0 statusbadge">Fully Booked</span>
                            @endif
                            
                            <img src="{{ asset ('imagesforthewebsite/rentalhouses/rentalimages/medium/'.$rentalhse->rental_image) }}" alt="{{ $rentalhse->rental_name }}">
                        </div>
                        {{ $rentalhse->id }}<figcaption>{{ $rentalhse->rental_name }}
                        </figcaption>
                        <div class="pricelocation" style="display: flex;
                        justify-content: space-between;">
    
                            <section class="location">
                                <a class="disabled font-italic h6"><i class="fa fa-map-marker" aria-hidden="true"></i>{{ $rentalhse->houselocation->location_title }}</a>
                            </section>
                            <section class="pricelink">
                                <span class="btn btn-dark">sh.{{ $rentalhse->monthly_rent }}</span>
                            </section>
                        </div>
                    </figure>
                    <div class="card-content">
                        <p>{!! Str::limit($rentalhse->rental_details, 80)!!}</p>
    
                        <section class="icons-home">
                            <div class="name-icon">
                                @if ($rentalhse->cctv_cameras == 'yes')
                                    <span>CCtv Security Cameras</span>
                                    <div class="icon">
                                        <i class="fa fa-camera-retro"></i>
                                        <span>Available</span>
                                    </div>
                                @endif
                            </div>
                            <div class="name-icon">
                                @if ($rentalhse->parking == 'yes')
                                    <span>Parking</span>
                                    <div class="icon">
                                        <i class='fas fa-parking'></i>
                                        <span>Available</span>
                                    </div>
                                @endif
                            </div>
                            <div class="name-icon">
                                @if ($rentalhse->generator == 'yes')
                                    <span>Backup Generator</span>
                                    <div class="icon">
                                        <i class="fa fa-bolt"></i>
                                        <span>Available</span>
                                    </div>
                                @endif
                            </div>
                        </section>
                    </div>
                    <div class="viewprice" style="display: flex;
                        justify-content: space-between; margin:0px !important;">
                            <section class="viewlink">
                                <a href="#" id="requesthouse" class="btn-sm btn-danger" data-id="{{ $rentalhse->id }}">Contact Admin</a>
                            </section>
                            <section class="viewlink">
                                
                                <a class="btn-sm btn-warning" href="{{ url('rentalhse/'.$rentalhse->rental_slug.'/'.$rentalhse->id) }}" role="button" >
                                    View Details
                                </a>
                            </section>
                        </div>
                </section>
            </div> --}}
            @endforeach
        @endif
    </div>
    <div class="d-flex justify-content-center pagination" style="margin-top: 200px;">
        {{ $housescategory->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>

