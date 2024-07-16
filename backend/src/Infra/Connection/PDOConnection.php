<?php

namespace Src\Infra\Connection;

use Exception;
use Src\Application\Connection\Connection;
use PDO;
use PDOException;
use Src\Application\Enviroment\Env;

class PDOConnection implements Connection
{
    private PDO $pdo;

    public function __construct(Env $env)
    {
        
        if($env->get('ENVIROMENT') == 'PROD' ){
            $dsn = "{$env->get('DB_CONNECTION')}:host={$env->get('DB_HOST')};dbname={$env->get('DB_DATABASE')};charset=utf8mb4";
        }
        else{
            $dsn = "{$env->get('DB_CONNECTION')}:host={$env->get('DB_HOST_LOCAL')};port={$env->get('DB_PORT')};dbname={$env->get('DB_DATABASE')};charset=utf8mb4";
        }
        $username = $env->get('DB_USERNAME');
        $password = $env->get('DB_PASSWORD');

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            $this->pdo = new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            throw new Exception("Failed to connect to database: " . $e->getMessage());
        }
    }


    public function query(string $statement, array $params = []): mixed
    {
        try {
            $stmt = $this->pdo->prepare($statement);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Query execution failed: " . $e->getMessage());
        }
    }

}
