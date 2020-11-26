@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        @if( session('warning'))
            {{ session('warning') }}
        @endif
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif
                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, 
                    <form class="form form-group" action="{{ route('verification.resend') }}" method="POST" >
                        @csrf
                        <input type="submit" value="{{ __('click here to request another') }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
