@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Your school'])

    <div class="card shadow-lg mx-4 card-school-bottom"style="background-image:url('/images/pupil girl.jpg')">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="/images/cha.jpeg" alt="school_image" class="w-100 border-radius-lg ">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">

                        <p class="mb-0 font-weight-bold text-sm">

                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                    <div class="nav-wrapper position-relative end-0">
                     
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="container-fluid py-4">

            <div class=" mx-auto px-5">
                <div class="card mx-auto flex flex-col items-center justify-center">
                    <form role="form"  action="{{ route('school.store') }}" method="POST">
    <!-- Your form fields here -->
      @csrf
                        <div class="card-header pb-0">

                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">School Information</p>
                            <div class="row">
                                <div class="">

                                    <div class="form-group{{ $errors->has('school_name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-school_name">
                                            <i class="w3-xxlarge fa fa-user"></i>{{ __('School Name') }}
                                        </label>
                                        <input type="text" name="school_name" id="input-school_name" class="w-full form-control{{ $errors->has('school_name') ? ' is-invalid' : '' }}" placeholder="{{ __('School Name') }}" required autofocus>


                                </div>
                                    <label class="form-control-label" for="input-school_regNo">
                                        <i class="w3-xxlarge fa fa-id-badge"></i>{{ __('School RegNo') }}
                                    </label>
                                    <input type="text" name="school_regNo" id="input-school_regNo" class="form-control{{ $errors->has('school_regNo') ? ' is-invalid' : '' }}" placeholder="{{ __('School RegNo') }}" required autofocus>
                            <hr class="horizontal dark">

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group{{ $errors->has('school_district') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-school_district">
                                            <i class="w3-xxlarge fa fa-location-arrow"></i>{{ __('School District') }}
                                        </label>
                                        <input type="text" name="school_district" id="input-school_district" class="form-control{{ $errors->has('school_district') ? ' is-invalid' : '' }}" placeholder="{{ __('School District') }}" required autofocus>


                                </div>
{{--                                    school phone--}}
                                    <div class="form-group {{ $errors->has('school_phone') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-school_phone">
                                            <i class="w3-xxlarge fa fa-phone"></i>{{ __('School Phone') }}
                                        </label>
                                        <input type="text" name="school_phone" id="input-school_phone" class="form-control{{ $errors->has('school_phone') ? ' is-invalid' : '' }}" placeholder="{{ __('School Phone') }}" required autofocus>
                                    </div>
                                </div>

                            </div>
                                <div class="col-md-6">

                                    <div class="form-group{{ $errors->has('school_regNo') ? ' has-danger' : '' }}">

                                </div>

                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">School Representative</p>
                            <div class="row">
                                <div class="col-md-12">


                                    <div class="form-group{{ $errors->has('rep_name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-rep_name">
                                            <i class="w3-xxlarge fa fa-user"></i>{{ __('Representative name') }}
                                        </label>
                                        <input type="text" name="rep_name" id="input-rep_name" class="form-control{{ $errors->has('rep_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Representative name') }}" required autofocus>


                                </div>

                                <div class="col-md-12">
                                      <div class="form-group{{ $errors->has('rep_username') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-rep_username">
                                            <i class="w3-xxlarge fa fa-user"></i>{{ __('Representative Username') }}
                                        </label>
                                        <input type="text" name="rep_username" id="input-rep_username" class="form-control{{ $errors->has('rep_username') ? ' is-invalid' : '' }}" placeholder="{{ __('Representative Username') }}" required autofocus>


                                </div>
                                    </div>
                                <div class="col-md-16">
                                       <div class="form-group{{ $errors->has('rep_email') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-rep_email">
                                            <i class="w3-xxlarge fa fa-envelope"></i>{{ __('Representative email') }}
                                        </label>
                                        <input type="text" name="rep_email" id="input-rep_email" class="form-control{{ $errors->has('rep_email') ? ' is-invalid' : '' }}" placeholder="{{ __('Representative email') }}" required autofocus>

                                        </div>

                                </div>
{{--                                    phone--}}
                                <div class="col-md-12">
                                    <div class="form-group
                                    {{ $errors->has('rep_phone') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-rep_phone">
                                            <i class="w3-xxlarge
                                            fa fa-phone"></i>{{ __('Representative Phone') }}
                                        </label>
                                        <input type="text" name="rep_phone" id="input-rep_phone" class="form-control{{ $errors->has('rep_phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Representative Phone') }}" required autofocus>
{{--                                    password enytered as text--}}
                                <div class="col-md-12">
                                    <div class="form-group  {{ $errors->has('rep_password') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-rep_password">
                                            <i class="w3-xxlarge fa fa-lock"></i>{{ __('Password') }}
                                        </label>
                                        <input type="text" name="rep_password" id="input-rep_password" class="form-control{{ $errors->has('rep_password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" required autofocus>



                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-round btn-lg">{{ __('Save') }}</button>
                        </div>

                                    </div>
                                </div>


                    </form>

                </div>
            </div>
        </div>
        <footer style="background-color: #f0f0f0; padding: 10px; text-align: center;">
    <p>&copy; Mathematics challenge Competition. All rights reserved.</p>
</footer>
    </div>
        @include('layouts.footers.auth.footer')

@endsection
