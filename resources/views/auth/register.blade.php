@extends('layouts.app')
<title>Register</title>
@section('content')
    <section class="vh-100" style="background-color: #508bfc;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <h3 class="mb-5">Register</h3>

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
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" id="name" name="name" class="form-control form-control-plaintext" placeholder="Enter name" value="{{ old('name') }}" />
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control form-control-plaintext" placeholder="Enter email" value="{{ old('email') }}" />
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="password" id="password" name="password" class="form-control form-control-plaintext" placeholder="Enter password" />
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label" for="password_confirm">Confirm Password</label>
                                    <input type="password" id="password_confirm" name="password_confirmation" class="form-control form-control-plaintext" placeholder="Confirm password" />
                                </div>

                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block" type="submit">Register</button>
                            </form>

                            {{-- Display Success Message --}}
                            @if(Session::has('success'))
                                <div style="color: green;" class="mt-3">
                                    <p>{{ Session::get('success') }}</p>
                                </div>
                            @endif
                            <a href="/" class="d-block mt-3">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
