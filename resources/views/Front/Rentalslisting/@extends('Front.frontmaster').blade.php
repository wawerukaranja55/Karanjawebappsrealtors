@extends('Front.frontmaster')
@section('title','Listing Page')
@section('content')
@section('listingpagestyles')
    <style>
        .overlay,
        .img-overlay img {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
        }

        .viewpropertylink {
        text-decoration: none;
        color: white;
        }

        .viewpropertylink:hover {
        color: rgb(12, 1, 1);
        }
        /* container style */

        /* cards style */

        .cards::before {
        content: "featured";
        position: absolute;
        z-index: 5;
        color: white;
        background-color: var(--bg-featured);
        text-transform: capitalize;
        top: 0;
        left: 0;
        transform: translateY(-50%);
        padding: 7px 7px;
        }

        .cards {
        grid-column: 2 / span 12;
        display: grid;
        grid-template-columns: repeat(12, minmax(auto, 60px));
        grid-gap: 40px;
        position: relative;
        }

        .cards::after {
        content: "";
        position: absolute;
        z-index: 5;
        top: 0;
        left: 81.6px;
        border: 16.4px solid transparent;
        border-left-color: var(--bg-featured);
        transform: translateY(-50%);
        }

        /* card style */

        .hsecard {
        grid-column-end: span 4;
        display: flex;
        flex-direction: column;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: white;
        box-shadow: 0px 0px 7px 3px #dfdfdf;
        }

        .hsecard:hover {
        transform: translateY(-7px);
        }

        /* img-overlya style */

        .img-overlay {
        width: 100%;
        padding-top: 56.25%;
        position: relative;
        overflow: hidden;
        }

        .statusbadge{
            position: absolute;
            top: 0px;
            right: left:10px;
            z-index: 3;
        }

        .img-overlay img {
        width: 100%;
        /* z-index: 1; */
        }

        .img-overlay img:hover + div {
        width: 100%;
        }

        figcaption {
        padding: 30px 0 30px 30px;
        font-weight: 600;
        text-transform: capitalize;
        color: var(--h2-text-color);
        font-size: 1.2rem;
        }

        /* .overlay {
        width: 0;
        height: 100%;
        display: grid;
        place-content: center;
        background-color: rgb(240, 99, 240);
        opacity: 0.8;
        z-index: 2;
        transition: all 0.5s ease 0.1s;
        } */

        .overlay:hover {
        width: 100%;
        }

        /* .overlay:hover > a {
        display: block;
        text-align: center;
        border-color: var(--border-view-color);
        } */

        /* .overlay a {
        display: none;
        width: 140px;
        padding: 15px 0;
        text-transform: capitalize;
        border: 2px solid transparent;
        transition: border 10s ease;
        } */

        /* icons-img style */

        .cont {
        position: absolute;
        z-index: 6;
        width: 100%;
        height: 100%;
        }

        .icons-img {
        position: relative;
        width: 100%;
        height: 100%;
        }

        .icons-img button {
        position: absolute;
        border: none;
        background-color: transparent;
        color: white;
        cursor: pointer;
        top: -40px;
        z-index: 10;
        }

        .icons-img button:first-of-type {
        right: 55px;
        }

        .icons-img button:last-of-type {
        right: 20px;
        }

        .icons-img button:first-of-type:hover {
        right: 55px;
        color: #ff3232;
        }

        .icons-img i {
        font-size: 25px;
        }

        /* card-content styles */

        .card-content {
        padding: 0px 30px 30px;
        line-height: 15px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 200px;
        font-size: 14px;
        }

        .card-content p {
        color: var(--p-text-color);
        }

        /* icons-home style */

        .icons-home {
        display: flex;
        justify-content: space-between;
        }

        .name-icon {
        height: 60px;
        display: flex;
        flex-direction: column;
        justify-content: space-evenly;
        }

        .name-icon > span {
        text-transform: capitalize;
        color: var(--h2-text-color);
        }

        /* icon styles */

        .icon {
        display: flex;
        align-items: center;
        }

        .icon i {
        color: var(--icon-info-color);
        font-size: 20px;
        margin-right: 10px;
        }

        .icon span {
        vertical-align: middle;
        }

        /* price style */

        .price {
        text-transform: capitalize;
        display: flex;
        flex-direction: column;
        }

        .price span:last-of-type {
        color: var(--price-text-color);
        font-size: 18px;
        }

        /* media screen style */

        @media screen and (max-width: 1000px) {
        .hsecard {
            grid-column-end: span 6;
        }
        /* card-content style */
        }

        @media screen and (max-width: 700px) {
        .cards {
            grid-template-columns: repeat(12, minmax(auto, 1fr));
            grid-column-gap: 10px;
            grid-row-gap: 30px;
        }
        .hsecard {
            grid-column-end: span 12;
        }
        /* icons-home style */
        .card-content {
            font-size: 16px;
        }
        /* price style */
        .price span:last-of-type {
            color: var(--price-text-color);
            font-size: 20px;
        }
        }

        @media screen and (max-width: 500px) {
        .cards {
            grid-template-columns: repeat(12, minmax(auto, 1fr));
            grid-column-gap: 10px;
            grid-row-gap: 30px;
        }
        .hsecard {
            grid-column-end: span 12;
        }
        /* card-content style */
        }

    </style>
@stop
    <div class="container" style="margin-top: 20px;">
        <div class="row">
            <div class="col-md-3 right-sidebar">
                <!-- right sidebar -->
                <h3>Redefined Rental House Search</h3>
                
                <div class="row">
                    <!-- /.widget -->
                    <div class="col-md-12 widget widget-category">
                        <!-- widget -->
                        <div class="card">
                            <div class="card-body">
                               <div class="row">
                                <div class="col-sm-6" style="padding: 0px 2px;">
                                    <div class="card-title" style="margin:0px; padding:3px;">
                                        <h5 style="color: black; font-size:18px;">Categories</h5>
                                    </div>
                                    @foreach ($rentalcategories as $category)
                                        <div class="checkbox checkbox-success">
                                            <input type="text" value="{{ $category->id }}" class="catid">
                                            <input type="radio" name="rentalcategory" class="rentalcattitle" id="rentalcat{{ $category->id }}" value="{{ $category->id }}">
                                            <label for="rentalcat" class="control-label"> {{ $category->rentalcat_title }}</label><span>({{ $category->rentalhses->count() }})</span>
                                        </div>
                                    @endforeach
                                </div>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- /.widget -->
                    <div class="col-md-12 widget widget-category">
                        <!-- widget -->
                        <div class="card">
                            
                            <div class="card-body">
                               <div class="row">
                                <div class="col-md-12" style="padding: 0px 2px;">
                                    <div class="card-title" style="margin:0px; padding:3px;">
                                        <h4 style="color: black; font-size:18px;">Filter Rental House Based On Prices</h4>
                                    </div>
                                    <p class="clearfix">
                                        <label for="amount_start" style="display:inline-block;margin-right:10px;">Min Price:
                                            <input type="text" id="amount_start" name="startprice" value="1000" style="border:0; color:#f6931f; font-weight:bold;"></label>&nbsp;
                                        <label for="amount_end" style="display: inline-block;">Max Price:
                                            <input type="text" id="amount_end" name="endprice" value="50,000" style="border:0; color:#f6931f; font-weight:bold;"></label>
                                    </p>
                                       
                                    <div id="slider-range"></div> 
                                </div>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- /.widget -->
                    <div class="col-md-12 widget widget-category">
                        <!-- widget -->
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title" style="margin:0px; padding:3px;">
                                    <h5 style="color: black; font-size:18px;">Amenities</h5>
                                </div>
                                <div class="checkbox checkbox-success">
                                    <input type="checkbox" class="amenitiescheckbox" name="filterbalcony" value="yes" id="balcony">
                                    <label for="rentalcat" class="control-label">Balcony</label>
                                </div>
                                <div class="checkbox checkbox-success">
                                    <input type="checkbox" class="amenitiescheckbox" name="filtergenerator" value="yes" id="generator">
                                    <label for="rentalcat" class="control-label">Generator</label>
                                </div>
                                <div class="checkbox checkbox-success">
                                    <input type="checkbox" class="amenitiescheckbox" name="filterwifi" value="yes" id="wifi">
                                    <label for="rentalcat" class="control-label">Wifi</label>
                                </div>
                                <div class="checkbox checkbox-success">
                                    <input type="checkbox" class="amenitiescheckbox" name="filterparking" value="yes" id="parking">
                                    <label for="rentalcat" class="control-label">Parking</label>
                                </div>
                                <div class="checkbox checkbox-success">
                                    <input type="checkbox" class="amenitiescheckbox" name="filtercctv" value="yes" id="cctvcamera">
                                    <label for="rentalcat" class="control-label">Cctv_Camera</label>
                                </div>
                                <div class="checkbox checkbox-success">
                                    <input type="checkbox" class="amenitiescheckbox" name="filtersq" value="yes" id="servantquarter">
                                    <label for="rentalcat" class="control-label">Servant Quarters</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- /.widget -->
                    <div class="col-md-12 widget widget-category">
                        <!-- widget -->
                        <div class="card">
                            <div class="card-body">
                               <div class="row">
                                <div class="col-sm-9" style="padding: 0px 2px;">
                                    <div class="card-title" style="margin:0px; padding:3px;">
                                        <h5 style="color: black; font-size:18px;">Rental Tags</h5>
                                    </div>
                                    @foreach ($rentaltags as $rentaltag)
                                        <div class="checkbox checkbox-success">
                                            <input type="radio" name="rentaltag" class="tagtitle" id="tag{{ $rentaltag->id }}" value="{{ $rentaltag->id }}">
                                            <label for="rentaltag" class="control-label"> {{ $rentaltag->rentaltag_title }}</label><span>({{ $rentaltag->tagshouse->count() }})</span><br>
                                        </div>
                                    @endforeach
                                </div>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- /.widget -->
                    <div class="col-md-12 widget widget-category">
                        <!-- widget -->
                        <div class="card">
                            <div class="card-body">
                               <div class="row">
                                <div class="col-sm-9" style="padding: 0px 2px;">
                                    <div class="card-title" style="margin:0px; padding:3px;">
                                        <h5 style="color: black; font-size:18px;">House Locations</h5>
                                    </div>
                                    @foreach ($rentallocations as $location)
                                        <div class="checkbox checkbox-success">
                                            <input type="radio" name="rentallocations" class="locationtitle" id="location{{ $location->id }}" value="{{ $location->id }}">
                                            <label for="rentallocations" class="control-label"> {{ $location->location_title }}</label>
                                        </div>
                                    @endforeach
                                </div>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.right sidebar -->
            <div class="col-md-9 content-left">
                <div class="row" style="margin: 10px 0px;">
                    {{-- <div id="notificdiv"></div> --}}
                    <div class="col-md-4">
                        <!-- form-group // -->
                        <div class="form-group">
                            <form name="sorthouses" id="sorthouses">
                                <input type="text" name="url" id="url" value="{{ $rentalcaturl }}" style="display:none">
                                <select name="sort" class="sorthses" id="sort" style="width: 100%;">
                                    <option value="">Default Sorting</option>
                                    <option value="latest_houses"
                                        @if (isset($_GET['sort']) && $_GET['sort']=="latest_houses")
                                            selected=""
                                        @endif
                                    >Recently Added Houses</option>
                                    {{-- <option value="most_popular"
                                        @if (isset($_GET['sort']) && $_GET['sort']=="most_popular")
                                            selected=""
                                        @endif
                                    >Most Popular Houses</option> --}}
                                    <option value="low_to_high"
                                        @if (isset($_GET['sort']) && $_GET['sort']=="low_to_high")
                                            selected=""
                                        @endif
                                    >Price:Low to High</option>
                                    <option value="high_to_low"
                                        @if (isset($_GET['sort']) && $_GET['sort']=="high_to_low")
                                            selected=""
                                        @endif
                                    >Price:High to Low</option>
                                    <option value="house_name_a_z"
                                        @if (isset($_GET['sort']) && $_GET['sort']=="house_name_a_z")
                                            selected=""
                                        @endif
                                    >House Name:A to Z</option>
                                    <option value="house_name_z_a"
                                        @if (isset($_GET['sort']) && $_GET['sort']=="house_name_z_a")
                                            selected=""
                                        @endif
                                    >House Name:Z to A</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <input type="text" id="search_houses" style="width:100%;" class="form-control text-light bg-dark float-right" required name="search_houses" placeholder="Search for A Rental House">@csrf
                        <div id="searchedproducts"></div>
                    </div>
                </div>
                <div class="showrentalhouses">
                    @include('Front.Rentalslisting.rentalhsesjson')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('listingpagescript')
    <script>
         $(document).ready(function(){
            
            // show the filters using select 2
            $('.sorthses').select2();

            // live search products and show the products as a list the redirect to the product page
            $('#search_houses').keyup(function(){
                var query=$(this).val();
                
                if(query!=''){
                    var token=$('input[name="_token"]').val();
                    var urllink="autocomplete/search";
                    var houseurl=$("#url").val();

                    $.ajax({
                        url:urllink,
                        method:"post",
                        data:{
                            search_houses:query,
                            url:houseurl,
                            _token:token 
                        },
                        success:function(data){
                            $('#searchedproducts').fadeIn();
                            $('#searchedproducts').html(data);
                        }
                    });
                }
            });

            // upon clicking the selected option its placed inside the input
            $(document).on('click','li',function(){
                // $('#search_products').val($(this).text());
                $('#searchedproducts').fadeOut();
                $('#search_houses').val('');
            })

            // remove the other options upon selecting the one we wanted
            const input=document.querySelector('#search_houses')
            input.addEventListener('blur',function(event){
                var $trigger=(".filter-box");

                if($trigger !==event.target && !$trigger.has(event.target).length){
                    $(".dropdown-menu").slideUp("fast");
                }
            })

            input.addEventListener('focus',function(){
                $(this).find(".dropdown-menu").slideToggle("fast");
                
            })

            function searchFilter(){
                var balcony= $("#balcony").prop('checked') ? 'yes' : '';
                var wifi= $("#wifi").prop('checked') ? 'yes' : '';
                var parking= $("#parking").prop('checked') ? 'yes' : '';
                var generator= $("#generator").prop('checked') ? 'yes' : '';
                var cctvcamera= $("#cctvcamera").prop('checked') ? 'yes' : '';
                var servantquarter= $("#servantquarter").prop('checked') ? 'yes' : '';

                var start=$('#amount_start').val();        
                var end=$('#amount_end').val();

                var sorthouses=$("#sort option:selected").val();
                var housesurl=$("#url").val();

                var hsecategory= $(".rentalcattitle").prop('checked') ? $('.rentalcattitle').value : ''
                var hselocation= $(".locationtitle").prop('checked') ? $('.rentalcattitle').value : '';
                var hsetag= $(".tagtitle").prop('checked') ? $('.tagtitle').value : '';

                console.log(hsetag);
                $.ajax({
                    url:'/'.$housesurl,
                    method:"get",
                    data:{
                        rentallocations:hselocation,
                        rentalcategory:hsecategory,
                        rentaltag:hsetag,

                        filterwifi:wifi,
                        filtersq:servantquarter,
                        filtercctv:cctvcamera,
                        filterparking:parking,
                        filtergenerator:generator,
                        filterbalcony:balcony,

                        url:housesurl,
                        sort:sorthouses,

                        startprice:start,
                        endprice:end,
                    },
                    success:function(data){
                        console.log(data);
                        $('.showrentalhouses').html(data);
                    }
                });
            }

            // show houses based on the dropdown selected
            $("#sort").on('change',function(){
                searchFilter();
            });

            // search amenities for a house
            $(".amenitiescheckbox").on('click',function(){

                searchFilter();
                
            });
         
            // slider function
            $( function() {
                $( "#slider-range" ).slider({

                    range: true,
                    min: 1000,
                    max: 50000,
                    values: [ 1000, 50000 ],
                    slide: function( event, ui ) {
                        $( "#amount_start" ).val(ui.values[ 0 ]);
                        $( "#amount_end" ).val(ui.values[ 1 ]);

                        searchFilter();

                        // var start=$('#amount_start').val();
                        // var end=$('#amount_end').val();

                        // var urlhouses=$("#url").val();
                        // var sorthouses=$("#sort option:selected").val();
                        
                        // var hsecategory = $('.rentalcattitle').checked ? $('.rentalcattitle').value : '';
                        // var hselocation = $('.locationtitle').checked ? $('.locationtitle').value : '';
                        // var hsetag = $('.tagtitle').checked ? $('.tagtitle').value : '';

                        // var balcony= $("#balcony").prop('checked') ? 'yes' : '';
                        // var wifi= $("#wifi").prop('checked') ? 'yes' : '';
                        // var parking= $("#parking").prop('checked') ? 'yes' : '';
                        // var generator= $("#generator").prop('checked') ? 'yes' : '';
                        // var cctvcamera= $("#cctvcamera").prop('checked') ? 'yes' : '';
                        // var servantquarter= $("#servantquarter").prop('checked') ? 'yes' : '';
                        
                        // $.ajax({
                        //     method:"get",
                        //     dataType:'html',
                        //     url:'',
                        //     data:{
                        //         rentallocations:hselocation,
                        //         rentalcategory:hsecategory,
                        //         rentaltag:hsetag,

                        //         filterwifi:wifi,
                        //         filtersq:servantquarter,
                        //         filtercctv:cctvcamera,
                        //         filterparking:parking,
                        //         filterbalcony:balcony,
                        //         filtergenerator:generator,

                        //         sort:sorthouses,
                        //         url:urlhouses,

                        //         startprice:start,
                        //         endprice:end,
                        //     },

                        //     success:function(response){
                        //         console.log(response)
                                
                        //         $('.showrentalhouses').html(response);
                        //     }
                        // })
                    }
                });
            });

            // search tags for a house
            $('.tagtitle').on('click',function(){

                var hsetag= $(this).val();
                searchFilter();
                // var hsecategory = $('.rentalcattitle').checked ? $('.rentalcattitle').value : '';
                // var hselocation = $('.locationtitle').checked ? $('.locationtitle').value : '';

                // var balcony= $("#balcony").prop('checked') ? 'yes' : '';
                // var wifi= $("#wifi").prop('checked') ? 'yes' : '';
                // var parking= $("#parking").prop('checked') ? 'yes' : '';
                // var generator= $("#generator").prop('checked') ? 'yes' : '';
                // var cctvcamera= $("#cctvcamera").prop('checked') ? 'yes' : '';
                // var servantquarter= $("#servantquarter").prop('checked') ? 'yes' : '';

                // var start=$('#amount_start').val();        
                // var end=$('#amount_end').val();

                // var sorthouses=$("#sort option:selected").val();
                // var housesurl=$("#url").val();

                // $.ajax({
                //     url:'',
                //     method:"get",
                //     data:{
                //         rentallocations:hselocation,
                //         rentalcategory:hsecategory,
                //         rentaltag:hsetag,

                //         filterwifi:wifi,
                //         filtersq:servantquarter,
                //         filtercctv:cctvcamera,
                //         filterparking:parking,
                //         filtergenerator:generator,
                //         filterbalcony:balcony,

                //         url:housesurl,
                //         sort:sorthouses,

                //         startprice:start,
                //         endprice:end,
                //     },
                //     success:function(data){
                //         console.log(data);
                //         $('.showrentalhouses').html(data);
                //     }
                // });
            })

            // search locations for a house
            $('.locationtitle').on('click',function(){

                var hselocation= $(this).val();

                searchFilter();
                // var hsecategory = $('.rentalcattitle').checked ? $('.rentalcattitle').value : '';
                // // var hselocation = $('.locationtitle').checked ? $('.locationtitle').value : '';
                // var hsetag = $('.tagtitle').checked ? $('.tagtitle').value : '';
                // // var hsecategory= $('.rentalcattitle').is(':checked');
                // // var hselocation= $('.locationtitle').is(':checked');
                // // var hsetag= $('.tagtitle').is(':checked');
                // // var hsetag= $('.tagtitle').val();
                // // var hsecategory= $('.rentalcattitle').val();

                // var balcony= $("#balcony").prop('checked') ? 'yes' : '';
                // var wifi= $("#wifi").prop('checked') ? 'yes' : '';
                // var parking= $("#parking").prop('checked') ? 'yes' : '';
                // var generator= $("#generator").prop('checked') ? 'yes' : '';
                // var cctvcamera= $("#cctvcamera").prop('checked') ? 'yes' : '';
                // var servantquarter= $("#servantquarter").prop('checked') ? 'yes' : '';

                // var start=$('#amount_start').val();        
                // var end=$('#amount_end').val();

                // var sorthouses=$("#sort option:selected").val();
                // var housesurl=$("#url").val();

                // $.ajax({
                //     url:'',
                //     method:"get",
                //     data:{
                //         rentallocations:hselocation,
                //         rentalcategory:hsecategory,
                //         rentaltag:hsetag,
                        
                //         filterwifi:wifi,
                //         filtersq:servantquarter,
                //         filtercctv:cctvcamera,
                //         filterparking:parking,
                //         filtergenerator:generator,
                //         filterbalcony:balcony,

                //         url:housesurl,
                //         sort:sorthouses,

                //         startprice:start,
                //         endprice:end,
                //     },
                //     success:function(data){
                //         console.log(data);
                //         $('.showrentalhouses').html(data);
                //     }
                // });
            })
            
            // filter using category
            $('.rentalcattitle').on('click',function(){

                var hsecategory= $(this).val();

                searchFilter();
                // get category_id,tag_id and location_id
                // var $categoryid=$('.tagid').val();
                // console.log($categoryid);
                
                // var hselocation = $('.locationtitle').checked ? $('.locationtitle').value : '';
                // var hsetag = $('.tagtitle').checked ? $('.tagtitle').value : '';
                // // var hsecategory= $('.rentalcattitle').is(':checked');
                // // var hselocation= $('.locationtitle').is(':checked');
                // // var hsetag= $('.tagtitle').is(':checked');
                // // var hselocation= $('.locationtitle').val();
                // // var hsetag= $('.tagtitle').val();

                // var balcony= $("#balcony").prop('checked') ? 'yes' : '';
                // var wifi= $("#wifi").prop('checked') ? 'yes' : '';
                // var parking= $("#parking").prop('checked') ? 'yes' : '';
                // var generator= $("#generator").prop('checked') ? 'yes' : '';
                // var cctvcamera= $("#cctvcamera").prop('checked') ? 'yes' : '';
                // var servantquarter= $("#servantquarter").prop('checked') ? 'yes' : '';

                // var start=$('#amount_start').val();        
                // var end=$('#amount_end').val();

                // var sorthouses=$("#sort option:selected").val();
                // var housesurl=$("#url").val();

                // $.ajax({
                //     url:'',
                //     method:"get",
                //     data:{
                //         rentallocations:hselocation,
                //         rentalcategory:hsecategory,
                //         rentaltag:hsetag,

                //         filterwifi:wifi,
                //         filtersq:servantquarter,
                //         filtercctv:cctvcamera,
                //         filterparking:parking,
                //         filtergenerator:generator,
                //         filterbalcony:balcony,

                //         url:housesurl,
                //         sort:sorthouses,

                //         startprice:start,
                //         endprice:end,
                //     },
                //     success:function(data){
                //         console.log(data);
                //         $('.showrentalhouses').html(data);
                //     }
                // });
            })

        });

        
        
    </script>
@stop






