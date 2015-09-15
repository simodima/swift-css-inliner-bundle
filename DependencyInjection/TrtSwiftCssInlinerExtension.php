<?php

namespace Trt\SwiftCssInlinerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class TrtSwiftCssInlinerExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter($this->getAlias().'.inliner_class', $config['inliner_class']);
        $container->setParameter($this->getAlias().'.cleanup', $config['cleanup']);
        $container->setParameter($this->getAlias().'.strip_original_style_tags', $config['strip_original_style_tags']);
        $container->setParameter($this->getAlias().'.exclude_media_queries', $config['exclude_media_queries']);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }
}
