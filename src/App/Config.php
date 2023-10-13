<?php

declare(strict_types=1);

namespace App;

/**
 * @property-read ?array $db
 * @property-read ?array $mailer
 * @property-read ?array $dbDoctrine
 * @property-read ?array dbEloquent
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
            'mailer' => ['dsn' => $env['MAILER_DSN']],
            'dbDoctrine' => ['host' => $env['HOST'],
                'user' => $env['DB_USER'],
                'dbname' => $env['DB_NAME'],
                'password' => $env['DB_PASS'],
                'driver' => 'pdo_mysql',
            ],
            'dbEloquent' => [
                'host' => $_ENV['HOST'],
                'username' => $_ENV['DB_USER'],
                'database' => $_ENV['DB_NAME'],
                'password' => $_ENV['DB_PASS'],
                'driver' => 'mysql',
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
            ]
        ];
    }
    public function __get(string $name): array
    {
        return $this->config[$name] ?? [];
    }
}
