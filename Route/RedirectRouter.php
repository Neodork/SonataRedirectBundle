<?php

/*
 * This file is part of the Neodork Sonata Redirect package.
 *
 * (c) Lou van der Laarse <neodork.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Neodork\SonataRedirectBundle\Route;

use Neodork\SonataRedirectBundle\Model\RedirectInterface;
use Neodork\SonataRedirectBundle\Model\RedirectManagerInterface;
use Symfony\Cmf\Component\Routing\ChainedRouterInterface;
use Symfony\Cmf\Component\Routing\VersatileGeneratorInterface;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class RedirectRouter implements ChainedRouterInterface
{

    /**
     * @var RequestContext
     */
    protected $context;

    /**
     * @var RedirectManagerInterface
     */
    protected $redirectManager;

    /**
     * @var RouterInterface
     */
    protected $router;


    public function __construct(RedirectManagerInterface $redirectManager, RouterInterface $router)
    {
        $this->redirectManager = $redirectManager;
        $this->router = $router;
    }

    public function supports($name)
    {
        if (is_string($name)) {
            return false;
        }

        if (is_object($name) && !($name instanceof RedirectInterface)) {
            return false;
        }

        return true;
    }

    public function getRouteDebugMessage($name, array $parameters = array())
    {
        if ($this->router instanceof VersatileGeneratorInterface) {
            return $this->router->getRouteDebugMessage($name, $parameters);
        }

        return "Route '$name' not found";
    }

    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        throw new RouteNotFoundException('Implement generate() method');
    }

    public function setContext(RequestContext $context)
    {
        $this->context = $context;
    }

    public function getContext()
    {
        return $this->context;
    }

    public function getRouteCollection()
    {
        return new RouteCollection();
    }

    public function match($pathinfo)
    {
        $redirect = $this->redirectManager->findOneBy(array('fromPath' => $pathinfo));

        if ($redirect === null) {
            throw new ResourceNotFoundException('Redirect not found!');
        }

        return array (
            '_controller' => 'NeodorkRedirectBundle:Redirect:redirect',
            '_route'      => '_redirected',
            'redirect'    => $redirect,
            'url'        => $this->decorateUrl($redirect->getToPath(), array(), self::ABSOLUTE_PATH, true),
            'params'      => array()
        );
    }

    /**
     * Method from Sonata Page Bundle code! Slightly modified
     *
     * Decorates an URL with url context and query
     *
     * @param string      $url           Relative URL
     * @param array       $parameters    An array of parameters
     * @param bool|string $referenceType The type of reference to be generated (one of the constants)
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected function decorateUrl($url, array $parameters = array(), $referenceType = self::RELATIVE_PATH, $baseUrl = false)
    {
        if (!$this->context) {
            throw new \RuntimeException('No context associated to the CmsPageRouter');
        }

        $schemeAuthority = '';
        if ($this->context->getHost() && (self::ABSOLUTE_URL === $referenceType || self::NETWORK_PATH === $referenceType)) {
            $port = '';
            if ('http' === $this->context->getScheme() && 80 != $this->context->getHttpPort()) {
                $port = sprintf(':%s', $this->context->getHttpPort());
            } elseif ('https' === $this->context->getScheme() && 443 != $this->context->getHttpsPort()) {
                $port = sprintf(':%s', $this->context->getHttpsPort());
            }

            $schemeAuthority = self::NETWORK_PATH === $referenceType ? '//' : sprintf('%s://', $this->context->getScheme());
            $schemeAuthority = sprintf('%s%s%s', $schemeAuthority, $this->context->getHost(), $port);
        }

        if (self::RELATIVE_PATH === $referenceType) {
            $url = $this->getRelativePath($this->context->getPathInfo(), $url);
        } else {
            if($baseUrl){
                $url = sprintf('%s%s%s', $schemeAuthority, $this->context->getBaseUrl(), $url);
            }else{
                $url = sprintf('%s%s', $schemeAuthority, $url);
            }
        }

        if (count($parameters) > 0) {
            return sprintf('%s?%s', $url, http_build_query($parameters, '', '&'));
        }

        return $url;
    }

    /**
     * Returns the target path as relative reference from the base path.
     *
     * @param string $basePath   The base path
     * @param string $targetPath The target path
     *
     * @return string The relative target path
     */
    protected function getRelativePath($basePath, $targetPath)
    {
        return UrlGenerator::getRelativePath($basePath, $targetPath);
    }
}
