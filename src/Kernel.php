<?php

declare(strict_types=1);

namespace Foo\Bar;

use Foo\Bar\Symfony\AppBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Generator;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\Kernel as SymfonyKernel;

final class Kernel extends SymfonyKernel
{
    use MicroKernelTrait;

    public const string ConfigExtensions = '.{xml,yaml,yml}';

    /** @return Generator<Bundle> */
    public function registerBundles(): iterable
    {
        yield new DoctrineBundle();
        yield new FrameworkBundle();

        yield new AppBundle();
    }
}
