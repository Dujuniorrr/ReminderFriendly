<?php

namespace Src\Infra\Gateway;

use Exception;
use Src\Application\Enviroment\Env;
use Src\Application\Gateways\MessageSenderGateway;
use Src\Application\Http\Server\HTTPClient;
use Src\Domain\Reminder;

class ZAPIMessageSenderGateway implements MessageSenderGateway
{
    private HTTPClient $httpClient;
    private string $apiToken;
    private string $apiClientToken;
    private string $apiInstance;
    private string $apiUrl;
    private string $phone;

    public function __construct(HTTPClient $httpClient, Env $env)
    {
        $this->httpClient = $httpClient;
        $this->apiToken = $env->get('Z_API_TOKEN');
        $this->apiClientToken = $env->get('Z_API_CLIENT_TOKEN');
        $this->apiInstance = $env->get('Z_API_INSTANCE');
        $this->phone = $env->get('PHONE');

        $this->apiUrl = $this->generateApiUrl();
    }

    private function generateApiUrl(): string{
        return "https://api.z-api.io/instances/{$this->apiInstance}/token/{$this->apiToken}/";
    }

    function sendReminder(Reminder $reminder): bool
    {
        try{
            $response = $this->makeRequest($reminder->getProcessedMessage());
          
            return $response['success'];
        }
        catch(Exception $e){
          
            return false;
        }
    }

    private function makeRequest(string $message)
    {
        $endpoint = 'send-text';

        $headers = [
            'Client-Token' => $this->apiClientToken,
            'Content-Type' => 'application/json'
        ];

        $body =  [
            'phone' => $this->phone,
            'message' => $message
        ];

        return $this->httpClient->post(
            $this->apiUrl . $endpoint,
            $headers,
            $body
        );
    }

    
}


