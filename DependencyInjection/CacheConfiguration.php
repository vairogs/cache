<?php declare(strict_types = 1);

namespace Vairogs\Component\Cache\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Vairogs\Bundle\DependencyInjection\Dependency;
use Vairogs\Bundle\VairogsBundle;

use function dirname;
use function sprintf;

final readonly class CacheConfiguration implements Dependency
{
    public function addSection(
        ArrayNodeDefinition $rootNode,
        callable $enableIfStandalone,
    ): void {
        $rootNode
            ->children()
            ->arrayNode(Dependency::COMPONENT_CACHE)
            ->{$enableIfStandalone(sprintf('%s/%s', VairogsBundle::VAIROGS, Dependency::COMPONENT_CACHE), self::class)}()
        ->end();
    }

    public function registerConfiguration(
        ContainerConfigurator $container,
        ContainerBuilder $builder,
    ): void {
        if (!VairogsBundle::enabled($builder, Dependency::COMPONENT_CACHE)) {
            return;
        }

        $container->import(dirname(__DIR__) . '/Resources/config/services.php');
    }
}
