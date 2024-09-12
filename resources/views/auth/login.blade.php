@extends('layouts.app')
<title>Login</title>
@section('content')
    <section class="vh-100" style="background-color: #508bfc;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <h3 class="mb-5">Login</h3>
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
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control form-control-plaintext" placeholder="Enter email here" value="{{ old('email') }}" />
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="password" id="password" name="password" class="form-control form-control-plaintext" placeholder="Enter password here" />
                                </div>

                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
                            </form>

                            <div class="d-flex justify-content-center">
                                <a href="/forget-password" class="me-5">Forget Password  </a>
                                <a href="/register" class="me-2">Register</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

