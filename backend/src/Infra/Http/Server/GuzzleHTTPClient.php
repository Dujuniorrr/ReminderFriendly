<?php

namespace Src\Infra\Http\Server;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Src\Application\Http\Server\HTTPClient;

class GuzzleHTTPClient implements HTTPClient
{
    protected Client $client;

    public function __construct(array $config = [])
    {
        $this->client = new Client($config);
    }

    public function get(string $url, array $headers = []): array
    {
        return $this->request('GET', $url, ['headers' => $headers]);
    }

    public function post(string $url, array $headers = [], $body = null): array
    {
        if (is_array($body)) {
            $options = [
                'headers' => $headers,
                'json' => $body, 
            ];
        } else {
            $options = [
                'headers' => $headers,
                'body' => $body, 
            ];
        }

        return $this->request('POST', $url, $options);
    }

    public function put(string $url, array $headers = [], $body = null): array
    {
        if (is_array($body)) {
            $options = [
                'headers' => $headers,
                'json' => $body, 
            ];
        } else {
            $options = [
                'headers' => $headers,
                'body' => $body, 
            ];
        }

        return $this->request('PUT', $url, $options);
    }

    public function delete(string $url, array $headers = []): array
    {
        return $this->request('DELETE', $url, ['headers' => $headers]);
    }

    private function request(string $method, string $url, array $options = []): array
    {
        try {
            $response = $this->client->request($method, $url, $options);
            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents(), true);
            $headers = $response->getHeaders();
            
            return [
                'statusCode' => $statusCode,
                'body' => $body,
                'headers' => $headers,
                'success' => ($statusCode >= 200 && $statusCode <= 299)
            ];
        } catch (RequestException $e) {
            throw new \Exception("Failed to request external resource");
        }
    }
}

?>
