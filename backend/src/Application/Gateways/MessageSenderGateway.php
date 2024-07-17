<?php

namespace Src\Application\Gateways;

use Src\Application\Enviroment\Env;
use Src\Application\Http\Server\HTTPClient;
use Src\Domain\Reminder;

/**
 * Interface MessageSenderGateway
 * 
 * Defines the contract for Message Senders gateway implementations.
 */
interface MessageSenderGateway
{
    /**
     * Constructor for the MessageSenderGateway interface.
     * 
     * @param HTTPClient $httpClient HTTP client for making requests
     * @param Env $env Environment configuration
     */
    public function __construct(HTTPClient $httpClient, Env $env);

    /**
     * Send a message with reminder.
     * 
     * @param Reminder $reminder The reminder with message to send
     * 
     * @return bool True if success, false otherwise
     */
    function sendReminder(Reminder $reminder): bool;
}
