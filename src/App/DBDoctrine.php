<?php

declare(strict_types=1);

namespace App;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;

/**
 * @mixin Connection
 */
class DBDoctrine
{
    private Connection $connection;
    public function __construct(protected Config $config)
    {
        try {
            $this->connection = DriverManager::getConnection($config->dbDoctrine);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->connection, $name], $arguments);
    }
}
