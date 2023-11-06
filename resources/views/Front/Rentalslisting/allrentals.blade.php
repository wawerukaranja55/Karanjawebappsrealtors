@extends('Front.frontmaster')
@section('title','Rental Houses Listing')
@section('content')
@section('listingpagestyles')
    <style>
        

        

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
                                            <label for="rentalcat" class="control-label"> {{ $category->rentalcat_title }}</label>
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
                                            <input class="bg-white" type="text" id="amount_start" name="startprice" value="1000" style="border:2px solid rgb(10, 10, 10); color:#0c0c0b; font-weight:bold;"></label>&nbsp;
                                        <label for="amount_end" style="display: inline-block;">Max Price:
                                            <input class="bg-white" type="text" id="amount_end" name="endprice" value="50,000" style="border:2px solid rgb(10, 10, 10); color:#0c0b0b; font-weight:bold;"></label>
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
                                            <label for="rentaltag" class="control-label"> {{ $rentaltag->rentaltag_title }}</label>
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

        // user can contact an admin to request or book a house
        $(document).on('click','#requesthouse',function(){

            var hserequestid=$(this).data('id');

            $('#contactadminmodal').modal('show');
            $('.houseuserid').val(hserequestid);
            $('.request_title').html('Contact Admin To Request/Book a Showing');
                   
            $("#hserequestform").on("submit",function(e){
                var url = '{{ route("send.hserequest") }}'; 
                e.preventDefault();
                $.ajax({
                    url:url,
                    type:"POST",
                    data:$("#hserequestform").serialize(),
                    success:function(response){
                        console.log(response);
                        if(response.status==400)
                        {
                            $('#error_list').html("");
                            $('#error_list').removeClass('d-none');
                            $.each(response.errors,function(key,err_value)
                            {
                                $('#error_list').append('<li>' + err_value +'</li>');
                            });
                        } 
                        else if (response.status==200)
                        {
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(response.message);
                            $('#houseuserid').val('');
                            $('.yourname').val('');
                            $('.youremail').val('');
                            $('.yourphone').val('');
                            $('.hsemsg_request').val('');
                            $('#contactadminmodal').modal('hide');
                        }
                    }
                });
            })
        })


        $(document).ready(function(){
            // change pagination using ajax jquery
            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();

                var page = $(this).attr('href').split('page=')[1];

                getMoreRentals(page)

                return false;
            });
            
            // show the filters using select 2
            $('.sorthses').select2();

            function searchFilter(){
                
                var balcony= $("#balcony").prop('checked') ? 'yes' : '';
                var wifi= $("#wifi").prop('checked') ? 'yes' : '';
                var parking= $("#parking").prop('checked') ? 'yes' : '';
                var generator= $("#generator").prop('checked') ? 'yes' : '';
                var cctvcamera= $("#cctvcamera").prop('checked') ? 'yes' : '';
                var servantquarter= $("#servantquarter").prop('checked') ? 'yes' : '';

                var sorthouses=$("#sort option:selected").val();
                var housesurl=$("#url").val();

                var hselocation = $('input[class^="locationtitle"]').filter(":checked").val();
                var hsetag = $('input[class^="tagtitle"]').filter(":checked").val();
                
                //var start=$('#amount_start').val();        
                //var end=$('#amount_end').val();

                $('.showrentalhouses').html('<div id="searchforhses" style="display:flex; justify-content:center; align-items:center;height:100vh;"><img src="/imagesforthewebsite/icons/ajax-loader.gif"/></div>');
                $.ajax({
                    url:'/'.$housesurl,
                    method:"get",
                    dataType:'html',
                    data:{

                        rentallocations:hselocation,
                        rentaltag:hsetag,

                        filterwifi:wifi,
                        filtersq:servantquarter,
                        filtercctv:cctvcamera,
                        filterparking:parking,
                        filtergenerator:generator,
                        filterbalcony:balcony,

                        url:housesurl,
                        sort:sorthouses,

                        //startprice:start,
                        //endprice:end
                    },
                    success:function(data){
                        // console.log(data);
                        $('.showrentalhouses').html(data);

                        
                        //$('.rentalhses').show();
                    }
                });
            }
            
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

                        var start=$('#amount_start').val();        
                        var end=$('#amount_end').val();
                        
                        var balcony= $("#balcony").prop('checked') ? 'yes' : '';
                        var wifi= $("#wifi").prop('checked') ? 'yes' : '';
                        var parking= $("#parking").prop('checked') ? 'yes' : '';
                        var generator= $("#generator").prop('checked') ? 'yes' : '';
                        var cctvcamera= $("#cctvcamera").prop('checked') ? 'yes' : '';
                        var servantquarter= $("#servantquarter").prop('checked') ? 'yes' : '';

                        var sorthouses=$("#sort option:selected").val();
                        var housesurl=$("#url").val();

                        var hselocation = $('input[class^="locationtitle"]').filter(":checked").val();

                        var hsetag = $('input[class^="tagtitle"]').filter(":checked").val();

                         $('.showrentalhouses').html('<div id="searchforhses" style="display:flex; justify-content:center; align-items:center;height:100vh;"><img src="/imagesforthewebsite/icons/ajax-loader.gif"/></div>');
                        $.ajax({
                            url:'/'.$housesurl,
                            method:"get",
                            dataType:'html',
                            data:{
                                startprice:start,
                                endprice:end,

                                rentallocations:hselocation,
                                rentaltag:hsetag,

                                filterwifi:wifi,
                                filtersq:servantquarter,
                                filtercctv:cctvcamera,
                                filterparking:parking,
                                filtergenerator:generator,
                                filterbalcony:balcony,

                                url:housesurl,
                                sort:sorthouses,
                            },
                            success:function(data){
                                $('.showrentalhouses').html(data);

                                //$('.rentalhses').show();
                            }
                        });
                    }
                });
            });

            // search tags for a house
            $('.tagtitle').on('click',function(){

                searchFilter();
            })

            // search locations for a house
            $('.locationtitle').on('click',function(){
                searchFilter();
            })

            // show houses based on the dropdown selected
            $("#sort").on('change',function(){
                searchFilter();
            });

            // search amenities for a house
            $(".amenitiescheckbox").on('click',function(){

                searchFilter();
                
            });


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

        });

        function getMoreRentals(page)
        {
            var hseurl=$("#url").val();

            var balcony= $("#balcony").prop('checked') ? 'yes' : '';
            var wifi= $("#wifi").prop('checked') ? 'yes' : '';
            var parking= $("#parking").prop('checked') ? 'yes' : '';
            var generator= $("#generator").prop('checked') ? 'yes' : '';
            var cctvcamera= $("#cctvcamera").prop('checked') ? 'yes' : '';
            var servantquarter= $("#servantquarter").prop('checked') ? 'yes' : '';

            var sorthouses=$("#sort option:selected").val();

            var hselocation = $('input[class^="locationtitle"]').filter(":checked").val();
            var hsetag = $('input[class^="tagtitle"]').filter(":checked").val();
            var start=$('#amount_start').val();        
            var end=$('#amount_end').val();

            $.ajax({
                type:"GET",
                url:'{{ route("rentalcategory.get-more-houses") }}' + "?page=" + page,
                data:{
                    url:hseurl,

                    rentallocations:hselocation,
                    rentaltag:hsetag,

                    filterwifi:wifi,
                    filtersq:servantquarter,
                    filtercctv:cctvcamera,
                    filterparking:parking,
                    filtergenerator:generator,
                    filterbalcony:balcony,

                    sort:sorthouses,

                    startprice:start,
                    endprice:end
                },
                success:function(data)
                {
                    console.log(data);
                    $('.showrentalhouses').html(data);
                }
            })
        }

        
        
    </script>
@stop






