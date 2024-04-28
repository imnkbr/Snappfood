@extends('layouts.auth')

@section('content')

<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
      <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-lg-9 col-xl-7">
          <div class="card bg-secondary shadow-2-strong card-registration" style="border-radius: 15px;">
            <div class="card-body p-4 p-md-5" style="text-align: center">
              <h3 class="text-center mb-4 pb-2 pb-md-0 mb-md-5">Login</h3>
                <form action="/login" method="POST">
                    @csrf

                    <div class="row">
                    <div class="col-md-6 mb-4">

                        <div class="form-outline">
                            <label class="form-label" >Email</label>
                            <input type="email" name="email"  class=" align-item-center form-control form-control-lg" />
                        </div>

                    </div>
                    <div class="col-md-6 mb-4">

                        <div class="form-outline">
                            <label class="form-label" >Password</label>
                            <input type="password" name="password"  class="form-control form-control-lg" />
                        </div>

                        </div>
                    </div>

                    {{-- <div class="row">
                        <div class="col-md-6 mb-4">

                        <div class="form-outline">
                            <label class="form-label" >Password</label>
                            <input type="password" name="password"  class="form-control form-control-lg" />
                        </div>

                        </div>
                    </div> --}}

                    <div class="text-center">
                        <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                    </div>
                </form>
                @if($errors)
                    <div class="mt-4 text-center">
                        @foreach($errors->all() as $error)
                            <li class="text-danger">
                                {{$error}}
                            </li>
                        @endforeach
                    </div>
                @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
