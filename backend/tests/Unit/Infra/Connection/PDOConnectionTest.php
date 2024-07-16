<?php
namespace Tests\Unit\Infra\Connection;

use PHPUnit\Framework\TestCase;
use Src\Infra\Connection\PDOConnection;
use Src\Infra\Enviroment\DotEnvAdapter;

class PDOConnectionTest extends TestCase
{
    public function testSuccessConnection()
    {
       $env = new DotEnvAdapter();
       $connection = new PDOConnection($env);

       $test = $connection->query('show tables');
       $this->assertIsArray($test);
    }
}
