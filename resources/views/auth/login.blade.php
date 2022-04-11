@extends('layouts.auth')

@section('content')
<section class="container">
    <section class="login-form">

        
            {{-- @if(\Session::has('alert-success'))
                <div class="alert alert-success">
                    <div>{{Session::get('alert-success')}}</div>
                </div>
            @endif --}}
        <form method="post" action="{{ route('login') }}" role="login">
            @csrf
            <img src="{{asset('assets/auth/images/logo.png')}}" class="img-responsive" alt="" />

            @error('email')
                <div class="alert alert-danger">
                    <div>{{ $message }}</div>
                </div>
            @enderror
        
            <input type="email" name="email" placeholder="Email" required class="form-control input-lg @error('email') is-invalid @enderror" />
            {{-- @if(\Session::has('alert'))
                <div class="alert alert-danger">
                    <div>{{Session::get('alert')}}</div>
                </div>
            @endif --}}
            

            <input type="password" name="password" id="password" placeholder="Password" required class="form-control input-lg @error('password') is-invalid @enderror" />
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            
            <input type="checkbox" name="checkbox" value="1" id="checkbox" /> Show Password <br />
            <input type="checkbox" name="remember" value="1" /> Remember me<br />
            {{-- <input type="checkbox" name="tos" value="1" /> You agree to <a href="#" class="text-primary">Terms</a> and 
            <a href="#" class="text-primary">Privacy Policy</a> --}}
            
            <button type="submit" name="go" class="btn btn-lg btn-block btn-primary">
                <i class="fas fa-sign-in-alt mr-2"> Login</i> 
                    
            </button>
        </form>
        <div class="form-links">
            <a href="#" class="text-primary">Create account</a> or <a href="#" class="text-primary">reset password</a>
        </div>
    </section>
</section>

{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
