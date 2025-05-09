@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Challenge Creation'])
<div class="card shadow-lg mx-4 card-school-bottom">
    <div class="card-body p-3">
        <div class="row gx-4">
            <div class="col-auto">
                <div class="avatar avatar-xl position-relative">
                    <img src="/images/pupil.jpg" alt="school_image" class="w-100 border-radius-lg shadow-sm">
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
                    <ul class="nav nav-pills nav-fill p-1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1 active d-flex align-items-center justify-content-center "
                               data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="true">
                                <i class="ni ni-app"></i>
                                <span class="ms-2">App</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center "
                               data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                                <i class="ni ni-email-83"></i>
                                <span class="ms-2">Messages</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center "
                               data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                                <i class="ni ni-settings-gear-65"></i>
                                <span class="ms-2">Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="alert">
    @include('components.alert')
</div>
<div style="text-align:center;">

    <!-- Challenge Creation Section -->
    <div class="create-challenge max-w-6xl mx-auto  mt-5">
        <h2>Create a New Challenge</h2>
        <div class="  mt-5 ">
            <form method="POST" action="{{ route('challenges.store') }}" style="width: 60%; margin: 0 auto; padding: 20px; border: 1px solid #ddd; box-shadow: 0px 2px 5px rgba(0,0,0,0.1);"enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="admin_id" value="{{ Auth::id() }}">
                <div class="form-group">
                    <label for="name">Challenge Name:</label>
                    <input type="text" id="name" name="challenge_name" class="form-control" required>
{{--                     validation error message--}}
                    @error('challenge_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="number">Challenge Description:</label>
                    <textarea id="description" name="challenge_description" class="form-control" required></textarea>
                    @error('challenge_description')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="start_date">Start Date:</label>
                        <input type="date" id="start_date" name="challenge_start_date" class="form-control" required>
                        @error('challenge_start_date')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="finish_date">Finish Date:</label>
                        <input type="date" id="finish_date" name="challenge_end_date" class="form-control" required>
                        @error('challenge_end_date')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="wrong_answer_marks">Wrong Answer Marks:</label>
                        <p>Should either be negative or zero</p>
                        <input type="number" id="wrong_answer_marks" name="wrong_answer_marks" class="form-control" required>
                        @error('wrong_answer_marks')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="blank_answer_marks">Blank Answer Marks:</label>
                        <p>Should either be negative or zero</p>
                        <input type="number" id="blank_answer_marks" name="blank_answer_marks" class="form-control" required>
                        @error('blank_answer_marks')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="questions_to_answer">Questions to Answer:</label>
                        <input type="number" id="questions_to_answer" name="questions_to_answer" class="form-control" required>
                        @error('questions_to_answer')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="duration">Duration of attempt(minutes):</label>
                        <input type="number" id="duration" name="duration" class="form-control" required>
                        @error('duration')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <h3>Upload Documents</h3>
                    <div class="mb-3">
                        <label for="questionDocument" class="form-label">Question Document (Excel)</label>
                        <input type="file" class="form-control" id="questionDocument" name="question_document" required accept=".xlsx, .xls">
                        @error('question_document')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="answerDocument" class="form-label">Answer Document (Excel)</label>
                        <input type="file" class="form-control" id="answerDocument" name="answer_document" required accept=".xlsx, .xls">
                        @error('answer_document')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create Challenge</button>

                <a href="{{ route('challenges.index') }}" class="btn btn-primary-100">Back to Challenges</a>

            </form>

        </div>

        <footer style="background-color: #f0f0f0; padding: 10px; text-align: center;">
    <p>&copy; Mathematics challenge Competition. Numbers Dont Lie</p>
</footer>

</div>
</div>
@include('layouts.footers.auth.footer')

@endsection


