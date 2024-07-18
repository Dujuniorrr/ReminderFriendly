<?php

namespace Src\Application\Connection;

/**
 * Interface Connection
 * 
 * Represents a database connection.
 */
interface Connection
{
    /**
     * Executes a database query.
     *
     * @param string $statement The SQL statement to execute.
     * @param array $params Optional parameters for the SQL statement.
     * 
     * @return mixed The result of the query.
     */
    function query(string $statement, array $params = []): mixed;

    /**
     * Retrieve last id inserted in database.
     *
     * @return string Last id inserted.
     */
    public function lastInsertId(): string;
}
