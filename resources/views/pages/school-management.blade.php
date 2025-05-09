
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@include('layouts.navbars.auth.topnav', ['title' => 'Schools Information'])
@section('content')
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container">
    <h1>Schools</h1>
    <style>
        
    
        body {
        background-color: orange; /* Replace with your desired color */
    }


        table {
            margin-left:0px;
            border-collapse: collapse; 
            width: 100%;
            
        }
        
        th, td {
            border: 1px solid black; /
            padding: 10px; 
            text-align: 
        }
        
        th {

            background-color: whitesmoke; 
        }
    </style>
      <a href="{{ route('schools.display') }}">School Information</a>

    @if($school_representative->count() > 0)
        <table class="table table-bordered">
          <table style="display: table !important;">

            <thead>
                <tr>
                    <th>School Name</th>
                    <th>School District</th>
                    <th>School RegNo</th>
                    <th>School phone</th>
                    <th>Representative Firstname</th>
                    <th>Representative Lastname</th>
                    <th>Representative Email</th>
                    <th>Representative Password</th>
                </tr>
            </thead>
            <tbody>
                @foreach($school_representative as $school)
                    <tr>
                        <td>{{ $school->school_name }}</td>
                        <td>{{ $school->school_district }}</td>
                        <td>{{ $school->school_regNo}}</td>
                        <td>{{ $school->school_phone }}</td>
                        <td>{{ $school->rep_name }}</td>
                        <td>{{ $school->rep_username }}</td>
                        <td>{{ $school->rep_email }}</td>
                        <td>{{ $school->rep_password }}</td>
                    </tr>
                @endforeach
            </tbody>
            </table>
        </table>
    @else
        <p>No schools found.</p>
    @endif
</div>
@endsection

@push('styles')
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid black;
        padding: 10px;
        text-align: left;
    }
    th {
        background-color: coral;
    }
</style>
@endpush

