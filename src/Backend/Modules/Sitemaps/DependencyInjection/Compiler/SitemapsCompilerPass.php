<?php

namespace Backend\Modules\Sitemaps\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class SitemapsCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('sitemap.generator')) {
            return;
        }

        $container->setParameter('router.request_context.host', $container->getParameter('site.domain'));
        $container->setParameter('router.request_context.scheme', $container->getParameter('site.protocol'));
        $container->setParameter('router.request_context.base_url', '');
        $container->setParameter('asset.request_context.base_path', $container->getParameter('router.request_context.base_url'));
        $container->setParameter('asset.request_context.secure', true);
    }
}
