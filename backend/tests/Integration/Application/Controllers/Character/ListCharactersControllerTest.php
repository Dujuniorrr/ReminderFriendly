<?php

namespace Tests\Integration\Application\Controllers;

use PHPUnit\Framework\TestCase;
use Src\Application\Commands\ListCharacters;
use Src\Application\Http\Controller\Character\ListCharactersController;
use Src\Infra\Connection\PDOConnection;
use Src\Infra\Repository\DatabaseCharacterRepository;
use Src\Application\Enviroment\Env;
use Src\Infra\Enviroment\DotEnvAdapter;
use Src\Infra\Http\Request\ListCharactersValidator;

class ListCharactersControllerTest extends TestCase
{
    private Env $fakeEnv;
    private PDOConnection $connection;
    private DatabaseCharacterRepository $characterRepository;
    private ListCharactersController $controller;

    public function setUp(): void
    {
        $this->fakeEnv = new class extends DotEnvAdapter
        {
            public function get(string $key, mixed $default = null): mixed
            {
                $val = parent::get($key, $default);
                return ($key === 'ENVIROMENT') ? 'local' : $val;
            }
        };

        $this->connection = new PDOConnection($this->fakeEnv);
        $this->characterRepository = new DatabaseCharacterRepository($this->connection);
        $validator = new ListCharactersValidator();
        $listCharacters = new ListCharacters($this->characterRepository);
        $this->controller = new ListCharactersController($listCharacters, $validator);
    }

    public function testSuccessfulCharacterList()
    {
        $params = ['page' => 1, 'limit' => 10];
        $body = [];
        $response = $this->controller->handle($params, $body);

        $this->assertEquals(200, $response->status);
        $this->assertIsArray($response->data);
        $this->assertArrayHasKey('characters', $response->data);
        $this->assertArrayHasKey('total', $response->data);
        $this->assertArrayHasKey('perPage', $response->data);
        $this->assertArrayHasKey('currentPage', $response->data);

        $characters = $response->data['characters'];
        $this->assertIsInt(10, count($characters)); 
        foreach ($characters as $character) {
            $this->assertIsArray($character);
            $this->assertArrayHasKey('id', $character);
            $this->assertArrayHasKey('name', $character);
            $this->assertArrayHasKey('humor', $character);
            $this->assertArrayHasKey('role', $character);
            $this->assertArrayHasKey('ageVitality', $character);
            $this->assertArrayHasKey('origin', $character);
            $this->assertArrayHasKey('speechMannerisms', $character);
            $this->assertArrayHasKey('accent', $character);
            $this->assertArrayHasKey('archetype', $character);
            $this->assertArrayHasKey('imagePath', $character);
        }
    }
}
