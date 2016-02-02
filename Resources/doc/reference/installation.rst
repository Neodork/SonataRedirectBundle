Installation
============

* Add NeodorkSonataRedirectBundle to your projects:  ``composer.json``

.. code-block:: json

    //composer.json

    "require": {
        // ...
        "neodork/sonata-redirect-bundle": "~0.1",
        // ...
    }


* Add NeodorkSonataRedirectBundle to your application kernel:

.. code-block:: php

    // app/AppKernel.php

    public function registerBundles()
    {
        return array(
            // ... 
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
            new Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle(),
            new Neodork\SonataRedirectBundle\NeodorkSonataRedirectBundle(),
            // ...
        );
    }


* Create a configuration file called: ``neodork_redirect.yml``:

.. code-block:: yaml

    neodork_sonata_redirect:
        class:
            redirect: Application\Neodork\SonataRedirectBundle\Entity\Redirect
        admin:
            redirect:
                class: Neodork\SonataRedirectBundle\Admin\RedirectAdmin
                controller: SonataAdminBundle:CRUD
                translation: NeodorkRedirectBundle


    doctrine:
        orm:
            entity_managers:
                default:
                    // only needed if auto_mapping: false
                    mappings:
                        #ApplicationNeodorkSonataRedirectBundle: ~
                        NeodorkSonataRedirectBundle: ~

* Import the ``neodork_redirect.yml`` file and enable json type for doctrine:

.. code-block:: yaml

    imports:
        #...
        - { resource: neodork_redirect.yml }
        #...

    doctrine:
        dbal:
            # ...
            types:
                json: Sonata\Doctrine\Types\JsonType

* Run the sonata easy-extends command:

.. code-block:: bash

    php app/console sonata:easy-extends:generate NeodorkSonataRedirectBundle -d src

* Enable the new application bundle:

.. code-block:: php

    // app/AppKernel.php

    public function registerBundles()
    {
        return array(
            // ...
            new Application\Neodork\SonataRedirectBundle\ApplicationNeodorkSonataRedirectBundle(),
        );
    }