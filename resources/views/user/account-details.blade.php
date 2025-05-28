@extends('layouts.app')

@section('content')

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
      <h2 class="page-title">Account Details</h2>
      <div class="row">
        <div class="col-lg-2">
                @include('user.account-nav')
        </div>

        <div class="col-lg-9">
          <div class="page-content my-account__edit">
            <div class="my-account__edit-form">
            <form name="account_edit_form" action="#" method="POST" class="needs-validation" novalidate="">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-floating my-3">
                      <input type="text" class="form-control" placeholder="Full Name" name="name" value="" required="">
                      <label for="name">Name</label>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-floating my-3">
                      <input type="text" class="form-control" placeholder="Mobile Number" name="mobile" value=""
                        required="">
                      <label for="mobile">Mobile Number</label>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-floating my-3">
                      <input type="email" class="form-control" placeholder="Email Address" name="email" value=""
                        required="">
                      <label for="account_email">Email Address</label>
                    </div>
                   </div>
                   <div class="col-md-12">
                    <div class="form-floating my-3">
                      <input type="email" class="form-control" placeholder="Current Password" name="email" value=""
                        required="">
                      <label for="account_email">Current Password</label>
                    </div>
                   </div>
                   <div class="col-md-12">
                        <div class="my-3">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                   </div>
                </div>
            </form>            
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

@endsection