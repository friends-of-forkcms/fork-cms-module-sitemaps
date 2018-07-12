<?php

namespace Backend\Modules\Sitemaps;

use Backend\Modules\Sitemaps\DependencyInjection\Compiler\SitemapsCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Sitemaps bundle for Fork CMS
 */
class Sitemaps extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new SitemapsCompilerPass());
    }
}
