# Fork CMS Sitemaps module

> The Sitemaps module lets you automatically generate a sitemapindex and all its sitemaps.

**Download:**
* [Module for Fork CMS 5.*](https://github.com/friends-of-forkcms/fork-cms-module-sitemaps/archive/master.zip)

**Features:**
* Creates a sitemap.xml and a file per sitemap-provider (like f.e.: Pages, Blog, Realizations, Jobs, ...).
* You can easily add custom modules to the sitemap generator

**Installation**
* Copy/paste this module to your fork cms.
* Add in `app/AppKernel`:
```php
new \Backend\Modules\Sitemaps\Sitemaps(),
new \JeroenDesloovere\SitemapBundle\SitemapBundle(),
```
* Install the module.
* Add in `.gitignore`:
```
sitemap.xml
sitemap_*_*.xml
```
* Add in `.htaccess`:
```
# allow sitemaps
RewriteRule ^sitemap.xml$ - [L]
RewriteRule ^sitemap_(.*)_(.*).xml$ - [L]
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

## How to generate the sitemaps?

`bin/console sitemap:generate`
> You can set a cronjob to execute this every hour or so.

## Contributing

It would be great if you could help us improve the module. GitHub does a great job in managing collaboration by providing different tools, the only thing you need is a [GitHub](https://github.com/) login.

* Use **Pull requests** to add or update code
* **Issues** for bug reporting or code discussions

More info on how to work with GitHub on [help.github.com](https://help.github.com).

## License

The module is licensed under MIT. In short, this license allows you to do everything as long as the copyright statement stays present.
