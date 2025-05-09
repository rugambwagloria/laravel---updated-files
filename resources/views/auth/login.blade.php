<head>
    <meta charset="UTF-8">
    <!-- other meta tags and CSS/JS links -->
</head>
@extends('layouts.app')

@section('content')
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                @include('layouts.navbars.guest.navbar')
            </div>
        </div>
    </div>
   <main class="main-content  mt-0">
    <section>
        <div class="page-header min-vh-100" style="background-image:url('/images/pupil 10.jpeg')">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-3" style="margin-top: 100px; margin-bottom: 50px;">
                        <div class="card card-plain" >
                            <div class="card-header pb-0 text-start">
                                <h4 class="font-weight-bolder" style="color: black;">Sign In</h4>
                                <p class="mb-0" style="color: black;">Enter your email and password to sign in</p>
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST" action="{{ route('login.perform') }}">
                                    @csrf
                                    @method('post')
                                    <div class="flex flex-col mb-3">
                                     <label for="email" style="color: black; font-size: 18px;">Email</label>
                                        <input type="email" id="email" name="Email" class="form-control form-control-lg" aria-label="Email">
                                        
                                        @error('Email') <p class="text-danger text-xs pt-1" style="color: black;"> {{$message}} </p>@enderror
                                    </div>
                                    <div class="flex flex-col mb-3">
                                     <label for="password" style="color: black; font-size: 18px;">Password</label>
                                        <input type="password" id="password" name="Password" class="form-control form-control-lg" aria-label="Password" >
                                        
                                        @error('Password') <p class="text-danger text-xs pt-1" style="color: black;"> {{$message}} </p>@enderror
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="remember" type="checkbox" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe" style="color: black;">Remember me</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0" style="color: black;">Sign in</button>
                                    </div>
                                </form>
                            </div>
                               <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-1 text-sm mx-auto" style="font-size: 18px; font-weight: bold; color: black;">
                                    Forgot your password? 
                                </p>
                                <p> <a href="{{ route('reset-password') }}" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0" style="font-size: 15px; font-weight: bold; color: black;">Reset password here</a>
                                </p>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-4 text-sm mx-auto" style="font-size: 18px; font-weight: bold; color: black;">
                                    Don't have an account?</b>
                                    <a href="{{ route('register') }}" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0" style="font-size: 15px; font-weight: bold; color: black;"><b>Sign up here</b></a>
                                </p>
                            </div>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection