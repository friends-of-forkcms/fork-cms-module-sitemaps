<?php

namespace Backend\Modules\Sitemaps\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class SitemapsProviderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('sitemap.generator')) {
            return;
        }

        $container->get('sitemap.generator')->setUrl(
            $container->getParameter('site.protocol') . '://' . $container->getParameter('site.domain')
        );
    }
}
