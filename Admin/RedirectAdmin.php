<?php

/*
 * This file is part of the Neodork Sonata Redirect package.
 *
 * (c) Lou van der Laarse <neodork.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Neodork\SonataRedirectBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

class SonataRedirectBundle extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('fromPath')
            ->add('toPath')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('fromPath', 'url')
            ->add('toPath', 'url')
            ->add('updatedAt')
            ->add('createdAt')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('fromPath')
            ->add('toPath')
            ->add('updatedAt')
            ->add('createdAt')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Redirect', array('class' => 'col-md-8'))
            ->add('fromPath', 'text')
            ->add('toPath', 'text')
            ->end()
            ->with('Options', array('class' => 'col-md-4'))
            ->add('name', null, array('required' => false))
            ->add('enabled', null, array('required' => false))
            ->end();
        ;
    }

    /**
     * @{inheritdoc}
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        // find object with toLink
        $fromPath = $this->modelManager->findOneBy($this->getClass(), array('fromPath' => $object->getFromPath()));

        // @formatter:off

        if (null !== $fromPath && $fromPath->getId() !== $object->getId()) {
            $errorElement
                ->with('fromPath')
                    ->addViolation('This link is already being redirected somewhere else!')
                ->end();
        }

        if(substr($object->getToPath(), 0, 1) !== '/'){
            $errorElement
                ->with('toPath')
                ->addViolation('Invalid path! A path start with a "/"')
                ->end();
        }

        if(substr($object->getFromPath(), 0, 1) !== '/'){
            $errorElement
                ->with('fromPath')
                ->addViolation('Invalid path! A path start with a "/"')
                ->end();
        }

         // @formatter:on
    }
}