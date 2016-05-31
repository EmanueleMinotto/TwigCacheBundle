Twig cache extension Bundle
===========================

[![Build Status](https://img.shields.io/travis/EmanueleMinotto/TwigCacheBundle.svg?style=flat)](https://travis-ci.org/EmanueleMinotto/TwigCacheBundle)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/010b231e-0e35-4ba8-9929-eb48e77331b2.svg?style=flat)](https://insight.sensiolabs.com/projects/010b231e-0e35-4ba8-9929-eb48e77331b2)
[![Coverage Status](https://img.shields.io/coveralls/EmanueleMinotto/TwigCacheBundle.svg?style=flat)](https://coveralls.io/r/EmanueleMinotto/TwigCacheBundle)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/EmanueleMinotto/TwigCacheBundle.svg?style=flat)](https://scrutinizer-ci.com/g/EmanueleMinotto/TwigCacheBundle/)
[![Total Downloads](https://img.shields.io/packagist/dt/emanueleminotto/twig-cache-bundle.svg?style=flat)](https://packagist.org/packages/emanueleminotto/twig-cache-bundle)

Symfony Bundle for [asm89/twig-cache-extension](https://github.com/asm89/twig-cache-extension).

API: [emanueleminotto.github.io/TwigCacheBundle](http://emanueleminotto.github.io/TwigCacheBundle/)

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
Another option is to configure one of the PSR-6 Cache pool implementations 
by changing the default adapter class to the `PsrCacheAdapter`. 
```yml
# parameters.yml
twig_cache.adapter.class: Asm89\Twig\CacheExtension\CacheProvider\PsrCacheAdapter
```
After that any cache pool that implements the `CacheItemPoolInterface` is 
supported. The [`CacheBundle`](https://github.com/php-cache/cache-bundle) will
allow you to configure the cache pool of your choice. List of predefined pools 
can be found at: [http://php-cache.readthedocs.io/](http://php-cache.readthedocs.io/)

```yml
# config.yml
cache_adapter:
    providers:
        twig_apcu:
            factory: 'cache.factory.apcu'

twig_cache:
    service: cache.provider.twig_apcu
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
 * [Profiler](https://github.com/EmanueleMinotto/TwigCacheBundle/tree/master/Resources/doc/profiler.rst)

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE
