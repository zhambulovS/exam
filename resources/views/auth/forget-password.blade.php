@extends('layouts.app')
<title>Forget password</title>
@section('content')
    <section class="vh-100" style="background-color: #508bfc;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <h3 class="mb-5">Forget Password</h3>

                            {{-- Display Validation Errors --}}
                            @if ($errors->any())
                                <div style="color: red;">
                                    @foreach($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Display Success/Error Message --}}
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

                            {{-- Forget Password Form --}}
                            <form action="{{ route('forgetPassword') }}" method="POST">
                                @csrf
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control form-control-plaintext" placeholder="Enter email here" value="{{ old('email') }}" />
                                </div>

                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block" type="submit">Forget Password</button>
                            </form>

                            <a href="/" class="d-block mt-3">Login</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
