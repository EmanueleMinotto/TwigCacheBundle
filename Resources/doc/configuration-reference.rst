Default Bundle Configuration
============================

.. code-block:: yaml

    # app/config/config.yml
    twig_cache:
        profiler: '%kernel.debug%'
        service: # required
        strategy: twig_cache.strategy