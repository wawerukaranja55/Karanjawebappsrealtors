@extends('Front.frontmaster')
@section('title','Properties Listing')
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
        height: 40px;
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
        <h3 style="text-align: center;">Redefined Property Search</h3>
        <div class="row" style="margin: 10px 0px;">
            <div class="col-md-4" style="margin-top:25px">
                <!-- form-group // -->
                <div class="form-group">
                    <form name="sortproperties" id="sortproperties">
                        <input type="text" name="propertyurl" id="property_url" value="{{ $propertycaturl }}" style="display:none">
                        <select name="propertytosort" class="sortproperties" id="propertysort" style="width: 100%;">
                            <option value="">Default Sorting</option>
                            <option value="latest_properties"
                                @if (isset($_GET['propertytosort']) && $_GET['propertytosort']=="latest_properties")
                                    selected=""
                                @endif
                            >Recently Added Properties</option>
                            <option value="low_to_high"
                                @if (isset($_GET['propertytosort']) && $_GET['propertytosort']=="low_to_high")
                                    selected=""
                                @endif
                            >Price:Low to High</option>
                            <option value="high_to_low"
                                @if (isset($_GET['propertytosort']) && $_GET['propertytosort']=="high_to_low")
                                    selected=""
                                @endif
                            >Price:High to Low</option>
                            <option value="property_name_a_z"
                                @if (isset($_GET['propertytosort']) && $_GET['propertytosort']=="property_name_a_z")
                                    selected=""
                                @endif
                            >Property Name:A to Z</option>
                            <option value="property_name_z_a"
                                @if (isset($_GET['propertytosort']) && $_GET['propertytosort']=="property_name_z_a")
                                    selected=""
                                @endif
                            >Property Name:Z to A</option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row section-groups">
                    <div class="form-group inputdetails col-sm-6">
                        <label>Property Locations<span class="text-danger inputrequired">*</span></label>
                        <select name="propertylocationtitle" class="propertylocation form-control text-white bg-dark">
                            <option value="">Select Your House </option>
                             @foreach($propertylocations as $location)
                                <option value="{{ $location->id }}">
                                   {{ $location->location_title }}</option>
                             @endforeach
                        </select>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-2" style="margin-top:25px">
                {{ $propertycategory->count() }} Products Found
            </div> --}}
        </div>
        
        <div class="showproperties">
            @include('Front.Properties.propertiesjson')
        </div>
    </div>
@endsection

@section('propertylistingpagescript')
    <script>

        // user can contact an admin to request or book a property
        $(document).on('click','#requestproperty',function(){

            var hserequestid=$(this).data('id');

            $('#contactadminmodal').modal('show');
            $('.request_title').html('Contact Admin To Discuss More details about the property');
            $('#houseuserid').val(hserequestid); 

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
                            $('.houseuserid').val('');
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


        // user can contact an admin to request for a property
        $(document).on('click','#requestproperty',function(){

            var propertyrequestid=$(this).data('id');

            $('#contactadminmodal').modal('show');
            $('.houseuserid').val(propertyrequestid);
            console.log(propertyrequestid);
                
            $("#hserequestform").on("submit",function(e){
                var url = '{{ route("send.propertyrequest") }}'; 
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
                            $('.houseuserid').val('');
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
            // show houses based on the sort dropdown selected
            $(".sortproperties").on('change',function(){
                var sortpropertyname=$(this).val();
                var sortpropertylocation=$(".propertylocation option:selected").val();
                var propertycaturl=$("#property_url").val();

                $.ajax({
                    url:'/'.$propertycaturl,
                    method:"get",
                    dataType:'html',
                    data:{
                        propertylocationtitle:sortpropertylocation,
                        propertytosort:sortpropertyname,
                        propertyurl:propertycaturl
                    },
                    success:function(data){
                        console.log(data);
                        $('.showproperties').html(data);
                    }
                });
            });

            // show houses based on the sort dropdown selected
            $(".propertylocation").on('change',function(){
                var sortpropertylocation=$(this).val();
                var sortpropertyname=$(".sortproperties option:selected").val();
                var propertycaturl=$("#property_url").val();

                $.ajax({
                    url:'/'.$propertycaturl,
                    method:"get",
                    dataType:'html',
                    data:{
                        propertylocationtitle:sortpropertylocation,
                        propertytosort:sortpropertyname,
                        propertyurl:propertycaturl
                    },
                    success:function(data){
                        console.log(data);
                        $('.showproperties').html(data);
                    }
                });
            });
        });
    </script>
@stop






