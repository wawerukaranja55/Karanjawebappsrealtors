<?php use App\Models\Rental_category; ?>
@extends('Front.frontmaster')
@section('title','Homepage')
@section('content')
@section('homepagepagestyles')
    <style>
        .ms_genres_wrapper {
            margin: 10px 0px 20px 0px;
            background: #EEEDE7;
            border: 2px solid rgb(184, 194, 184);
         }
         .ms_heading {
            width: 100%;
            display: inline-block;
            text-align: center;
            background-color: #ac63b6;
         }
         .ms_heading h2 {
            font-size: 25px;
            position: relative;
            display: inline-block;
            padding-bottom: 10px;
            text-transform: capitalize;
            margin-top:  20px;
            color: whitesmoke;
            
         }
         .veiw_all {
            float: right;
            position: relative;
            top: 20px;
            right: 10px;
         }
         .veiw_all a {
            color: whitesmoke;
            text-transform: capitalize;
         }
         .veiw_all a:hover {
            color: #020202;
         }
         .ms_heading h1:after {
            width: 100px;
            height: 5px;
            content: "";
            position: absolute !important;
            bottom: 0;
            left: -15px;
            z-index: 0;
            background: -webkit-radial-gradient(50% 50%, ellipse closest-side, #ff4865, rgba(255, 42, 112, 0) 60%);
            background: -moz-radial-gradient(50% 50%, ellipse closest-side, #ff4865, rgba(255, 42, 112, 0) 60%);
            background: -ms-radial-gradient(50% 50%, ellipse closest-side, #ff4865, rgba(255, 42, 112, 0) 60%);
            background: -o-radial-gradient(50% 50%, ellipse closest-side, #ff4865, rgba(255, 42, 112, 0) 60%);
         }

    </style>
@stop
<div class="ms_genres_wrapper">
   <div class="row">
       <div class="col-lg-12">
           <div class="ms_heading">
               <h2>Commercial Houses</h2>
               <?php 
                  $commercialcaturl=Rental_category::select('rentalcat_url')->where(['id'=>2,'status'=>1])->pluck('rentalcat_url')->first();
                  // dd($commercialcaturl);die();
               ?>
               <span class="veiw_all"><a href="{{ url ('/'.$commercialcaturl) }}">View All</a></span>
           </div>
       </div>
   </div>
   <div class="row">
      @if ($showcommercialhses->isEmpty())
         <div style="text-align: center; padding:50px 0px; width:100%;">
            <h5>Commercial Houses Coming Soon</h5>
         </div> 
      @else
         @foreach($showcommercialhses as $house)
            <div class="col-lg-3 col-md-6">
               <div class="swiper-slide" style="padding: 5px;">
                  <div class="event-feed latest" style="border: 1px solid;
                  padding: 5px;
                  box-shadow: 5px 5px 5px 5px #888888;">
                        <img src="{{asset('imagesforthewebsite/rentalhouses/rentalimages/medium/'.$house->rental_image) }}"  alt="{{ $house->rental_name }}" style="width:100%; height:200px;">
                        <div style="height: 140px;">
                           <h4>{{ $house->rental_name }}</h4>
                        <ul style="list-style-type: none;">
                           <li><i class=" fa fa-location-arrow"></i>{{ $house->houselocation->location_title }}</li>
                        </ul>
                        <a class="btn btn-primary btn-sm" href="{{ url('rentalhse/'.$house->rental_slug.'/'.$house->id) }}">View</a>
                        </div>
                  </div><!--\\event-feed latest-->
               </div>
            </div>
         @endforeach
      @endif
   </div>
</div>

<div class="ms_genres_wrapper">
   <div class="row">
       <div class="col-lg-12">
           <div class="ms_heading">
               <h2>Latest Bed Sitters</h2>
           </div>
       </div>
   </div>
   <div class="row">
      @if ($showlatestbedsitters->isEmpty())
         <div style="text-align: center; padding:50px 0px; width:100%;">
            <h5>Bedsitters Coming Soon</h5>
         </div>  
      @else
         @foreach($showlatestbedsitters as $bedsitter)
            @foreach($bedsitter->tagshouse as $hse)
               <div class="col-lg-3 col-md-6">
                  <div class="swiper-slide" style="padding: 5px;">
                     <div class="event-feed latest" style="border: 1px solid;
                     padding: 5px;
                     box-shadow: 5px 5px 5px 5px #888888;">
                           <img src="{{asset('imagesforthewebsite/rentalhouses/rentalimages/medium/'.$hse->rental_image) }}"  alt="{{ $hse->rental_name }}" style="width:100%; height:200px;">
                           <div style="height: 140px;">
                              <h4>{{ $hse->rental_name }}</h4>
                           <ul style="list-style-type: none;">
                              <li><i class=" fa fa-location-arrow"></i>{{ $hse->houselocation->location_title }}</li>
                           </ul>
                           <a class="btn btn-primary btn-sm" href="{{ url('rentalhse/'.$hse->rental_slug.'/'.$hse->id) }}">View</a>
                           </div>
                     </div><!--\\event-feed latest-->
                  </div>
               </div>
            @endforeach
         @endforeach
      @endif
   </div>
</div>

<div class="ms_genres_wrapper">
   <div class="row">
       <div class="col-lg-12">
           <div class="ms_heading">
               <h2>On Sale Properties</h2>
           </div>
       </div>
   </div>
   <div class="row">
      @if ($showlatestproperties->isEmpty())
         <div style="text-align: center; padding:50px 0px; width:100%;">
            <h5>On Sale Properties Coming Soon</h5>
         </div> 
      @else
         @foreach($showlatestproperties as $property)
            <div class="col-lg-3 col-md-6">
               <div class="swiper-slide" style="padding: 5px;">
                  <div class="event-feed latest" style="border: 1px solid;
                  padding: 5px;
                  box-shadow: 5px 5px 5px 5px #888888;">
                        <img src="{{asset('imagesforthewebsite/properties/propertyimages/medium/'.$property->property_image) }}"  alt="{{ $property->property_name }}" style="width:100%; height:200px;">
                        <div style="height: 140px;">
                           <h4>{{ $property->property_name }}</h4>
                        <ul style="list-style-type: none;">
                           <li><i class=" fa fa-location-arrow"></i>{{ $property->propertylocation->location_title }}</li>
                        </ul>
                        <a class="btn btn-primary btn-sm" href="{{ url('property/'.$property->property_slug.'/'.$property->id) }}">View</a>
                        </div>
                  </div><!--\\event-feed latest-->
               </div>
            </div>
         @endforeach
      @endif
   </div>
</div>

@endsection




