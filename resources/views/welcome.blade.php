<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>EASI'R Forms - Log In</title>
    </head>

    <body>
        <a href="https://auth.easir.com/?client_id={{ env('EASIR_CLIENT_ID') }}&response_type=code&redirect_uri={{ env('EASIR_CLIENT_REDIR_URI') }}&state={{ $state }}">Log in with EASI'R</a>.
    </body>
</html>
