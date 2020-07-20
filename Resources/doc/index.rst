Twig cache extension Bundle
===========================

Symfony 2 Bundle for `twigphp/twig-cache-extension`_.

API: `emanueleminotto.github.io/TwigCacheBundle`_

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:

.. code:: bash

    $ composer require emanueleminotto/twig-cache-bundle

This command requires you to have `Composer`_ installed globally, as explained in the `installation chapter`_ of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding the following line in the ``app/AppKernel.php`` file of your project:

.. code:: php

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

Step 3: Configuration
---------------------

.. code:: yml

    # app/config/config.yml
    twig_cache:
        service: cache_service # instance of Doctrine\Common\Cache\Cache

Usage
-----

The default strategy is the ``IndexedChainingCacheStrategy`` so you can
use directly this code in your `Twig`_ templates.

.. code:: twig

    {# delegate to lifetime strategy #}
    {% cache 'v1/summary' {time: 300} %}
        {# heavy lifting template stuff here, include/render other partials etc #}
    {% endcache %}

    {# delegate to generational strategy #}
    {% cache 'v1/summary' {gen: item} %}
        {# heavy lifting template stuff here, include/render other partials etc #}
    {% endcache %}

Readings:

-  `Configuration Reference`_
-  `Change caching strategy`_
-  `Profiler`_

.. _twigphp/twig-cache-extension: https://github.com/twigphp/twig-cache-extension
.. _emanueleminotto.github.io/TwigCacheBundle: http://emanueleminotto.github.io/TwigCacheBundle/
.. _Composer: https://getcomposer.org/
.. _installation chapter: https://getcomposer.org/doc/00-intro.md
.. _Twig: http://twig.sensiolabs.org/
.. _Configuration Reference: https://github.com/EmanueleMinotto/TwigCacheBundle/tree/master/Resources/doc/configuration-reference.rst
.. _Change caching strategy: https://github.com/EmanueleMinotto/TwigCacheBundle/tree/master/Resources/doc/strategies.rst
.. _Profiler: https://github.com/EmanueleMinotto/TwigCacheBundle/blob/master/Resources/doc/profiler.rst

License
-------

This bundle is under the MIT license. See the complete license in the
bundle:

::

    Resources/meta/LICENSE
