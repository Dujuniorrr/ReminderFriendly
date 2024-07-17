<?php

namespace Tests\Unit\Infra\Http\Server;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Src\Infra\Http\Server\GuzzleHTTPClient;

class GuzzleHTTPClientTest extends TestCase
{
    protected GuzzleHTTPClient $httpClient;

    protected function setUp(): void
    {
        parent::setUp();

        $mockHandler = new MockHandler([
            new Response(200, [], '{"message": "Hello, world!"}'), // Resposta de sucesso
            new Response(404, [], '{"message": "Not Found"}'),     // Resposta de erro 404
            new RequestException("Error Communicating with Server", new \GuzzleHttp\Psr7\Request('GET', 'test')) // Exceção de requisição
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $this->httpClient = new GuzzleHTTPClient(['handler' => $handlerStack]);
    }

    public function testGetRequest()
    {
        $result = $this->httpClient->get('http://example.com');

        $this->assertEquals(200, $result['statusCode']);
        $this->assertJson($result['body']);
    }

    public function testPostRequest()
    {
        $body = ['key' => 'value'];
        $result = $this->httpClient->post('http://example.com', [], $body);

        $this->assertEquals(200, $result['statusCode']);
        $this->assertJson($result['body']);
    }

    public function testPutRequest()
    {
        $body = ['key' => 'value'];
        $result = $this->httpClient->put('http://example.com', [], $body);

        $this->assertEquals(200, $result['statusCode']);
        $this->assertJson($result['body']);
    }

    public function testDeleteRequest()
    {
        $result = $this->httpClient->delete('http://example.com');

        $this->assertEquals(200, $result['statusCode']);
        $this->assertJson($result['body']);
    }


    public function testPutRequestError()
    {
        $mockHandler = new MockHandler([
            new Response(404, [], '{"message": "Not Found"}'),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $this->httpClient = new GuzzleHTTPClient(['handler' => $handlerStack]);
        $body = ['key' => 'value'];
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Failed to request external resource');

        $this->httpClient->put('http://example.com/notfound', [], $body);
    }

    public function testDeleteRequestException()
    {
        $mockHandler = new MockHandler([
            new RequestException("Error Communicating with Server", new \GuzzleHttp\Psr7\Request('GET', 'test'))
        ]);
        
        $handlerStack = HandlerStack::create($mockHandler);

        $this->httpClient = new GuzzleHTTPClient(['handler' => $handlerStack]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Failed to request external resource');

        $this->httpClient->delete('http://example.com/error');
    }
}
