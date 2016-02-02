Installation
============

* Add NeodorkSonataRedirectBundle to your vendor/bundles dir with the deps file:

.. code-block:: json

    //composer.json
    "require": {
        // ...
        "neodork/sonata-redirect-bundle": "~0.1",
        // ...
    }


* Add NeodorkSonataRedirectBundle to your application kernel:

.. code-block:: php

    <?php

    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\MarkItUpBundle\SonataMarkItUpBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new Sonata\NewsBundle\SonataNewsBundle(),
            new Sonata\UserBundle\SonataUserBundle(),
            new Sonata\MediaBundle\SonataMediaBundle(),
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\IntlBundle\SonataIntlBundle(),
            new Sonata\FormatterBundle\SonataFormatterBundle(),
            new Sonata\ClassificationBundle\SonataClassificationBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            // ...
        );
    }


* Create a configuration file : ``neodork_redirect.yml``:

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
                    mappings:
                        #ApplicationNeodorkSonataRedirectBundle: ~
                        NeodorkSonataRedirectBundle: ~

* import the ``neodork_redirect.yml`` file and enable json type for doctrine:

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

* Run the easy-extends command:

.. code-block:: bash

    php app/console sonata:easy-extends:generate NeodorkSonataRedirectBundle -d src

* Enable the new bundles:

.. code-block:: php

    <?php

    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new Application\Neodork\SonataRedirectBundle\ApplicationNeodorkSonataRedirectBundle(),
            // ...
        );
    }

Update database schema by running command ``php app/console doctrine:schema:update --force``

* Complete the FOS/UserBundle install and use the ``Application\Sonata\UserBundle\Entity\User`` as the user class

* Add SonataNewsBundle routes to your application routing.yml:

.. code-block:: yaml

    # app/config/routing.yml
    news:
        resource: '@SonataNewsBundle/Resources/config/routing/news.xml'
        prefix: /news
