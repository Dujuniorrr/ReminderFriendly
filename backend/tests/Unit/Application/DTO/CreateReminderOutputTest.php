<?php

namespace Tests\Unit\Application\DTO;

use DateTime;
use PHPUnit\Framework\TestCase;
use Src\Application\DTO\CreateReminder\CreateReminderOutput;

class CreateReminderOutputTest extends TestCase
{
    public function testToArrayReturnArray()
    {
        $output = new CreateReminderOutput(
            '',
            '',
            '',
            '',
            '',
            true
        );
        $this->assertIsArray($output->toArray());
    }

    public function testToArrayHasCorrectKeys()
    {
        $dto = new CreateReminderOutput(
            '',
            '',
            '',
            '',
            '',
            true
        );
        $output = $dto->toArray();
        $this->assertArrayHasKey('originalMessage', $output);
        $this->assertArrayHasKey('processedMessage', $output);
        $this->assertArrayHasKey('date', $output);
        $this->assertArrayHasKey('createdAt', $output);
    }
}
