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
    <!-- Grid container -->
  
    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2022 Copyright:
      <a class="text-dark" href="#">w karanjaapps</a>
    </div>
    <!-- Copyright -->
  </footer>