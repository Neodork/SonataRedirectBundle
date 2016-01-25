<?php

/*
 * This file is part of the Neodork Sonata Redirect package.
 *
 * (c) Lou van der Laarse <neodork.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Neodork\SonataRedirectBundle\Model;

interface RedirectInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * Set title.
     *
     * @param string $title
     */
    public function setName($title);

    /**
     * Get title.
     *
     * @return string $title
     */
    public function getName();

    /**
     * Set enabled.
     *
     * @param bool $enabled
     */
    public function setEnabled($enabled);

    /**
     * Get enabled.
     *
     * @return bool $enabled
     */
    public function getEnabled();

    /**
     * Set fromPath.
     *
     * @param string $link
     */
    public function setFromPath($path);

    /**
     * Get fromPath.
     *
     * @return string $link
     */
    public function getFromPath();

    /**
     * Set toPath.
     *
     * @param string $link
     */
    public function setToPath($path);

    /**
     * Get toPath.
     *
     * @return string $path
     */
    public function getToPath();

    /**
     * Set created_at.
     *
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt = null);

    /**
     * Get created_at.
     *
     * @return \DateTime $createdAt
     */
    public function getCreatedAt();

    /**
     * Set updated_at.
     *
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt = null);

    /**
     * Get updated_at.
     *
     * @return \Datetime $updatedAt
     */
    public function getUpdatedAt();
}
