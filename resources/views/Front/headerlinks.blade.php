<meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>@if (!empty($meta_title)){{ $meta_title }}@else Wkaranja Realtor and Property Management Web App @endif</title>

      @if (!empty($meta_description))
        <meta name="description" content="{{ $meta_description }}">
      @else
        <meta name="description" content="Rental Houses And Property Management System for Realtors and Tenants">
      @endif

      {{-- <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/css/bootstrap.min.css') }}"/> --}}
      
      {{-- css style for the admin panel --}} 
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/userpanel/bootstrap/bootstrap.min.css') }}"/>
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/userpanel/custom/usercss.css') }}"/>
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/userpanel/custom/responsiveusercss.css') }}"/>
      {{-- <link rel="stylesheet" href="{{ asset('cssjqueryfiles/userpanel/icons/materialdesignicons.min.css') }}"/> --}}
      
      {{-- fontawesome cdn --}} 
      {{-- <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/font-awesome/font-awesome.min.css') }}"/> --}}
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" rel="stylesheet">
      {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"> --}}
      {{-- <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/css/all.min.css') }}"/> --}}

      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/bootstrap-togglemin/bootstrap-toggle.css') }}"/>
      {{-- icon for our website --}}
      <link rel="icon" type="image/png" href="{{ asset('imagesforthewebsite/webicon.png') }}">

      {{-- css for datatables --}}
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/datatables/DataTables-1.10.25/css/jquery.dataTables.min.css') }}"/>
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/datatables/DataTables-1.10.25/css/dataTables.bootstrap.min.css') }}"/>
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/datatables/FixedHeader-3.1.9/css/fixedHeader.bootstrap.min.css') }}"/>
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/datatables/Responsive-2.2.9/css/responsive.bootstrap.min.css') }}"/>

      {{-- select2 --}}
      {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/> --}}
      
      {{-- select2 --}}
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/select2/select2.min.css') }}"/>
      
      {{-- alertify --}}
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/alertifyjs/css/alertify.min.css') }}"/>
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/alertifyjs/css/themes/default.min.css') }}"/>

      {{-- jquery_slider --}}
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/plugins/jquery_slider/jquery-ui.css') }}"/>

      {{-- Owl Carousel --}}
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/plugins/OwlCarousel2-2.3.4/owl.carousel.min.css') }}"/>
      <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/plugins/OwlCarousel2-2.3.4/owl.theme.default.min.css') }}"/>

      {{-- sweet-alert --}}
      {{-- <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/plugins/sweet_alert/sweetalert2.min.css') }}"/> --}}

      {{-- flaticon --}}
      {{-- <link rel="stylesheet" href="{{ asset('cssjqueryfiles/adminpanel/plugins/flaticon/materialize.min.css') }}"/> --}}


                           {{-- css cdn links --}}
      {{-- bootstrap cdn
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
       {{-- leaflet js map --}}
       {{-- <link type="text/css" rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

       {{-- fonawesome  
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

       {{-- flaticon
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

       <!--  Switch buttons  -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.css"/> --}}

       {{-- datatables --}}
      {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.4/css/fixedHeader.bootstrap.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css"> --}}


      {{-- jquery_slider
      <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
      
     <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'> --}}