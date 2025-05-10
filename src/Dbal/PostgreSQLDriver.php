<?php

declare(strict_types=1);

namespace Foo\Bar\Dbal;

use Doctrine\DBAL\Driver\Middleware\AbstractDriverMiddleware;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\ServerVersionProvider;

final class PostgreSQLDriver extends AbstractDriverMiddleware
{
    public function getDatabasePlatform(ServerVersionProvider $versionProvider): PostgreSQLPlatform
    {
        return new PostgreSQLPlatform();
    }
}
