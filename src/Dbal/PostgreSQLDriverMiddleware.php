<?php

declare(strict_types=1);

namespace Foo\Bar\Dbal;

use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Driver\Middleware;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;

#[Autoconfigure(public: true)]
final class PostgreSQLDriverMiddleware implements Middleware
{
    public function wrap(Driver $driver): Driver
    {
        return new PostgreSQLDriver($driver);
    }
}
