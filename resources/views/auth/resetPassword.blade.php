@extends('layouts.app')

@section('content')
    <h1>Reset Password</h1>

    {{-- Display Validation Errors --}}
    @if ($errors->any())
        <div style="color: red;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- Registration Form --}}
    <form action="{{ route('resetPassword') }}" method="POST">
        @csrf
        <div>
            <input type="hidden" name="id" value="{{$user[0]['id']}}">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter password">
            <label for="password">Confirm password:</label>
            <input type="password" id="password" name="passwordConfirm" placeholder="Enter confirm password">
        </div>
        <br>

        <div>
            <input type="submit" value="Reset Password">
        </div>
    </form>
@endsection
