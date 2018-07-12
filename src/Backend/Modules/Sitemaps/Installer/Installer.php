<?php

namespace Backend\Modules\Sitemaps\Installer;

use Backend\Core\Installer\ModuleInstaller;

/**
 * Installer for the sitemaps module
 */
class Installer extends ModuleInstaller
{
    public function install(): void
    {
        $this->addModule('Sitemap');
    }
}
