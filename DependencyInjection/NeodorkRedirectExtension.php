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

use Sonata\EasyExtendsBundle\Mapper\DoctrineCollector;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class NeodorkRedirectExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('manager.yml');
        $loader->load('admin.yml');

        $this->registerDoctrineMapping($config);
        $this->configureClass($config, $container);
        $this->configureAdmin($config, $container);
    }

    /**
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function configureClass($config, ContainerBuilder $container)
    {
        $container->setParameter('neodork.redirect.admin.redirect.entity',       $config['class']['redirect']);

        $container->setParameter('neodork.redirect.manager.redirect.entity',  $config['class']['redirect']);
    }

    /**
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function configureAdmin($config, ContainerBuilder $container)
    {
        $container->setParameter('neodork.redirect.admin.redirect.class',              $config['admin']['redirect']['class']);
        $container->setParameter('neodork.redirect.admin.redirect.controller',         $config['admin']['redirect']['controller']);
        $container->setParameter('neodork.redirect.admin.redirect.translation_domain', $config['admin']['redirect']['translation']);
    }

    /**
     * @param array $config
     */
    public function registerDoctrineMapping(array $config)
    {
        $collector = DoctrineCollector::getInstance();

        foreach ($config['class'] as $type => $class) {
            if (!class_exists($class)) {
                return;
            }
        }
    }
}
