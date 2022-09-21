@extends('Admin.adminmaster')
@section('title','Admin Dashboard')
@section('admindashboardstyles')
    <style>
       .allhouses{
         color:black;
         font-size: 15px;
       }

       .detailsnumber{
         border-radius: 50%;
         width: 40px;
         height: 40px;
         padding: 5px;

         background: rgb(222, 226, 15);
         border: 2px solid #666;
         color: rgb(1, 7, 7);
         text-align: center;

         font: 20px Arial, sans-serif;
       }

       .tenanticon{
         height: 20px;
         width: 20px;
         display: block;
       }
    </style>
@stop
@section('content')
<div class="wrapper wrapper-content">
   {{-- show analytics --}}
   <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
              <div class="card-body dashboard-tabs p-0">
                  <ul class="nav nav-tabs px-4" role="tablist">
                      <li class="nav-item">
                          <h3 class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Website Analytics</h3>
                      </li>
                  </ul>
                  <div class="tab-content py-0 px-0">
                      <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                          <div class="d-flex flex-wrap justify-content-xl-between">
                              <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                 <i class="fa fa-home mr-3 icon-lg text-danger" aria-hidden="true"></i>
                                  <div class="d-flex flex-column justify-content-around">
                                  <small class="mb-1 font-weight-bold" style="color:rgb(8, 2, 2); font-size: 14px;">All Rental Houses</small>
                                  <h5 class="mr-2 mb-0 detailsnumber">{{ $rentalhouses }}</h5>
                                  </div>
                              </div>
                              <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                 <i class="fa fa-building mr-3 icon-lg text-danger" aria-hidden="true"></i>
                                 <div class="d-flex flex-column justify-content-around">
                                    <small class="mb-1 font-weight-bold" style="color:rgb(8, 2, 2); font-size: 14px;">Properties to sell</small>
                                    <h5 class="mr-2 mb-0 detailsnumber">{{ $rentalproperties }}</h5>
                                 </div>
                             </div>
                              <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                 {{-- <span class='tenanticon mr-3 text-danger'></span> --}}
                                 <img class="tenanticon" src="{{ asset ('imagesforthewebsite/icons/tenant.png') }}">
                                 <div class="d-flex flex-column justify-content-around">
                                    <small class="mb-1 font-weight-bold" style="color:rgb(8, 2, 2); font-size: 14px;">All Registered Users</small>
                                    <h5 class="mr-2 mb-0 detailsnumber">{{ $tenants }}</h5>
                                 </div>
                              </div>
                              
                              @can('adminsnotallowed')
                                 <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                    <i class="fas fa-comments mr-3 icon-lg text-danger"></i>
                                    <div class="d-flex flex-column justify-content-around">
                                       <small class="mb-1 font-weight-bold" style="color:rgb(8, 2, 2); font-size: 14px;">Reviews and Ratings</small>
                                       <h5 class="mr-2 mb-0 detailsnumber">{{ $reviews }}</h5>
                                    </div>
                                 </div>
                                 <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                    <img class="tenanticon" src="{{ asset ('imagesforthewebsite/icons/mpesa.png') }}">
                                    <div class="d-flex flex-column justify-content-around">
                                       <small class="mb-1 font-weight-bold" style="color:rgb(8, 2, 2); font-size: 14px;">Mpesa Payments By Tenants</small>
                                       <h5 class="mr-2 mb-0 detailsnumber">{{ $mpesapayments }}</h5>
                                    </div>
                                 </div>
                              @endcan
                           </div>
                        </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

   {{-- show rental houses --}}
   <div class="ms_genres_wrapper" style=" margin-bottom:50px;">
      <div class="row">
         <div class="col-lg-12">
            <div class="ms_heading">
               <h3>Rental Houses</h3>
               <span class="veiw_all"><a href="{{ route('activerentalhses') }}">View All</a></span>
            </div>
         </div>
         @if ($showrentlhses->isEmpty())
            <p style="
            font-size: 25px;
            padding: 10%;
            text-transform: capitalize;
            color: rgb(7, 5, 5);">No House have been Added</p>
         @else
            @foreach ($showrentlhses as $hse )
               <div class="col-lg-3 col-md-6">
                  <div class="swiper-slide">
                     <div class="event-feed latest" style="border: 1px solid;
                     padding: 5px;
                     box-shadow: 5px 5px 5px 5px #888888;">
                           <img src="{{ asset('imagesforthewebsite/rentalhouses/rentalimages/medium/'.$hse->rental_image) }}"  alt="{{ $hse->rental_name }}" style="width:100%; height:200px;">
                           
                           <h4>{{ $hse->rental_name }}</h4>
                           <ul style="list-style-type: none;">
                              <li><i class=" fa fa-location-arrow"></i>{{ $hse->houselocation->location_title }}</li>
                              <li><i class="fas fa-clock"></i></b>{{ $hse->housecategory->rentalcat_title }}</li>
                           </ul>
                           <a class="btn btn-primary btn-sm" href="{{ url('rentalhse/'.$hse->rental_slug.'/'.$hse->id) }}">View</a>
                     </div><!--\\event-feed latest-->
                  </div>
               </div>
            @endforeach
         @endif
         
      </div>
   </div>

  {{-- show properties to sell --}}
   <div class="ms_genres_wrapper" style=" margin-bottom:50px;">
      <div class="row">
         <div class="col-lg-12">
            <div class="ms_heading">
               <h3>Properties to sell</h3>
               <span class="veiw_all"><a href="{{ route('active.properties') }}">View All</a></span>
            </div>
         </div>
         @if ($showproperties->isEmpty())
            <p style="
            font-size: 25px;
            padding: 10%;
            text-transform: capitalize;
            color: rgb(7, 5, 5);">No property have been Added</p>
         @else
            @foreach ($showproperties as $property )
            <div class="col-lg-3 col-md-6">
               <div class="swiper-slide">
                  <div class="event-feed latest" style="border: 1px solid;
                  padding: 5px;
                  box-shadow: 5px 5px 5px 5px #888888;">
                        <img src="{{asset('imagesforthewebsite/properties/propertyimages/medium/'.$property->property_image) }}"  alt="{{ $property->property_name }}" style="width:100%; height:200px;">
                        
                        <h4>{{ $property->property_name }}</h4>
                        <ul style="list-style-type: none;">
                           <li><i class=" fa fa-location-arrow"></i>{{ $property->propertylocation->location_title }}</li>
                           <li><i class="fas fa-clock"></i></b>{{ $property->propertycategory->propertycat_title }}</li>
                        </ul>
                        <a class="btn btn-primary btn-sm" href="{{ url('property/'.$property->property_slug.'/'.$property->id) }}">View</a>
                  </div><!--\\event-feed latest-->
               </div>
            </div>
            @endforeach
         @endif
         
      </div>
   </div>
</div>
@endsection



