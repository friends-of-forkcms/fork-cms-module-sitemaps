<?php

namespace Backend\Modules\Sitemaps\Providers;

use Backend\Modules\Pages\Engine\Model;
use Frontend\Core\Engine\Navigation;
use Frontend\Core\Language\Language;
use JeroenDesloovere\SitemapBundle\Item\ChangeFrequency;
use JeroenDesloovere\SitemapBundle\Provider\SitemapProvider;
use JeroenDesloovere\SitemapBundle\Provider\SitemapProviderInterface;

class PagesSitemapProvider extends SitemapProvider implements SitemapProviderInterface
{
    public function __construct()
    {
        parent::__construct('Pages');
    }

    public function createItems(): void
    {
        foreach (Language::getActiveLanguages() as $language) {
            $navigation = Navigation::getNavigation($language);

            /** @var string $navigationType - meta, root, page or footer*/
            foreach ($navigation as $navigationType => $items) {
                foreach ($items as $parentId => $children) {
                    foreach ($children as $pageId => $page) {
                        $pageInfo = Model::get($page['page_id']);
                        $lastModifiedOn = date_timestamp_set(new \DateTime(), (int) $pageInfo['edited_on']);
                        $priority = 9;
                        $changeFrequency = ChangeFrequency::weekly();

                        // Home page
                        if (in_array($pageId, [0, 1])) {
                            $priority = 10;
                            $changeFrequency = ChangeFrequency::always();
                        }

                        $this->createItem(
                            $page['full_url'],
                            $lastModifiedOn,
                            $changeFrequency,
                            $priority
                        );
                    }
                }
            }
        }
    }
}
