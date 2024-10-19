@extends('layouts.auth')

@section('main-content')
<img style="width: 100px;" class="" src="{{ url('img/uin.png') }}" alt="">
<h1 class="mt-5 text-dark display-4">Login </h1>

<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('register') }}" class="user">
        {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
        @csrf
        <div class="main">
            <div class="w-100">
              <div class="text-field">
                <input type="email" placeholder="..." name="email" value="{{ old('email') }}" required autofocus>
                <label>E-mail:</label>
              </div>
            </div>
            
            <div class="w-100">
              <div class="text-field">
                <input type="text" placeholder="..." name="name" value="{{ old('name') }}" required>
                <label>Name:</label>
              </div>
            </div>
          
            <div class="w-100">
              <div class="text-field">
                <input type="password" placeholder="..." name="password" placeholder="{{ __('Password') }}" required>
                <label>Password:</label>
              </div>
            </div>
            <div class="w-100">
              <div class="text-field">
                <input type="password" placeholder="..." name="password_confirmation" placeholder="{{ __('Confirm Password') }}" required>
                <label>Password:</label>
              </div>
            </div>
        </div>

        {{-- <div class="form-group d-flex justify-content-between" style="margin: 5px 0 15px 0; font-size: 16px !important;">
            <div class="custom-control custom-checkbox small">
                <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="custom-control-label" style="color: #000000AA" for="remember">{{ __('Remember Me') }}</label>
            </div>
            <div class="custom-control custom-checkbox small">
                <a href="{{ route('password.request') }}" style="color: #bc032f">Forgot Password?</a>
            </div>
        </div> --}}

        <div class="button-field">
            <button type="submit">
              Register
            </button>
        </div>

        <div class="" style="margin-top: 40px">
            <span style="font-size: 16px; margin-top: 15px;">Already have an Account? <a href="{{ route('login') }}" style="color: #bc032f">Login</a></span>
        </div>

    </form>
</div>
@endsection