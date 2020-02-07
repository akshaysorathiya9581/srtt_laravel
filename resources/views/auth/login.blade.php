@extends('layouts.app')

@section('content')
     <!-- HOME -->
        <section>
            <div class="container-alt">
                <div class="row">
                    <div class="col-sm-12">

                        <div class="wrapper-page">

                            <div class="m-t-40 account-pages">
                                <div class="text-center account-logo-box">
                                    <h2 class="text-uppercase">
                                        <a href="index.html" class="text-success">
                                            <span><img src="assets/images/logo.png" alt="" height="36"></span>
                                        </a>
                                    </h2>
                                    <!--<h4 class="text-uppercase font-bold m-b-0">Sign In</h4>-->
                                </div>
                                <div class="account-content">
                                    <form class="form-horizontal"  action="{{ route('login') }}" method="POST">
                                         @csrf
                                        <div class="form-group ">
                                            <div class="col-xs-12">
                                                <input class="form-control @error('email') is-invalid @enderror" type="text" id="email" placeholder="Username" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <div class="col-xs-12">
                                                <div class="checkbox checkbox-success">
                                                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="remember">
                                                        Remember me
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                         @if (Route::has('password.request'))
                                            <div class="form-group text-center m-t-30">
                                                <div class="col-sm-12">
                                                    <a lass="text-muted" href="{{ route('password.request') }}">
                                                        <i class="fa fa-lock m-r-5"></i> Forgot your password?
                                                    </a>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="form-group account-btn text-center m-t-10">
                                            <div class="col-xs-12">
                                                <button class="btn w-md btn-bordered btn-danger waves-effect waves-light" type="submit">Log In</button>
                                            </div>
                                        </div>

                                    </form>

                                    <div class="clearfix"></div>

                                </div>
                            </div>
                            <!-- end card-box-->

                            @if (Route::has('register'))
                                <div class="row m-t-50">
                                    <div class="col-sm-12 text-center">
                                        <p class="text-muted">Don't have an account? <a href="{{ route('register') }}" class="text-primary m-l-5"><b>Sign Up</b></a></p>
                                    </div>
                                 </div>                                    
                             @endif   

                        </div>
                        <!-- end wrapper -->

                    </div>
                </div>
            </div>
        </section>
          <!-- END HOME -->
@endsection
