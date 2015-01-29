Change caching strategy
=======================

The default strategy is ``twig_cache.strategy`` that is an ``IndexedChainingCacheStrategy`` configured following the `Setup section`_.

It can be changed to ``twig_cache.strategy.generational`` that is an ``GenerationalCacheStrategy`` or to ``twig_cache.strategy.lifetime`` that is an ``LifetimeCacheStrategy``.


Implement your strategy
-----------------------

To implement your strategy read the `Implementing a cache strategy`_ section and create a service based on it:

.. code-block:: yaml

    # app/config/services.yml
    acme.twig.strategy.custom:
        class: Acme\Twig\CacheExtension\CacheStrategy\CustomStrategy
        arguments:
        - '@twig_cache.adapter'
        public: false

and use it in the ``twig_cache`` configuration

.. code-block:: yaml

    # app/config/config.yml
    twig_cache:
        service: test_cache
        strategy: acme.twig.strategy.custom


.. _`Setup section`: https://github.com/asm89/twig-cache-extension#setup-2
.. _`Implementing a cache strategy`: https://github.com/asm89/twig-cache-extension#implementing-a-cache-strategy