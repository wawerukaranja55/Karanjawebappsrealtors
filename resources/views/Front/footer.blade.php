<footer class="bg-light text-center text-lg-start">
    <!-- Grid container -->
    @if(Session::has('success'))
        <p class="text-success">{{session('success')}}</p>
    @endif

    @if($errors)
        @foreach($errors->all() as $error)
        <p class="text-danger">{{$error}}</p>
        @endforeach
    @endif
    <div class="container p-2 pb-0">
      <div class="row">
        <div class="col-md-5">
          <h4 style="color: rgb(88, 88, 88);">To Our Tenants Pay Your Rent Via</h4>
          <ul class="topbar-nav topbar-left">
            <li class="disabled" style="color: rgb(88, 88, 88); margin:10px; font-weight:bold">Mpesa Paybill:123456</li><br>
            <li class="disabled" style="color: rgb(88, 88, 88); margin:10px; font-weight:bold">Equity Till Number:1234567</li>
          </ul>
        </div>
        <div class="col-md-7">
          <form action="javascript:void(0)" method="post" id="addsubscriber" class="form-horizontal" role="form">
            @csrf
            <!--Grid row-->
            <div class="row">
              <!--Grid column-->
              <div class="col-auto mb-4 mb-md-0">
                <p class="pt-2">
                  <strong>Sign up for our newsletter</strong>
                </p>
              </div>
              <!--Grid column-->
      
              <!--Grid column-->
              <div class="col-md-5 col-12 mb-4 mb-md-0">
                <!-- Email input -->
                <div class="form-outline mb-4">
                  <input type="email" required name="email" id="form5Example25" class="text-white bg-dark form-control" placeholder="Enter Your Email for Subscriptions"/>
                  <label class="form-label" for="form5Example25">Email address</label>
                </div>
              </div>
              <!--Grid column-->
      
              <!--Grid column-->
              <div class="col-auto mb-4 mb-md-0">
                <!-- Submit button -->
                <button type="submit" class="btn btn-primary mb-4">
                  Subscribe
                </button>
              </div>
              <!--Grid column-->
            </div>
            <!--Grid row-->
          </form>
        </div>
      </div>
    </div>
    <!-- Grid container -->
  
    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2022 Copyright:
      <a class="text-dark" href="#">w karanjaapps</a>
    </div>
    <!-- Copyright -->
  </footer>