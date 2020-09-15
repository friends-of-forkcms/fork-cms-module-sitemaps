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
        $this->addModule('Sitemaps');
        $this->configureBackendNavigation();
        $this->configureBackendRights();

        // Import locale
        $this->importLocale(dirname(__FILE__) . '/Data/locale.xml');
    }

    private function configureBackendNavigation(): void
    {
        // Set navigation for "Modules"
        $navigationModulesId = $this->setNavigation(null, 'Modules');
        $this->setNavigation(
            $navigationModulesId,
            $this->getModule(),
            'sitemaps/index'
        );
    }

    private function configureBackendRights(): void
    {
        $this->setModuleRights(1, $this->getModule());

        $this->setActionRights(1, $this->getModule(), 'Generate');
        $this->setActionRights(1, $this->getModule(), 'Index');
    }
}
