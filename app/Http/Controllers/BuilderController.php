<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 22/01/2017
 * Time: 23.59
 */

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Cache\Repository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BuilderController extends Controller
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var Repository
     */
    private $cacheRepo;
    /**
     * @var Client
     */
    private $easirClient;

    public function __construct(Request $request, Repository $cacheRepo)
    {
        $this->request = $request;
        $this->cacheRepo = $cacheRepo;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function builder()
    {
        $meResponse = $this->easirCache('me');
        $leadTypes = $this->easirCache('lead-types');
        $teams = $this->easirCache('teams?type=dealer');
        $contactsFieldsResponse = $this->easirCache('fields/contact');
        $accountsFieldsResponse = $this->easirCache('fields/account');

        return view('builder', [
            'user' => "{$meResponse->first_name} {$meResponse->last_name}",
            'contactFixed' => $contactsFieldsResponse->fixed_fields,
            'accountFixed' => $accountsFieldsResponse->fixed_fields,
            'leadTypes' => $leadTypes->data,
            'teams' => $teams->data,
        ]);
    }

    private function easirCache($endpoint = 'me', $method = 'GET')
    {
        $token = $this->request->session()->get('easir')['access_token'];
        $easirClient = new Client(['base_uri' => env('EASIR_API_URL'),
            'headers' => ['Authorization' => "Bearer $token"],
        ]);

        return $this->cacheRepo->remember(
            'easir-cache-' . md5($endpoint . $method . $token),
            3600,
            function () use ($endpoint, $method, $easirClient) {
                return json_decode($easirClient->request($method, $endpoint)->getBody());
            }
        );

    }

    public function builderPost(Request $request)
    {
        $token = $this->request->session()->get('easir')['access_token'];
        $client = new Client(['base_uri' => env('EASIR_API_URL'),
            'headers' => ['Authorization' => "Bearer $token"],
        ]);

        $values = array_map(function ($item) {
            return empty($item) ? null : $item;
        }, $request->all());

        $leadResponse = $client->request('POST', 'leads', [
            'json' => $values,
            'http_errors' => false,
        ]);

        if ($leadResponse->getStatusCode() == Response::HTTP_CREATED) {
            return redirect('/builder');
        } else {
            // @todo Actual error handling
            echo 'Sorry, could not create lead. Server response is as follows:';
            echo '<pre>';
            print_r(json_decode($leadResponse->getBody()->getContents()));
        }
    }
}