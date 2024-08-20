@extends('layouts.app')

@section('content')
    <h1>Forget Password</h1>

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
    @if(Session::has('success'))
        <div style="color: green;">
            <p>{{ Session::get('success') }}</p>
        </div>
    @endif
    {{-- Registration Form --}}
    <form action="{{ route('forgetPassword') }}" method="POST">
        @csrf
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter email" value="{{ old('email') }}">
        </div>
        <br>

        <div>
            <input type="submit" value="Forget Password">
        </div>
    </form>
    <a href="/">Login</a>
@endsection
