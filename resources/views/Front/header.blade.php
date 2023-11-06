

<!-- Header start -->
<?php use App\Models\Rental_category; ?>
<?php use App\Models\Propertycategory; ?>
<header>
    <div class="header-top-two">
        <div class="container">
            <div class="row">
              <div class="col-md-12" style="padding: 5px;">
                <ul class="topbar-nav topbar-left">
                  <li class="disabled"><a href="#"><i class="fa fa-envelope"></i> wawerukaranja57@gmail.com</a></li>
                  <li class="disabled"><a href="#"><i class="fa fa-map-marker"></i>Karanja Avenue,Nyeri Town
                     {{-- 15/A, Nest Tower, NYC --}}
                    </a></li>
                  <li class="disabled"><a href="#"><i class="fa fa-phone"></i>0702521351</a></li>
                </ul>
                <ul class="topbar-nav topbar-right">
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                    </li>
                    <li><a href="#"><i class="fab fa-google-plus"></i></a></li>
                    <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                    <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
    </div>
    <div class="header-lower clearfix">
        <nav id="navbar_top" class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                {{-- <a class="navbar-brand text-success logo" href="{{route ('home.index') }}">
                    <i class="mdi mdi-home-map-marker"></i>
                    <strong>KaranjaWeb</strong>Apps
                </a> --}}
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0 margin-auto">
                        {{-- show home page --}}
                        @if (Session::get('page')=="homepage")
                            <?php $active="active";?>
                        @else
                            <?php $active="";?>
                        @endif
                        <li class="nav-item {{ $active }}">
                            <a class="nav-link" href="{{route ('home.index') }}">Home<span class="sr-only">(current)</span></a>
                        </li>
                        {{-- show the listing page --}}
                        @if (Session::get('page')=="rentalcategory" ||
                            Session::get('page')=="rental_category")
                            <?php $active="active";?>
                        @else
                            <?php $active="";?>
                        @endif
                        <li class="nav-item dropdown {{ $active }}">
                            <?php 
                              $rentalscatsurls=Rental_category::select('rentalcat_url')->where('status',1)->get()->pluck('rentalcat_url');
                            ?>
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Houses To Let
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownPortfolio">
                                @foreach ( $rentalscatsurls as $cat )
                                    @if (Session::get('page')=="rental_category")
                                        <?php $active="active";?>
                                    @else
                                        <?php $active="";?>
                                    @endif
                                        <a class="dropdown-item {{ $active }}" href="{{ url('/'.$cat) }}">{{ Ucwords($cat) }}</a>
                                @endforeach
                            </div>
                        </li>

                        {{-- show the properties to sell --}}
                        @if (Session::get('page')=="propertycategory" ||
                        Session::get('page')=="property_category")
                            <?php $active="active";?>
                        @else
                            <?php $active="";?>
                        @endif
                        <li class="nav-item dropdown {{ $active }}">
                            <?php 
                              $propertycatsurls=Propertycategory::select('propertycat_url')->where('status',1)->pluck('propertycat_url');
                            ?>
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Properties On Sale
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownPortfolio">
                                @foreach ( $propertycatsurls as $propertycat )
                                    @if (Session::get('page')=="property_category")
                                        <?php $active="active";?>
                                    @else
                                        <?php $active="";?>
                                    @endif
                                    <a class="dropdown-item {{ $active }}" href="{{ url('/'.$propertycat) }}">{{ Ucwords($propertycat) }}</a>
                                @endforeach
                            </div>
                        </li>

                        {{-- show contact us page --}}
                        @if (Session::get('page')=="contact_us")
                            <?php $active="active";?>
                        @else
                            <?php $active="";?>
                        @endif
                        <li class="nav-item {{ $active }}">
                            <a class="nav-link" href="{{route ('contact.us') }}">Contact Us</a>
                        </li>
                    </ul>
                    <div class="my-2 my-lg-0">
                        <ul class="list-inline main-nav-right">
                            @guest
                                <li class="list-inline-item">
                                    <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#LogInModal">Sign In</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="btn btn-success btn-sm" href="#" id="signup">Sign Up</a>
                                </li>
                            @else
                            <li class="nav-item nav-profile dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="/imagesforthewebsite/usersimages/{{ Auth::user()->avatar }}" style="width: 32px;
                                    height: 32px;
                                    border-radius: 60%;" alt="profile_picture"/>
                                    <span class="nav-profile-name">{{ Auth::user()->name }}</span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownPortfolio">
                                    <a class="dropdown-item" href="{{ route('myaccount.index',Auth::user()->id)}}">
                                        <i class="mdi mdi-settings text-primary"></i>
                                        My Account
                                    </a>
                                    @if (Auth::user()->is_admin==1)
                                        <a class="dropdown-item" 
                                        href="{{ route('admindashboard.index')}}"
                                        >
                                            <i class="mdi mdi-settings text-primary"></i>
                                            Admin Dashboard
                                        </a>
                                    @endif
                                    <form method="POST" action="{{ route('logoutuser') }}">
                                        @csrf
                        
                                        <a class="dropdown-item" href="route('logoutuser')" 
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="mdi mdi-logout text-primary"></i>Logout
                                        </a>
                                    </form>
                                </div>
                              </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
<!-- Header end -->