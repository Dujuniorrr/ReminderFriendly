<?php

namespace Tests\Unit\Infra\Http\Request;

use PHPUnit\Framework\TestCase;
use Src\Infra\Http\Request\CreateReminderValidator;

class CreateReminderValidatorTest extends TestCase
{
    public function testCorrectValidation()
    {
        $validator = new CreateReminderValidator();
        $output = $validator->validate([
            'content' => 'Levar cachorro para passear amanhã às 09 horas',
            'characterId' => 1
        ]);
        $this->assertNull($output);
    }

    public function testMissingContent()
    {
        $validator = new CreateReminderValidator();
        $output = $validator->validate([
            'content' => null,
            'characterId' => 1
        ]);
        $this->assertIsObject($output);
        $this->assertArrayHasKey('errors', $output->data);
        $this->assertArrayHasKey('content', $output->data['errors']);
    }

    public function testMissingCharacterId()
    {
        $validator = new CreateReminderValidator();
        $output = $validator->validate([
            'content' => 'Levar cachorro para passear amanhã às 09 horas',
            'characterId' => null
        ]);
        $this->assertIsObject($output);
        $this->assertArrayHasKey('errors', $output->data);
        $this->assertArrayHasKey('characterId', $output->data['errors']);
    }

    public function testInvalidIdType()
    {
        $validator = new CreateReminderValidator();
        $output = $validator->validate([
            'content' => 'Levar cachorro para passear amanhã às 09 horas',
            'characterId' => []
        ]);
        $this->assertIsObject($output);
        $this->assertArrayHasKey('errors', $output->data);
        $this->assertArrayHasKey('characterId', $output->data['errors']);
    }

    public function testEmptyData()
    {
        $validator = new CreateReminderValidator();
        $output = $validator->validate([]);
        $this->assertIsObject($output);
        $this->assertArrayHasKey('errors', $output->data);
    }
}
