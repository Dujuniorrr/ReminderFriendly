<?php

namespace Src\Application\Gateways;

use Src\Application\DTO\NLPGateway\NLPOutput;
use Src\Application\Enviroment\Env;
use Src\Application\Http\Server\HTTPClient;
use Src\Domain\Character;


/**
 * Interface NLPGateway
 * 
 * Defines the contract for NLP gateway implementations.
 */
interface NLPGateway
{
    /**
     * Constructor for the NLPGateway interface.
     * 
     * @param HTTPClient $httpClient HTTP client for making requests
     * @param Env $env Environment configuration
     */
    public function __construct(HTTPClient $httpClient, Env $env);

    /**
     * Formats a message using NLP processing.
     * 
     * @param string $message The message to be processed
     * @param Character $character The character context for processing
     * 
     * @return NLPOutput The processed message and associated data
     */
    function formatMessage(string $message, Character $character): NLPOutput;
}
