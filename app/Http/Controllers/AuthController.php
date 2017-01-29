<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->request->session()->set('easir_oauth_state', str_random(40));

        return view('login', [
            'state' => $this->request->session()->get('easir_oauth_state'),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function easir(Request $request)
    {
        if (!$request->has('code') || !$request->session()->has('easir_oauth_state'))
            throw new \Exception('No auth code or state');

        if ($request->session()->get('easir_oauth_state') != $request->get('state')) {
            throw new \Exception('Invalid state');
        }

        $client = new Client(['base_uri' => env('EASIR_AUTH_URL')]);
        $request = [
            'client_id' =>      env('EASIR_CLIENT_ID'),
            'client_secret' =>  env('EASIR_CLIENT_SECRET'),
            'redirect_uri' =>   env('EASIR_CLIENT_REDIR_URI'),
            'code' =>           $request->get('code'),
        ];
        $response = $client->request('POST', 'token', [
            'query' => [
                'grant_type' => 'authorization_code'
            ],
            'json' => $request,
            'http_errors' => false,
        ]);

        if ($response->getStatusCode() == Response::HTTP_OK) {
            $response = json_decode($response->getBody());

            $this->request->session()->set('easir', [
                'access_token' =>   $response->access_token,
                'refresh_token' =>  $response->refresh_token,
            ]);

            return redirect('/builder');
        }

        return redirect('/');
    }
}