

<div class="row">
    <div class="col-md-3">
        
    </div>
    <div class="col-md-9">
        <!-- form-group // -->
        <div class="float-right">
            {{ $housescategory->count() }} Products Found
        </div>
    </div>
</div>
<!-- content left -->
    <div class="row">
        <?php if ($housescategory->isEmpty()) { ?>
            No Products Found At the Moment
        <?php } else 
        {
            $countp=0;?>
            @foreach ($housescategory as $rentalhse)
            <div class="col-md-6">
                <section class="card hsecard">
                    <figure>
                        <div class="img-overlay hot-home">
                            @if($rentalhse->vacancy_status==1)
                                <span class="badge badge-info p-2 rounded-0 statusbadge">Vacants Available</span>   
                            @elseif($rentalhse->vacancy_status==2)
                                <span class="badge badge-success p-2 rounded-0 statusbadge">Fully Booked</span>
                            @endif
                            
                            <img src="{{ asset ('imagesforthewebsite/rentalimages/medium/'.$rentalhse->rental_image) }}" alt="{{ $rentalhse->rental_name }}">
                        </div>
                        <figcaption>{{ $rentalhse->rental_name }}
                        </figcaption>
                        <div class="pricelocation" style="border:2px solid yellow; display: flex;
                        justify-content: space-between;">

                            <section class="location">
                                <a class="disabled font-italic h6"><i class="fa fa-map-marker"></i>{{ $rentalhse->houselocation->location_title }}</a>
                            </section>
                            <section class="pricelink">
                                <span class="btn btn-dark">sh.{{ $rentalhse->monthly_rent }}</span>
                            </section>
                        </div>
                    </figure>
                    <div class="card-content">
                        <p>{{ Str::limit($rentalhse->rental_details, 200) }}
                            {{-- {!!str_limit($rentalhse->rental_details,200)!!} --}}
                        </p>

                        <section class="icons-home">
                            <div class="name-icon">
                                <span>bedrooms</span>
                                <div class="icon">
                                    <i class="fas fa-bed"></i>
                                    <span>3</span>
                                </div>
                            </div>
                            <div class="name-icon">
                            <span>bathrooms</span>
                            <div class="icon">
                                <i class="fas fa-sink"></i>
                                <span>3.5</span>
                            </div>
                            </div>
                            <div class="name-icon">
                            <span>area</span>
                            <div class="icon">
                                <i class="fas fa-vector-square"></i>
                                <span>3500</span>
                            </div>
                            </div>
                        </section>
                        
                        <div class="viewprice" style="display: flex;
                        justify-content: space-between;">
                            <div class="cont">
                                <div class="icons-img">
                                    {{-- <button><i class="fas fa-heart fa-3x cyan-text"></i></button> --}}
                                </div>
                            </div>
                            <section class="viewlink">
                                <button><i class="fas fa-heart" alt="Contact Us"></i></button>
                                <button><i class="fas fa-eye" alt="View More House Details"></i></button>
                            </section>
                        </div>
                    </div>
                </section>
            </div>
                <?php $countp++?>
            @endforeach
        <?php } ?> 
    </div>
    <div class="row">
        <div class="col-md-12">
            <nav class="mt-5">
                <ul class="pagination justify-content-center">
                    {!! $housescategory->links() !!}
                    {{-- <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1"><i class="mdi mdi-chevron-left"></i></a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">...</a></li>
                    <li class="page-item"><a class="page-link" href="#">10</a></li>
                    <li class="page-item">
                    <a class="page-link" href="#"><i class="mdi mdi-chevron-right"></i></a> --}}
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- /.content left -->
    {{-- <div class="d-flex justify-content-center">
        {!! $housescategory->links() !!}
    </div> --}}