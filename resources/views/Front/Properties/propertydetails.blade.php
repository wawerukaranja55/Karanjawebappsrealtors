@extends('Front.frontmaster')
@section('title','On Sale Property Description')
@section('content')
@section('propertylistingpagestyles')
    
@stop
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <h1>{{  $property->property_name }}</h1>
                <h6><i class="fa fa-map-marker"></i>{{ $property->propertylocation->location_title }}
                    {{-- 250-260 3rd St, Hoboken, NJ 07030, USA --}}
                </h6>
            </div>
            <div class="col-lg-4 col-md-4 text-right">
                
                <h2 class="text-success" style="margin: 20px;">Sh.{{  $property->property_price }}</h2>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                
                <!-- Go to www.addthis.com/dashboard to customize your tools -->
                <div class="addthis_inline_share_toolbox"></div>
            
                <div class="owl-carousel propertydetailscarousel owl-theme">
                    @foreach ( $property->propertyimages as $propertyimgs )
                        <div class="item" style="border: 2px solid black; height:310px;">
                            <img src="{{ asset ('imagesforthewebsite/properties/propertyxtraimages/large/'.$propertyimgs->image) }}" style="height:300px; margin-bottom:10px;">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="card padding-card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Description</h5>
                        <p>{!!$property->property_details!!}</p>
                    </div>
                </div>
                @if ($property->rental_video="")
                <div class="card padding-card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Video</h5>
                        <video id="my-video" class="video-js" controls preload="auto" width="200" height="100" data-setup="{}">
                            <source src="/videos/propertyvideos/{{$property->property_video}}" type='video/mp4'>
                        </video>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="card sidebar-card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Contact Admin For More Details on the Property</h5>
                        <ul class="alert alert-warning d-none" id="request_errorlist"></ul>
                        <form action="javascript:void(0)" method="POST"  class="form-horizontal" role="form" id="sendpropertyrequestform">
                            <div class="control-group form-group">
                                <div class="controls">
                                    <label>Your Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" placeholder="Enter Your Name" class="form-control">
                                </div>
                            </div>

                            <input type="hidden" name="hse_id" class="houseuserid" value="{{ $property->id }}">

                            <div class="control-group form-group">
                                <div class="controls">
                                    <label>Your Email <span class="text-danger">*</span></label>
                                    <input type="text" name="email" placeholder="Enter Your Email" class="form-control">
                                </div>
                            </div>
                            <div class="control-group form-group">
                                <div class="controls">
                                    <label>Phone <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" placeholder="Enter Phone Number" class="form-control">
                                </div>
                            </div>
                            <div class="control-group form-group">
                                <div class="controls">
                                    <label>Message <span class="text-danger">*</span></label>
                                    <textarea rows="5" name="msg_request" cols="50" class="form-control"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">SEND REQUEST</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    
    
    <section class="border-top">
        <div class="row">
            <div class="col-lg-12 col-md-12 section-title text-center">
                <h2>Related Properties</h2>
            </div>
            @foreach ($relatedproperties as $relatedproperty )
            <div class="col-lg-4 col-md-4">
                <div class="card card-list">
                    <img class="card-img-top" style="height:180px;" src="{{ asset ('imagesforthewebsite/properties/propertyimages/medium/'.$relatedproperty->property_image) }}" alt="{{ $relatedproperty->property_name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $relatedproperty->property_name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted"><i class="fa fa-map-marker"></i>{{ $relatedproperty->propertylocation->location_title }}</h6>
                            <h2 class="text-success mb-0 mt-3">
                        sh.{{ $relatedproperty->property_price }}</h2>
                        </div>
                        <div class="card-footer">

                            <a class="btn btn-sm btn-warning" style="float:right;" href="{{ url('property/'.$relatedproperty->property_slug.'/'.$relatedproperty->id) }}" role="button" >
                                View Details
                            </a>
                        </div>
                    {{-- <a href="#"> 
                        {{-- @if($relatedproperty->vacancy_status==1)
                            <span class="badge badge-success">Vacants Available</span>
                        @elseif($relatedproperty->vacancy_status==2)
                            <span class="badge badge-success">Fully Booked</span>
                        @endif 
                        
                     </a> --}}
                </div>
            </div>
            @endforeach
        </div>
    </section>
@endsection

@section('propertydetailsscript')
    <script>
        // script for the carousel
        $('.propertydetailscarousel').owlCarousel({
            loop:true,
            margin:10,
            nav: true,
            navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplaySpeed: 4000,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:4
                }
            }
        })


        // submit request sent by user about a property
        $(document).ready(function(){
            var url = '{{ route("send.propertyrequest") }}';        
            $("#sendpropertyrequestform").on("submit",function(e){
                e.preventDefault();
                $.ajax({
                    url:url,
                    type:"POST",
                    data:$("#sendpropertyrequestform").serialize(),
                    success:function(response){

                        console.log(response);
                        if (response.status==400)
                        {
                            $('#request_errorlist').html(" ");
                            $('#request_errorlist').removeClass('d-none');
                            $.each(response.message,function(key,err_value)
                            {
                                $('#request_errorlist').append('<li>' + err_value + '</li>');
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
    </script>
@stop






