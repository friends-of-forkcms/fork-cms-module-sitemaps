<?php

namespace Backend\Modules\Sitemaps\Actions;

use Backend\Core\Engine\Base\ActionIndex;
use Backend\Modules\Brands\Domain\Brand\BrandDataGrid;

final class Index extends ActionIndex
{
    public function execute(): void
    {
        parent::execute();
        $this->parse();
        $this->display();
    }
}
