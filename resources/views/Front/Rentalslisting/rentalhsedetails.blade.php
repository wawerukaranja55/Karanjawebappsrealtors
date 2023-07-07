@extends('Front.frontmaster')
@section('title','Renatl House Description')
@section('content')
@section('listingpagestyles')
    <style>
        .rate {
            float:left;
            height: 46px;
            padding: 0 10px;
        }
        .rate:not(:checked) > input {
            position:absolute;
            top:0px;
            visibility: hidden;
        }
        .rate:not(:checked) > label {
            float:right;
            width:1em;
            overflow:hidden;
            white-space:nowrap;
            cursor:pointer;
            font-size:30px;
            color:#ccc;
        }
        .rate:not(:checked) > label:before {
            content: '★ ';
        }
        .rate > input:checked ~ label {
            color: #ffc700;    
        }
        .rate:not(:checked) > label:hover,
        .rate:not(:checked) > label:hover ~ label {
            color: #deb217;  
        }
        .rate > input:checked + label:hover,
        .rate > input:checked + label:hover ~ label,
        .rate > input:checked ~ label:hover,
        .rate > input:checked ~ label:hover ~ label,
        .rate > label:hover ~ input:checked ~ label {
            color: #c59b08;
        }
    </style>
@stop
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <h1>{{  $rentalhouse->rental_name }}</h1>
                <h6><i class="fa fa-map-marker"></i>{{ $rentalhouse->houselocation->location_title }}<br><br>
                    <i class="fa fa-map-pin"></i>{{ $rentalhouse->rental_address }}
                </h6>
            </div>
            <div class="col-lg-4 col-md-4 text-right">
                @if($rentalhouse->is_vacancy==1)
                    <h6 class="mt-2">{{ $availablerooms }} Vacants Available</h6>  
                @elseif($rentalhouse->is_vacancy==2)
                    <h6 class="mt-2">The House is Fully Booked</h6>
                @endif
                
                <input type="hidden" name="rntalhouse_id" value="{{ $rentalhouse->id }}">
                {{-- if the house tags have sizes --}}
                @if ($rentalhouse->is_addedtags==0)
                    <h2 class="text-success">Sh{{  $rentalhouse->monthly_rent }} <small>/month</small></h2>

                @elseif ($rentalhouse->is_addedtags==1)
                    <h2 class="text-success hsesizeprice"></h2>
                    <select class="custom-select hsesizes" hsesize-id="{{ $rentalhouse['id'] }}" id="gethsesize" name="housesize">
                        <option value=" " disabled selected>Select a Room Type To See The Price </option>
                        @foreach ($rentalhouse->hseroomsizes as $roomsize )
                            <option value="{{ $roomsize->id }}">{{ $roomsize->room_size }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-8 col-md-8">
                
                <!-- Go to www.addthis.com/dashboard to customize your tools -->
                <div class="addthis_inline_share_toolbox"></div>
            
                <div class="owl-carousel hsedetailscarousel owl-theme">
                    @foreach ( $rentalhouse->rentalalternateimages as $hseimgs )
                        <div class="item" style="border: 2px solid black; height:500px;">
                            <img src="{{ asset ('imagesforthewebsite/rentalhouses/alternateimages/large/'.$hseimgs->image) }}" style="height:inherit; width:100%; margin-bottom:10px; object-fit:cover;">
                        </div>
                    @endforeach
                </div>
                <div class="card padding-card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Description</h5>
                        <p>{!!$rentalhouse->rental_details!!}</p>
                    </div>
                </div>
                <div class="card padding-card">
                        
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Features</h5>
                                <ul class="sidebar-card-list">
                                    @if($rentalhouse->wifi == 'yes')
                                        <li><a href="#"><i class="fa fa-check-circle"></i>WIFI</a></li>
                                    @endif
                                    @if($rentalhouse->generator == 'yes')
                                        <li><a href="#"><i class="fa fa-check-circle"></i>BACK_UP GENERATOR</a></li>
                                    @endif
                                    @if($rentalhouse->balcony == 'yes')
                                        <li><a href="#"><i class="fa fa-check-circle"></i>BALCONY FOR EVERY ROOM</a></li>
                                    @endif
                                    @if($rentalhouse->cctv_cameras == 'yes')
                                        <li><a href="#"><i class="fa fa-check-circle"></i>SECURITY CCTV CAMERAS</a></li>
                                    @endif
                                    @if($rentalhouse->parking == 'yes')
                                        <li><a href="#"><i class="fa fa-check-circle"></i>AMPLE PARKING</a></li>
                                    @endif
                                    @if($rentalhouse->servant_quarters == 'yes')
                                        <li><a href="#" disabled="true"><i class="fa fa-check-circle"></i>SERVANT QUARTERS FOR WORKERS</a></li>
                                    @endif
                                </ul>
                            </div>    
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Types Of Rooms</h5>
                                <ul class="sidebar-card-list">
                                    @foreach ($rentalhouse->housetags as $roomtype )
                                        <li><p>{{ $roomtype->rentaltag_title }}</p></li>
                                    @endforeach
                                </ul>
                            </div>    
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="card-body">
                                <p><strong class="text-dark">Area Of Location :</strong>{{ $rentalhouse->houselocation->location_title }}</p>
                                <p><strong class="text-dark">Address :</strong>{{ $rentalhouse->rental_address }}</p>
                            </div>    
                        </div>
                    </div>  
                </div>
                {{-- <div class="card padding-card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Location</h5>
                        <div class="row mb-3">
                            <div class="col-lg-6 col-md-6">
                                <p><strong class="text-dark">Address :</strong>{{ $rentalhouse->houselocation->location_title }}</p>
                                <p><strong class="text-dark">State :</strong> Newcastle</p>
                            </div>
                            {{-- <div class="col-lg-6 col-md-6">
                                <p><strong class="text-dark">Address :</strong> 1200 Petersham Town</p>
                                <p><strong class="text-dark">State :</strong> Newcastle</p>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <p><strong class="text-dark">City :</strong> Sydney</p>
                                <p><strong class="text-dark">Zip/Postal Code :</strong> 54330</p>
                            </div> 
                        </div>
                        {{-- <div id="map"></div> 
                    </div>
                </div>--}}
                @if ($rentalhouse->rental_video !== NULL)
                    <div class="card padding-card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">House Details Video</h5>
                            <video id="my-video" class="video-js" controls preload="auto" width="100%" height="350" data-setup="{}">
                                <source src="/videos/rentalvideos/{{$rentalhouse->rental_video}}" type='video/mp4'>
                            </video>
                        </div>
                    </div>
                @endif
                {{-- shows all reviews for this house --}}
                        {{-- <div class="card padding-card reviews-card">
                            <div class="card-body">
                                @if (count($activereviews)>0)
                                    <h5 class="card-title mb-4">{{ count($activereviews) }} Reviews</h5>
                                    
                                    @foreach ($activereviews as $review)
                                        <div class="media mb-4">
                                            <img class="d-flex mr-3 rounded-circle" src="{{ asset ('imagesforthewebsite/usersimages/'.$review->userrating->avatar) }}">
                                            <div class="media-body">
                                                <h5 class="mt-0">{{ $review->userrating->name }} <small>{{ $review->created_at->timezone('EAT')->toDayDateTimeString() }}</small>
                                                    <div>
                                                        <?php
                                                            $count=1;
                                                            while($count<=$review->house_rating)
                                                            {?><span>&#9733;</span>
                                                                <?php 
                                                                $count++;
                                                            }?>
                                                    </div>
                                                </h5>
                                                <p>{{ $review->house_review }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                <h5 class="card-title mb-4">No Review Has Been Added For the House</h5>
                                @endif
                            </div>
                        </div>
                        {{-- if the user is a tenant and this room belongs to him show his div --}}
                        @if ($allowreview)
                    
                        <div class="card padding-card">
                            @auth
                                <div class="card-body" id="ratingdiv">
                                    <h3 class="card-title mb-4">Rate and Review The House</h3>
                                    <span class="font-weight-bold font-italic text-danger">Note:You Can Only Review and Rate Your The House Once</span>
                                    <form id="rateandreviewhseform" method="POST" class="form-horizontal" action="javascript:void(0);">
                                        @csrf
                                        <input type="hidden" name="houseid" value="{{ $rentalhouse->id }}">
                                        <input type="hidden" name="userid" value="{{ Auth::user()->id }}">

                                        <div class="form-group" style="margin-top: 5px;">
                                            
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8">
                                                    <label style="font-size: 15px;">Give a Star Rating for the House<span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8">
                                                    <div class="rate">
                                                        <input type="radio" id="star5" name="rate" value="5" />
                                                        <label for="star5" title="text">5 stars</label>
                                                        <input type="radio" id="star4" name="rate" value="4" />
                                                        <label for="star4" title="text">4 stars</label>
                                                        <input type="radio" id="star3" name="rate" value="3" />
                                                        <label for="star3" title="text">3 stars</label>
                                                        <input type="radio" id="star2" name="rate" value="2" />
                                                        <label for="star2" title="text">2 stars</label>
                                                        <input type="radio" id="star1" name="rate" value="1" />
                                                        <label for="star1" title="text">1 star</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p id="msg" style="font-size: 17px;"></p>
                                        <br>
                                        <div class="control-group form-group" style="margin-top: 2px;">
                                            <div class="controls">
                                                <label style="font-size: 15px;">Write A Review For The House <span class="text-danger">*</span></label>
                                                <textarea style="border:2px solid black;" name="textreview" rows="10" cols="100" class="form-control" required></textarea>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </form>
                                </div>
                            @else
                                <p>To Review and Rate the House Create or Log In to your Account...</p>
                                <span href="#" data-toggle="modal" data-target="#signupmodal" class="btn btn-success btn-block">Create/Login an Account<i class="fa fa-angle-right"></i></span>
                            @endauth
                        </div> --}}
            @endif
            </div>

            <div class="col-lg-4 col-md-4">
                <div class="card sidebar-card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Contact Admin To Request/Book a Showing</h5>

                        <ul class="alert alert-warning d-none" id="request_errorhselist"></ul>
                        <form action="javascript:void(0)" method="POST"  class="form-horizontal" role="form" id="sendhserequestform">
                            <div class="control-group form-group">
                                <div class="controls">
                                    <label>Your Name <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="Enter Your Name" name="name" class="form-control" required>
                                </div>
                            </div>

                            <input type="hidden" name="hse_id" class="houserqstid" value="{{ $rentalhouse->id }}">

                            <div class="control-group form-group">
                                <div class="controls">
                                    <label>Your Email <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="Enter Your Email" name="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="control-group form-group">
                                <div class="controls">
                                    <label>Phone <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="Enter Phone Number" name="phone" class="form-control" required>
                                </div>
                            </div>
                            <div class="control-group form-group">
                                <div class="controls">
                                    <label>Message <span class="text-danger">*</span></label>
                                    <textarea rows="5" cols="50" class="form-control" name="msg_request" required></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">SEND REQUEST</button>
                        </form>
                    </div>
                </div>
                <div class="card sidebar-card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Featured Properties</h5>
                        <div id="featured-properties" class="owl-carousel hsedetailscarousel owl-theme">
                            @foreach ($isfeaturedhouses as $featured )
                                <div class="item" style="height:350px;">
                                    <div class="card card-list">
                                        <a href="#">
                                            @if($featured->is_vacancy==0)
                                                <span class="badge badge-secondary">Vacants Available</span>
                                            @elseif($featured->is_vacancy==1)
                                                <span class="badge badge-secondary">Fully Booked</span>
                                            @endif
                                            <img style="height: 180px;" class="card-img-top" src="{{ asset ('imagesforthewebsite/rentalhouses/rentalimages/medium/'.$featured->rental_image) }}" alt="{{ $featured->rental_name }}">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $featured->rental_name }}</h5>
                                                <h6 class="card-subtitle mr-2"><i class="fa fa-map-marker"></i>{{ $featured->houselocation->location_title }}</h6>
                                                <h2 class="text-success">
                                                sh.{{ $featured->monthly_rent }} <small>/month</small></h2>
                                                <a class="btn btn-sm btn-warning" href="{{ url('rentalhse/'.$featured->rental_slug.'/'.$featured->id) }}" role="button" >
                                                    View Details
                                                </a>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    
    
    <section class="border-top">
        <div class="row">
            <div class="col-lg-12 col-md-12 section-title text-center">
                <h2>Related Rental Houses</h2>
            </div>
            @foreach ($relatedhouses as $relatedhse )
            <div class="col-lg-4 col-md-4">
                <div class="card card-list">
                    <a href="#">
                        @if($relatedhse->vacancy_status==1)
                            <span class="badge badge-success">Vacants Available</span>
                        @elseif($relatedhse->vacancy_status==2)
                            <span class="badge badge-success">Fully Booked</span>
                        @endif
                        <img class="card-img-top" style="height:180px;" src="{{ asset ('imagesforthewebsite/rentalhouses/rentalimages/medium/'.$relatedhse->rental_image) }}" alt="{{ $relatedhse->rental_name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $relatedhse->rental_name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted"><i class="mdi mdi-home-map-marker"></i>{{ $relatedhse->houselocation->location_title }}</h6>
                            <h2 class="text-success mb-0 mt-3">
                        sh.{{ $relatedhse->monthly_rent }} <small>/month</small></h2>
                        </div>
                        <div class="card-footer">
                            @if ($relatedhse->cctv_cameras == 'yes')
                                <span>CctvCameras : <strong><i class="fa fa-check-circle"></i></strong></span>
                            @endif
                            @if ($relatedhse->parking == 'yes')
                                <span>Parking : <strong><i class="fa fa-check-circle"></i></strong></span>
                            @endif
                            @if ($relatedhse->balcony == 'yes')
                                <span>Balcony : <strong><i class="fa fa-check-circle"></i></strong></span>
                            @endif
                            @if ($relatedhse->generator == 'yes')
                                <span>Back Up Generator : <strong><i class="fa fa-check-circle"></i></strong></span>
                            @endif
                            @if ($relatedhse->servant_quarters == 'yes')
                                <span>Servant Quarters : <strong><i class="fa fa-check-circle"></i></strong></span>
                            @endif
                            @if ($relatedhse->wifi == 'yes')
                                <span>Wifi : <strong><i class="fa fa-check-circle"></i></strong></span>
                            @endif

                            <a class="btn btn-sm btn-warning" style="float:right;" href="{{ url('rentalhse/'.$relatedhse->rental_slug.'/'.$relatedhse->id) }}" role="button" >
                                View Details
                            </a>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </section>
@endsection

@section('hsedetailspagescript')
    <script>

        // show house price on selecting a house size
        $('.hsesizes').select2();

        $('#gethsesize').change(function(){
            var rentalhousesize=$(this).val();

            var roomsizeid=$(this).attr("hsesize-id");
            $.ajax({
               type:'POST',
               url:'{{ route('getroom.prices') }}',
               data:{
                  housesize:rentalhousesize,
                  rntalhouse_id:roomsizeid
               },
               success:function(data){ 
                     console.log(data); 
                     $('.hsesizeprice').html('sh: ' + data.roomsize_price + '/Month');
                     
               },error:function(){
               }
            });
        });

        // submit request sent by user about a rental house
        $(document).ready(function(){
            var url = '{{ route("send.hserequest") }}';        
            $("#sendhserequestform").on("submit",function(e){
                e.preventDefault();
                $.ajax({
                    url:url,
                    type:"POST",
                    data:$("#sendhserequestform").serialize(),
                    success:function(response){

                        console.log(response);
                        if (response.status==400)
                        {
                            $('#request_errorhselist').html(" ");
                            $('#request_errorhselist').removeClass('d-none');
                            $.each(response.message,function(key,err_value)
                            {
                                $('#request_errorhselist').append('<li>' + err_value + '</li>');
                            })   

                        } else if (response.status==200)
                        {
                                alertify.set('notifier','position', 'top-right');
                                alertify.success(response.message);
                        }
                    },
                });
            })
        });

        // store a rating to the rating table
        $(document).ready(function(){
            var url = '{{ route("post.ratingreview") }}';        
            $("#rateandreviewhseform").on("submit",function(e){
                e.preventDefault();
                $.ajax({
                    url:url,
                    type:"POST",
                    data:$("#rateandreviewhseform").serialize(),
                    success:function(response){
                        console.log(response);
                        if (response.status==200)
                        {
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(response.message);
                            $("#ratingdiv").fadeOut(5000);

                        } else if (response.status==400)
                        {
                            $("#msg").show();
                            $("#msg").addClass("alert alert-warning font-weight-bold").html(response.message);
                            $("#msg").fadeOut(6000);
                        } else if (response.status==404)
                        {
                            $("#msg").show();
                            $("#msg").addClass("alert alert-warning font-weight-bold").html(response.message);
                            $("#msg").fadeOut(6000);
                        }
                    }   
                })
            });
        });

        // script for the carousel
        $('.hsedetailscarousel').owlCarousel({
            loop:true,
            autoplay:true,
            nav:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        })
    </script>
@stop






