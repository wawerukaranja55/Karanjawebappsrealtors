<div class="sidebar-collapse">
    <ul class="nav metismenu" id="side-menu">
       <li class="nav-header">
          <div class="dropdown profile-element">
            @if (Auth::user()->avatar=='default.jpg')
               <img alt="Admin Photo" class="rounded-circle" style="width:100px; height:100px;" src="{{ asset ('imagesforthewebsite/usersimages/default.jpg') }}"/>
            @else
               <img alt="Admin Photo" class="rounded-circle" style="width:100px; height:100px;" src="{{ asset ('imagesforthewebsite/usersimages/'.Auth::user()->avatar) }}"/>
            @endif
             <a data-toggle="dropdown" class="dropdown-toggle" href="#">
             <span class="block m-t-xs font-bold">{{ Auth::user()->name }}</span>
             @foreach ( Auth::user()->roles as $role)
               <span class="text-muted text-xs block">{{ $role->role_name }}<b class="caret"></b></span>
            @endforeach
             </a>
             <ul class="dropdown-menu animated fadeInRight m-t-xs">
                <li><a class="dropdown-item" href="{{ route('myaccount.index',Auth::user()->id)}}">My Profile</a></li>
                {{-- <li><a class="dropdown-item" href="contacts.html">Contacts</a></li>
                <li><a class="dropdown-item" href="mailbox.html">Mailbox</a></li> --}}
                {{-- <li class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="login.html">Logout</a></li> --}}
             </ul>
          </div>
          <div class="logo-element">
              W.KaranjaApps+
          </div>
       </li>
       
       {{-- admin dashboard link --}}
      @if (Session::get('page')=="dashboard")
         <?php $active="active";?>
      @else
         <?php $active="";?>
      @endif
      <li class="{{ $active }}">
         <a href="{{ url('admin/admindashboard') }}">
            <i class="fa fa-dashboard"></i>
           <span class="nav-label">Admin Dashboard</span>
        </a>
      </li>

      {{-- Rental houses category --}}
      @if (Session::get('page')=="tagscatmngt")
         <?php $active="active";?>
      @else
         <?php $active="";?>
      @endif
      <li class="{{ $active }}">
         <a href="{{ url('admin/tagscatmngt') }}">
            <i class="fa-solid fa-building-columns"></i>
           <span class="nav-label">Rental Tags And Categories Management</span>
         </a>
      </li>

      {{--All Rental and Property locations --}}
      @if (Session::get('page')=="locations")
         <?php $active="active";?>
      @else
         <?php $active="";?>
      @endif
      <li class="{{ $active }}">
         <a href="{{ url('admin/alllocations') }}">    
            <i class="fa fa-map-marker-alt"></i>
            <span class="nav-label">Rental and Property Locations</span>
         </a>
      </li>

      {{-- rental spaces link --}}
      @if (Session::get('page')=="activerentals" || 
            Session::get('page')=="inactiverentals" ||
            Session::get('page')=="addrental_house")
         <?php $active="active";?>
      @else
         <?php $active="";?>
      @endif
      <li class="{{ $active }}">
         <a href="#">
            <i class="fa fa-building" aria-hidden="true"></i>
            <span class="nav-label">Rental Houses</span>
            <span class="fa arrow"></span>
         </a>
         <ul class="nav nav-second-level collapse">

            {{-- activate the rental houses added --}}
            @if (Session::get('page')=="inactiverentals")
               <?php $active="active";?>
            @else
               <?php $active="";?>
            @endif
            <li class="{{ $active }}"><a href="{{ url('admin/inactiverentals') }}">Inactive Rentals</a></li>

                  {{-- show all rental houses we have added --}}
            @if (Session::get('page')=="activerentals")
               <?php $active="active";?>
            @else
               <?php $active="";?>
            @endif
            <li class="{{ $active }}"><a href="{{ url('admin/activerentals') }}">Published/Active Rentals</a></li>

                  {{-- add a new houses --}}
            @if (Session::get('page')=="addrental_house")
               <?php $active="active";?>
            @else
               <?php $active="";?>
            @endif
            <li class="{{ $active }}"><a href="{{ url('admin/rentalhouse/add') }}">Add a Rental House</a></li>

         </ul>
      </li>

      {{-- admin properties to sell --}}
      @if (Session::get('page')=="propertiescategories" || 
           Session::get('page')=="inactiveproperties" || 
           Session::get('page')=="activeproperties" || 
           Session::get('page')=="addproperty")
         <?php $active="active";?>
      @else
         <?php $active="";?>
      @endif
      <li class="{{ $active }}">
         <a href="#">
            <i class="fa fa-buysellads" aria-hidden="true"></i>
            <span class="nav-label">Properties to sell</span>
            <span class="fa arrow"></span>
         </a>
         <ul class="nav nav-second-level collapse">

                  {{-- admin properties to sell --}}
            @if (Session::get('page')=="propertiescategories")
               <?php $active="active";?>
            @else
               <?php $active="";?>
            @endif
            <li class="{{ $active }}">
               <a href="{{ url('admin/propertiescategories') }}">
                  <span class="nav-label">Manage Property Categories</span>
               </a>
            </li>

            {{-- admin properties to sell --}}
            @if (Session::get('page')=="inactiveproperties")
               <?php $active="active";?>
            @else
               <?php $active="";?>
            @endif
            <li class="{{ $active }}">
               <a href="{{ url('admin/inactiveproperties') }}">Inactive Properties</span>
               </a>
            </li>

            {{-- admin properties to sell --}}
            @if (Session::get('page')=="activeproperties")
               <?php $active="active";?>
            @else
               <?php $active="";?>
            @endif
            <li class="{{ $active }}">
               <a href="{{ url('admin/activeproperties') }}">Activated Properties</span>
               </a>
            </li>

            {{-- Add a new Property --}}
            @if (Session::get('page')=="addproperty")
               <?php $active="active";?>
            @else
               <?php $active="";?>
            @endif
            <li class="{{ $active }}">
               <a href="{{ url('admin/add_property') }}">
                  <span class="nav-label">Add a New Property</span>
               </a>
            </li>
         </ul>
      </li>

      {{-- manage Registered users --}}
      @if (Session::get('page')=="assignuser_roles" || 
            Session::get('page')=="user_roles" || 
            Session::get('page')=="house_requests")
         <?php $active="active";?>
      @else
         <?php $active="";?>
      @endif
      <li class="{{ $active }}">
         <a href="#">
            <i class="fa fa-building" aria-hidden="true"></i>
            <span class="nav-label">Manage Registered users</span>
            <span class="fa arrow"></span>
         </a>
         <ul class="nav nav-second-level collapse">

            @if (Session::get('page')=="assignuser_roles")
               <?php $active="active";?>
            @else
               <?php $active="";?>
            @endif
            <li class="{{ $active }}">
               <a href="{{ url('admin/assign_userroles') }}">Activate and Assign Roles To Users</a>
            </li>

            {{-- Manage Roles for the admins --}}
            @if (Session::get('page')=="user_roles")
               <?php $active="active";?>
            @else
               <?php $active="";?>
            @endif
            <li class="{{ $active }}">
               <a href="{{ url('admin/user_roles') }}">
                  <i class="fa fa-rocket" aria-hidden="true"></i>
                  <span class="nav-label">Manage Roles for Users</span>
               </a>
            </li>

            @if (Session::get('page')=="house_requests")
               <?php $active="active";?>
            @else
               <?php $active="";?>
            @endif
            <li class="{{ $active }}"><a href="{{ url('admin/houserequests') }}">House Request By Users</a></li>
         </ul>
      </li>

      @can('adminsnotallowed')
         {{-- Manage Rental Reviews by Tenants --}}
         @if (Session::get('page')=="tenantratingsreviews")
            <?php $active="active";?>
         @else
            <?php $active="";?>
         @endif
         <li class="{{ $active }}">
            <a href="{{ url('admin/tenantreviews') }}">
               <i class="fa fa-star"></i>
            <span class="nav-label">Reviews by Tenants</span>
         </a>
         </li>

         {{-- Manage Mpesa Payments for the admins --}}
         @if (Session::get('page')=="mpesa_payments")
            <?php $active="active";?>
         @else
            <?php $active="";?>
         @endif
         <li class="{{ $active }}">
            <a href="{{ url('admin/get_mpesapayments') }}">
               <i class="fa fa-rocket" aria-hidden="true"></i>
               <span class="nav-label">Mpesa Payments By Tenants</span>
            </a>
         </li>

         {{-- Manage emails sent to admins and tenants --}}
         @if (Session::get('page')=="allmemos")
            <?php $active="active";?>
         @else
            <?php $active="";?>
         @endif
         <li class="{{ $active }}">
            <a href="{{ url('admin/show_allmemos') }}">
               <i class="fa fa-sticky-note" aria-hidden="true"></i>
               <span class="nav-label">Manage Memos Sent to Admin and Tenants</span>
            </a>
         </li>
      @endcan
    </ul>
 </div>