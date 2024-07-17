<?php

namespace Tests\Integration\Application\Command;

use Exception;
use PHPUnit\Framework\TestCase;
use Src\Application\Enviroment\Env;
use Src\Infra\Connection\PDOConnection;
use Src\Infra\Enviroment\DotEnvAdapter;
use Src\Application\Commands\ListCharacters;
use Src\Infra\Repository\DatabaseCharacterRepository;
use Src\Application\DTO\ListCharacters\ListCharactersInput;
use Src\Application\DTO\ListCharacters\ListCharactersOutput;

class ListCharactersTest extends TestCase
{
    private Env $fakeEnv;

    public function setUp(): void
    {
        $this->fakeEnv = new class extends DotEnvAdapter
        {
            public function get(string $key, mixed $default = null): mixed
            {
                $val = parent::get($key, $default);
                return ($key == 'ENVIROMENT') ? 'local' : $val;
            }
        };
    }

    public function testSuccessListOfCharacters()
    {
        $connection = new PDOConnection($this->fakeEnv);
        $characterRepository = new DatabaseCharacterRepository($connection);

        $command = new ListCharacters($characterRepository);

        $input = new ListCharactersInput(1, 20);

        list($output, $total) = $command->execute($input);

        $this->assertIsArray($output);
        $this->assertIsInt($total);

        foreach ($output as $item) {
            $this->assertInstanceOf(ListCharactersOutput::class, $item);
            $this->assertObjectHasProperty('id', $item);
            $this->assertObjectHasProperty('name', $item);
            $this->assertObjectHasProperty('humor', $item);
            $this->assertObjectHasProperty('role', $item);
            $this->assertObjectHasProperty('ageVitality', $item);
            $this->assertObjectHasProperty('origin', $item);
            $this->assertObjectHasProperty('speechMannerisms', $item);
            $this->assertObjectHasProperty('accent', $item);
            $this->assertObjectHasProperty('archetype', $item);
            $this->assertObjectHasProperty('imagePath', $item);
        }
    }

}

?>
