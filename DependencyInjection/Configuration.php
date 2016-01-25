<?php

/*
 * This file is part of the Neodork Sonata Redirect package.
 *
 * (c) Lou van der Laarse <neodork.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Neodork\SonataRedirectBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('neodork_sonata_redirect');

        // @formatter:off
        $rootNode
            ->children()
                ->arrayNode('class')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('redirect')->defaultValue('Application\\Neodork\\SonataRedirectBundle\\Entity\\Redirect')->end()
                    ->end()
                ->end()
                ->arrayNode('admin')
                ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('redirect')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('class')->cannotBeEmpty()->defaultValue('Neodork\\SonataRedirectBundle\\Admin\\RedirectAdmin')->end()
                            ->scalarNode('controller')->cannotBeEmpty()->defaultValue('SonataAdminBundle:CRUD')->end()
                            ->scalarNode('translation')->cannotBeEmpty()->defaultValue('NeodorkRedirectBundle')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        // @formatter:on

        return $treeBuilder;
    }
}
