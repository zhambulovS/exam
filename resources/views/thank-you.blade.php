@extends('layouts/app')
@section('content')
    <div class="container">
        <div class="text-center">
            <h2> Thanks for submit your Exam, {{Auth::user()->name}}</h2>
            <a class="btn btn-primary " href="{{route('user.dashboard')}}">Go back</a>
        </div>
    </div>
@endsection
