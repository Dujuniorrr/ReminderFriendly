<?php

namespace Tests\Unit\Infra\Http\Request;

use PHPUnit\Framework\TestCase;
use Src\Infra\Http\Request\ListCharactersValidator;

class ListCharactersValidatorTest extends TestCase
{
    public function testValidationWithValidData()
    {
        $validator = new ListCharactersValidator();

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
        $validator = new ListCharactersValidator();

        $queryParams = [
            'page' => '0',
            'limit' => '200',
        ];

        $validationResult = $validator->validate($queryParams);

        $this->assertNotNull($validationResult);

        $expectedErrors = [
            'page' => ['validator'],
            'limit' => ['validator'],
        ];

        foreach ($expectedErrors as $field => $expectedRules) {
            $this->assertArrayHasKey($field, $validationResult->data['errors']);
            $this->assertEquals($expectedRules, array_keys($validationResult->data['errors'][$field]));
        }
    }

    public function testEmptyData()
    {
        $validator = new ListCharactersValidator();
        $output = $validator->validate([]);
        $this->assertNull($output);
    }
}
