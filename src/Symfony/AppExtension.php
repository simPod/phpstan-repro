<?php

declare(strict_types=1);

namespace Foo\Bar\Symfony;

use Foo\Bar\Kernel;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\GlobFileLoader;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

use function assert;
use function is_dir;
use function is_string;

final class AppExtension extends Extension implements PrependExtensionInterface
{
    private const string PackagesDirectory = 'packages';
    private const string ServicesDirectory = 'services';

    /**
     * @throws DirectoryNotFoundException
     * @throws ParameterNotFoundException
     */
    public function prepend(ContainerBuilder $container): void
    {
        $this->doLoad(
            $container,
        );
    }

    /**
     * @param array<mixed> $configs
     *
     * @throws DirectoryNotFoundException
     * @throws ParameterNotFoundException
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
    }

    /**
     * @throws DirectoryNotFoundException
     * @throws ParameterNotFoundException
     */
    private function doLoad(ContainerBuilder $container): void
    {
        $environment = $container->getParameter('kernel.environment');
        assert(is_string($environment));
        $projectDir = $container->getParameter('kernel.project_dir');
        assert(is_string($projectDir));

        $srcDir = $projectDir . '/src';

        $loader = $this->getContainerLoader($environment, $srcDir, $container);

        $configDirectory = $srcDir . '/config';

        if (! is_dir($configDirectory)) {
            return;
        }

        foreach ([self::PackagesDirectory, self::ServicesDirectory] as $directory) {
            $dir = $configDirectory . ($directory === '' ? '' : '/' . $directory);

            $loader->load($dir . '/*' . Kernel::ConfigExtensions, 'glob');
        }
    }

    /**
     * @link \Symfony\Component\HttpKernel\Kernel::getContainerLoader()
     *
     * @throws ParameterNotFoundException
     */
    private function getContainerLoader(string $env, string $srcDir, ContainerBuilder $container): DelegatingLoader
    {
        $locator = new FileLocator($srcDir);
        $resolver = new LoaderResolver([
            new XmlFileLoader($container, $locator, $env),
            new YamlFileLoader($container, $locator, $env),
            new GlobFileLoader($container, $locator, $env),
        ]);

        return new DelegatingLoader($resolver);
    }
}
