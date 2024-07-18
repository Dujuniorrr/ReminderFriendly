<?php

namespace Tests\Unit\Infra\Http\Request;

use PHPUnit\Framework\TestCase;
use Src\Infra\Http\Request\ListRemindersValidator;

class ListRemindersValidatorTest extends TestCase
{
    public function testValidationWithValidData()
    {
        $validator = new ListRemindersValidator();

        $queryParams = [
            'page' => '1',
            'limit' => '20',
            'status' => 'notSend',
        ];

        $validationResult = $validator->validate($queryParams);

        $this->assertNull($validationResult);
    }

    public function testValidationWithInvalidData()
    {
        $validator = new ListRemindersValidator();

        $queryParams = [
            'page' => '0',
            'limit' => '200',
            'status' => 'invalidStatus',
        ];

        $validationResult = $validator->validate($queryParams);

        $this->assertNotNull($validationResult);

        $expectedErrors = [
            'page' => ['validator'],
            'limit' => ['validator'],
            'status' => ['validator'],
        ];

        foreach ($expectedErrors as $field => $expectedRules) {
            $this->assertArrayHasKey($field, $validationResult->data['errors']);
            $this->assertEquals($expectedRules, array_keys($validationResult->data['errors'][$field]));
        }
    }

    public function testEmptyData()
    {
        $validator = new ListRemindersValidator();
        $output = $validator->validate([]);
        $this->assertNull($output);
    }
}
