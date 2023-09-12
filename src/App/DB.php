<?php

declare(strict_types=1);

namespace App;

use PDO;

class DB
{
    private \PDO $PDO;

    /**
     * @return PDO
     */
    public function getPDO(): PDO
    {
        return $this->PDO;
    }

    public function __construct($config)
    {
        try {
            $defaultOptions = [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
            ;
            $this->PDO = new \PDO(
                'mysql:dbname=' . $config['dbname'] . ';host=localhost',
                $config['dbuser'],
                $config['dbpass'],
                $config['attr'] ?? $defaultOptions
            );
        } catch (\PDOException $exception) {
            throw new \PDOException($exception->getMessage() . (int) $exception->getCode());
        }
    }
}
