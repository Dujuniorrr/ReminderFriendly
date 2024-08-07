<?php

namespace Tests\Unit\Infra\Gateway;

use Exception;
use PHPUnit\Framework\TestCase;
use Src\Application\Exceptions\NLPErrorException;
use Src\Infra\Enviroment\DotEnvAdapter;
use Src\Infra\Gateway\OpenAINLPGateway;
use Src\Infra\Http\Server\GuzzleHTTPClient;
use Src\Infra\Repository\MemoryCharacterRepository;

class OpenAINLPGatewayTest extends TestCase
{
    public function testPromptSuccess()
    {
        $httpClient = new GuzzleHTTPClient();

        $env = new DotEnvAdapter();
        $repository = new MemoryCharacterRepository();
        $gateway = new OpenAINLPGateway($httpClient, $env);

        $character = $repository->find('1');
        $output = $gateway->formatMessage('Treinar para a maratona de 5km na terça que vem, às 4 da tarde', $character);
        
        $this->assertIsString($output->processedMessage);
    }

    public function testPromptException()
    {
        $this->expectException(NLPErrorException::class);

        $httpClient = new GuzzleHTTPClient();

        $env = new DotEnvAdapter();
        $repository = new MemoryCharacterRepository();
        $gateway = new OpenAINLPGateway($httpClient, $env);

        $character = $repository->find('1');

        $output = $gateway->formatMessage('Levar o chachorro para passear', $character);
    }
}
