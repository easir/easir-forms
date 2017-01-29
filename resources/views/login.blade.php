@extends('layouts.base')

@section('title', 'Log in')

@section('body')
    <div class="jumbotron">
        <h1>Welcome to EASI'R Forms</h1>
        <p class="lead">
            With EASI'R Forms you can easily build forms for your website that submits leads in EASI'R.
        </p>
        <p>To continue, you must log in with your EASI'R account.</p>
        <p><a class="btn btn-lg btn-success" href="https://auth.easir.com/?client_id={{ env('EASIR_CLIENT_ID') }}&response_type=code&redirect_uri={{ env('EASIR_CLIENT_REDIR_URI') }}&state={{ $state }}" role="button">
                Sign in with EASI'R
            </a></p>
    </div>
@endsection