<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>EASI'R Forms - @yield('title')</title>

    <link href="/css/app.css" rel="stylesheet">
</head>
<body>
<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">EASI'R Forms</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <div class="navbar-right">
                @if(session('easir_user'))
                    <a class="btn btn-default navbar-btn" href="/logout">Log out</a>
                    <p class="navbar-text">Logged in as {{ session('easir_user') }}</p>
                @endif
            </div>
        </div>
    </div>
</nav>

<!-- Begin page content -->
<div class="container">
    @yield('body')
</div>

<script src="/js/app.js"></script>
</body>
</html>