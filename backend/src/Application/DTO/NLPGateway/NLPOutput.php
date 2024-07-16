<?php

namespace Src\Application\DTO\NLPGateway;

use DateTime;

/**
 * Class NLPOutput
 * 
 * Data Transfer Object for the output of an NLP processing.
 */
class NLPOutput
{
    /**
     * @param string $processedMessage The processed message from the NLP gateway
     * @param DateTime $date The date extracted or determined by the NLP processing
     */
    public function __construct(
        readonly public string $processedMessage,
        readonly public DateTime $date
    ) {
    }
}
