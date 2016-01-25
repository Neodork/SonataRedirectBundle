<?php

/*
 * This file is part of the Neodork Sonata Redirect package.
 *
 * (c) Lou van der Laarse <neodork.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Neodork\SonataRedirectBundle\Entity;

use Neodork\SonataRedirectBundle\Model\Redirect;

abstract class BaseRedirect extends Redirect
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function prePersist()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime());
    }
}
