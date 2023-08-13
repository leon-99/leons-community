@extends('layouts.app')

@section('nav-title')
    <a class="navbar-brand text-white" href="{{ route('index') }}">
        {{ config('app.name', 'Laravel') }}
    </a>
@endsection

@section('title')
    <title>LC | Verify</title>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="text-center mt-5">Verify your email</h4>
            <div class="card my-5 border-0 shadow">
                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
