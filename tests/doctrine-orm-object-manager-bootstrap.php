<?php

declare(strict_types=1);

namespace Foo\Bar;

use Symfony\Component\Runtime\SymfonyRuntime;

require __DIR__ . '/../vendor/autoload.php';

[$app, $args] = (new SymfonyRuntime())
    ->getResolver(static fn () => new Kernel('dev', true))
    ->resolve();

$kernel = $app(...$args);
$kernel->boot();

$managerRegistry = $kernel->getContainer()->get('doctrine');

return $managerRegistry->getManager();
