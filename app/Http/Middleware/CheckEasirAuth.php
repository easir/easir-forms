<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Response;

class CheckEasirAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->session()->has('easir')) {
            return redirect('/');
        } else {
            if (!$this->checkMe($request->session()->get('easir')['access_token'])) {
                $authClient = new Client(['base_uri' => env('EASIR_AUTH_URL')]);
                $response = $authClient->request('POST', 'token', [
                    'query' => [
                        'grant_type' => 'refresh_token'
                    ],
                    'json' => [
                        'client_id' => env('EASIR_CLIENT_ID'),
                        'client_secret' => env('EASIR_CLIENT_SECRET'),
                        'refresh_token' => $request->session()->get('easir')['refresh_token'],
                    ],
                    'http_errors' => false,
                ]);

                if ($response->getStatusCode() == Response::HTTP_OK) {
                    $response = json_decode($response->getBody());

                    $request->session()->set('easir', [
                        'access_token' => $response->access_token,
                        'refresh_token' => $response->refresh_token,
                    ]);

                    if (!$this->checkMe($response->access_token)) {
                        return redirect('/');
                    }
                } else {
                    return redirect('/');
                }
            }
        }

        return $next($request);
    }

    /**
     * @param string $token
     * @return bool
     */
    private function checkMe($token)
    {
        $client = new Client(['base_uri' => env('EASIR_API_URL'),
            'headers' => ['Authorization' => "Bearer $token"],
            'http_errors' => false,
        ]);

        $response = $client->request('GET', 'me');

        if ($response->getStatusCode() == Response::HTTP_OK)
        {
            session(['easir_user' => json_decode($response->getBody()->getContents())->first_name]);
            return true;
        }

        return false;
    }
}
