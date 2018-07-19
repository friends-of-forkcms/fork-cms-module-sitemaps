<?php

namespace Backend\Modules\Sitemaps\Actions;

use Backend\Core\Engine\Base\ActionIndex;

final class Index extends ActionIndex
{
    public function execute(): void
    {
        parent::execute();
        $this->parse();
        $this->display();
    }
}
