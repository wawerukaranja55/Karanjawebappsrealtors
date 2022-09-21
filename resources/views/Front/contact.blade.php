@extends('Front.frontmaster')
@section('title','Contact Us')
@section('content')
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <h3 class="mt-1 mb-5">Get In Touch</h3>
                    <h6 class="text-dark"><i class="fas fa-map-marker-alt"></i> Our Office Address :</h6>
                    <p>Karanja Building 1st Floor,Karanja Avenue</p>
                    <h6 class="text-dark"><i class="fa fa-mobile" aria-hidden="true"></i> Phone :</h6>
                    <p>0702521351</p>
                    <h6 class="text-dark"><i class="fa fa-envelope" aria-hidden="true"></i> Email :</h6>
                    <p>wawerukaranja57@gmail.com</p>
    
                </div>
                <div class="col-lg-8 col-md-8">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 section-title text-left mb-4">
                            <h2>Write To Us</h2>
                        </div>
                        <form class="col-lg-12 col-md-12" method="POST" class="form-horizontal" action="javascript:void(0);" id="contactadminform">
                            @csrf
                            <div class="row section-groups">
                                <div class="form-group inputdetails col-sm-6">
                                    <label>Your Name<span class="text-danger inputrequired">*</span></label>
                                    <input type="text" class="form-control text-white bg-dark" required name="contact_name" id="contact_name" placeholder="Write The contact House Name">
                                </div>
        
                                <div class="form-group inputdetails col-sm-6">
                                    <label>Your Phone Number<span class="text-danger inputrequired">*</span></label>
                                    <input type="text" class="form-control text-white bg-dark" required name="contact_phone" id="contact_phone" placeholder="Write The Your Phone Number">
                                </div>
                            </div>
    
                            <div class="row section-groups">
                                <div class="form-group inputdetails col-sm-12">
                                    <label>Your Email<span class="text-danger inputrequired">*</span></label>
                                    <input type="email" class="form-control text-white bg-dark" required name="contact_email" id="contact_email" placeholder="Write Your Email">
                                </div>
                            </div>
        
                            <div class="form-group inputdetails">
                                <label>Your Request Message<span class="text-danger inputrequired">*</span></label>
                                <textarea class="form-control text-white bg-dark" id="contact-details" name="contact_details" placeholder="Explain More details about your Request here" rows="4"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('contactuspagescript')
    <script>
        // store a rating to the rating table
        $(document).ready(function(){
            var url = '{{ route("contact.admin") }}';        
            $("#contactadminform").on("submit",function(e){
                e.preventDefault();
                $.ajax({
                    url:url,
                    type:"POST",
                    data:$("#contactadminform").serialize(),
                    success:function(response){
                        console.log(response);
                        if (response.status==200)
                        {
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(response.message);
                            $("#ratingdiv").fadeOut(5000);

                        }
                    }   
                })
            });
        });

    </script>
@stop


