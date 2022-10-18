<?php

namespace App\Http\Controllers;

use Commercetools\Api\Client\ClientCredentialsConfig;
use Commercetools\Api\Client\Config;
use Commercetools\Client\ClientCredentials;
use Commercetools\Client\ClientFactory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Commercetools\Api\Client\ApiRequestBuilder;
use GuzzleHttp\ClientInterface;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $apiRoot = $this->getApiClient();

        $myProject = $apiRoot
            ->get()
            ->execute();

    return $myProject->getName();
    }

    public function getApiClient(){

        $clientId = env('CTP_CLIENT_ID');
        $clientSecret = env('CTP_CLIENT_SECRET');
        $host = env('CTP_HOST');
        $projectKey = env('CTP_PROJECT_KEY');
        $authUrl = env('CTP_AUTH_URL');//"https://auth.$host.commercetools.com/oauth/token"
        $baseurl = env('CTP_API_URL');//"https://api.$host.commercetools.com"

        $authConfig = new ClientCredentialsConfig(
            new ClientCredentials($clientId, $clientSecret),[],
            $authUrl);

        $client = ClientFactory::of()->createGuzzleClient(new Config([],$baseurl),$authConfig);

        $builder =  new ApiRequestBuilder($client);

        return $builder->withProjectKey($projectKey);
    }
}
