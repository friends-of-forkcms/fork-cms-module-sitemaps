<?php

namespace Backend\Modules\Sitemaps\Actions;

use Backend\Core\Engine\Base\ActionIndex;
use Backend\Core\Engine\Model;

final class Generate extends ActionIndex
{
    public function execute(): void
    {
        parent::execute();

        try {
            $this->get('sitemap.generator')->generate();
        } catch (\Exception $e) {
            $this->redirect(Model::createUrlForAction('Index') . '&error=error-while-generating-sitemaps');
        }

        $this->redirect(Model::createUrlForAction('Index') . '&report=sitemaps-generated');
    }
}
