@extends('layouts/user/user-temp')
@section('content')
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <h1 class="">Profile {{$user->name}}</h1>
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle" width="150px"
                         src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                    <a href="" class="mb-3"><i class="fa fa-edit"></i> Edit photo</a>
                    <span class="font-weight-bold">{{$user->name}}</span>
                    <span class="text-black-50">{{$user->email}}</span>
                </div>
            </div>

            <div class="col-md-8 border-right">
                <form id="" method="POST" action="{{ route('editUser') }}">
                    @csrf
                    <div class="p-3 py-5">
                        <div class="row mt-2">
                            <div class="col-md-6"><label class="labels">Name</label><span style="color: red !important; display: inline; float: none;">*</span><input type="text" class="form-control-plaintext" name="name" placeholder="first name here" value="{{$user->name}}"></div>
                            <div class="col-md-6"><label class="labels">Surname</label><span style="color: red !important; display: inline; float: none;">*</span><input type="text" class="form-control-plaintext" name="surname" value="{{$user->surname}}" placeholder="surname here"></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 mb-2"><label class="labels">Mobile Number</label><span style="color: red !important; display: inline; float: none;">*</span><input type="text" class="form-control-plaintext" name="number" placeholder="enter phone number" value="{{$user->number}}"></div>
                            <div class="col-md-12 mb-2"><label class="labels">Address </label><span style="color: red !important; display: inline; float: none;">*</span><input type="text" class="form-control-plaintext" name="address" placeholder="enter address" value="{{$user->address}}"></div>
                            <div class="col-md-12 mb-2 "><label class="labels">Email</label><span style="color: red !important; display: inline; float: none;">*</span><input type="text" class="form-control-plaintext" name="email" placeholder="enter email id" value="{{$user->email}}"></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6"><label class="labels">Country</label><span style="color: red !important; display: inline; float: none;">*</span><input type="text" class="form-control-plaintext" name="country" placeholder="country" value="{{$user->country}}"></div>
                            <div class="col-md-6"><label class="labels">State/Region</label><span style="color: red !important; display: inline; float: none;">*</span><input type="text" class="form-control-plaintext" name="state" value="{{$user->state}}" placeholder="state"></div>
                        </div>
                        <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit">Save Profile</button></div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    </div>
    </div>

@endsection
