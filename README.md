Twig cache extension Bundle [![Build Status](https://travis-ci.org/EmanueleMinotto/TwigCacheBundle.svg)](https://travis-ci.org/EmanueleMinotto/TwigCacheBundle)
---------------------------

Symfony 2 Bundle for [asm89/twig-cache-extension](https://github.com/asm89/twig-cache-extension).

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require emanueleminotto/twig-cache-bundle
```

This command requires you to have [Composer](https://getcomposer.org/) installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding the following line in the `app/AppKernel.php`
file of your project:

```php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new EmanueleMinotto\TwigCacheBundle\TwigCacheBundle(),
        );
    }
}
```

Step 3: Configuration
---------------------

```yml
# app/config/config.yml
twig_cache:
    service: cache_service # instance of Doctrine\Common\Cache\Cache
```

Usage
-----

The default strategy is the `IndexedChainingCacheStrategy` so you can use directly this code in your [Twig](http://twig.sensiolabs.org/) templates.

```twig
{# delegate to lifetime strategy #}
{% cache 'v1/summary' {time: 300} %}
    {# heavy lifting template stuff here, include/render other partials etc #}
{% endcache %}

{# delegate to generational strategy #}
{% cache 'v1/summary' {gen: item} %}
    {# heavy lifting template stuff here, include/render other partials etc #}
{% endcache %}
```

Readings:

 * [Configuration Reference](https://github.com/EmanueleMinotto/TwigCacheBundle/tree/master/Resources/doc/configuration-reference.rst)
 * [Change caching strategy](https://github.com/EmanueleMinotto/TwigCacheBundle/tree/master/Resources/doc/strategies.rst)

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE
