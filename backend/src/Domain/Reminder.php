<?php

namespace Src\Domain;

use DateTime;
use Exception;

class Reminder
{
    private string $id;
    private bool $send;
    private DateTime $createdAt;

    public function __construct(
        readonly private string $originalMessage,
        readonly private string $processedMessage,
        readonly private DateTime $date,
        readonly private Character $character
    ) {
        $this->send = false;
        $this->createdAt = new DateTime('now');
    }

    public static function create(
        string $id,
        string $originalMessage,
        string $processedMessage,
        DateTime $date,
        Character $character,
        DateTime $createdAt,
        bool $send
    ): self {
        $instance = new self(
            $originalMessage,
            $processedMessage,
            $date,
            $character
        );
        $instance->createdAt = $createdAt;
        $instance->send = $send;
        $instance->id = $id;

        return $instance;
    }

    /**
     * Change the status of send
     *
     * @return void
     */
    public function send()
    {
        if ($this->send) throw new Exception('The reminder is already send');
        $this->send = true;
    }

    /**
     * Get the value of send
     */
    public function getSend()
    {
        return $this->send;
    }

    /**
     * Get the value of createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get the value of originalMessage
     */
    public function getOriginalMessage()
    {
        return $this->originalMessage;
    }

    /**
     * Get the value of processedMessage
     */
    public function getProcessedMessage()
    {
        return $this->processedMessage;
    }

    /**
     * Get the value of date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of character
     */
    public function getCharacter()
    {
        return $this->character;
    }
}
