@extends('layouts.app')

@section('content')
    <h1>Register</h1>

    {{-- Display Validation Errors --}}
    @if ($errors->any())
        <div style="color: red;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- Registration Form --}}
    <form action="{{ route('studentRegister') }}" method="POST">
        @csrf
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter name" value="{{ old('name') }}">
        </div>
        <br>

        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter email" value="{{ old('email') }}">
        </div>
        <br>

        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter password">
        </div>
        <br>

        <div>
            <label for="password_confirm">Confirm Password:</label>
            <input type="password" id="password_confirm" name="password_confirmation" placeholder="Confirm password">
        </div>
        <br>

        <div>
            <input type="submit" value="Register">
        </div>
    </form>

    {{-- Display Success Message --}}
    @if(Session::has('success'))
        <div style="color: green;">
            <p>{{ Session::get('success') }}</p>
        </div>
    @endif
@endsection
