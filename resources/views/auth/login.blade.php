@extends('layouts.app')

@section('content')
    <h1>Login</h1>
    {{-- Display Validation Errors --}}
    @if ($errors->any())
        <div style="color: red;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    {{-- Display Success Message --}}
    @if(Session::has('error'))
        <div style="color: red;">
            <p>{{ Session::get('error') }}</p>
        </div>
    @endif

    {{-- Registration Form --}}
    <form action="{{ route('userLogin') }}" method="POST">
        @csrf
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
            <input type="submit" value="Login">
        </div>
    </form>
    <a href="/forget-password">Forget Password</a>
@endsection
