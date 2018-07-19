# Fork CMS Sitemaps module

> The Sitemaps module lets you automatically generate a sitemapindex and all its sitemaps.

**Download:**
* [Module for Fork CMS 5.*](https://github.com/friends-of-forkcms/fork-cms-module-sitemaps/archive/master.zip)

**Features:**
* Creates a sitemap.xml and a file per sitemap-provider (like f.e.: Pages, Blog, Realizations, Jobs, ...).
* You can easily add custom modules to the sitemap generator.
* There is a re-generate button in the backend, so you can regenerate all sitemaps.

**Installation**
* Execute `composer install jeroendesloovere/sitemap-bundle`
* Then copy/paste this module to your fork cms.
* Add in `app/AppKernel`:
```php
new \Backend\Modules\Sitemaps\Sitemaps(),
new \JeroenDesloovere\SitemapBundle\SitemapBundle(),
```
* Install the module.
* Add in `.gitignore`:
```
sitemap.xml
sitemap_*.xml
```
* Add in `.htaccess`:
```
# allow sitemaps
RewriteRule ^sitemap.xml$ - [L]
RewriteRule ^sitemap_(.*).xml$ - [L]
```
* Add in composer.json for `post-update-cmd`:
```
"php bin/console sitemap:generate"
```
* If you are using capistrano to deploy, add the following to `deploy.rb`:
```ruby
## Generate sitemap
namespace :sitemap do
  desc "Generate the sitemap.xml and sitemap files per provider."
  task :generate do
    on roles(:db) do
      execute "cd #{current_path} && bin/console sitemap:generate"
    end
  end
end

before "deploy:cleanup", "sitemap:generate"
after "deploy:rollback", "sitemap:generate"
```

### Example: "How to create your custom sitemap?"

We need to notify Symfony that we have a new sitemap provider.
Add the following somewhere in your `services.yaml`
```yaml
services:
    App\SitemapProviders\NewsArticleSitemapProvider:
        tags:
            - { name: sitemap.provider }
```

When the `SitemapGenerator` needs to generate the sitemap(s),
it will ask all SitemapProviders to fill in the items.
Create something like the following in your app.
```php
<?php

namespace App\SitemapProviders;

use JeroenDesloovere\SitemapBundle\Item\ChangeFrequency;
use JeroenDesloovere\SitemapBundle\Provider\SitemapProvider;
use JeroenDesloovere\SitemapBundle\Provider\SitemapProviderInterface;

class NewsArticleSitemapProvider extends SitemapProvider implements SitemapProviderInterface
{
    /** @var NewsArticleRepository */
    private $articleRepository;

    public function __construct(NewsArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;

        // `NewsArticle::class` would even be better then just `NewsArticle`
        // because you can then use it with doctrine events.
        parent::__construct('NewsArticle');
    }

    public function createItems(): void
    {
        /** @var Article[] $articles */
        $articles = $this->articleRepository->findAll();
        foreach ($articles as $article) {
            $this->createItem('/nl/xxx/url-to-article', $article->getEditedOn(), ChangeFrequency::monthly());
        }
    }
}
```

[View more examples over here](https://github.com/jeroendesloovere/sitemap-bundle)

## How to generate the sitemaps?

You can now generate the sitemap(s) by executing:
```bash
bin/console sitemap:generate
```
> Use a cronjob (f.e. every hour) to have up-to-date sitemaps.

OR if you want to use PHP
```php
$this->getContainer()->get('sitemap.generator')->generate();
```

## Contributing

It would be great if you could help us improve the module. GitHub does a great job in managing collaboration by providing different tools, the only thing you need is a [GitHub](https://github.com/) login.

* Use **Pull requests** to add or update code
* **Issues** for bug reporting or code discussions

More info on how to work with GitHub on [help.github.com](https://help.github.com).

## License

The module is licensed under MIT. In short, this license allows you to do everything as long as the copyright statement stays present.
