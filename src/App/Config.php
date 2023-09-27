<?php

declare(strict_types=1);

namespace App;

/**
 * @property-read ?array $db
 * @property-read ?array $mailer
 */
class Config
{
    protected array $config;
    public function __construct(array $env)
    {
        $this->config = [
            'db' => ['host' => $env['HOST'],
                    'dbuser' => $env['DB_USER'],
                    'dbname' => $env['DB_NAME'],
                    'dbpass' => $env['DB_PASS']
            ],
            'mailer' => ['dsn' => $env['MAILER_DSN']]
        ];
    }
    public function __get(string $name): array
    {
        return $this->config[$name] ?? [];
    }
}
