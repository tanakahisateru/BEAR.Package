<?php
/**
 * This file is part of the BEAR.Package package
 *
 * @package BEAR.Package
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Package\Provide\ResourceView;

use BEAR\Resource\AbstractObject as ResourceObject;
use BEAR\Resource\Link;
use BEAR\Resource\RenderInterface;
use BEAR\Resource\RequestInterface;
use Nocarrier\Hal;

/**
 * Request renderer
 *
 * @package    BEAR.Package
 * @subpackage View
 */
class HalRenderer implements RenderInterface
{
    /**
     * (non-PHPdoc)
     * @see BEAR\Resource.RenderInterface::render()
     */
    public function render(ResourceObject $ro)
    {
        // evaluate all request in body.
        $isArrayAccess = is_array($ro->body) || $ro->body instanceof \Traversable;
        if ($isArrayAccess) {
            $this->valuateElements($ro);
        }
        // HAL
        $data = $ro->body ? : [];
        if (is_scalar($data)) {
            $data = ['value' => $data];
        }
        $hal = $this->getHal($ro, $data);
        $ro->view = $hal->asJson(true);
        $ro->headers['content-type'] = 'application/hal+json; charset=UTF-8';

        return $ro->view;
    }

    /**
     * @param \BEAR\Resource\AbstractObject $ro
     */
    private function valuateElements(ResourceObject &$ro)
    {
        array_walk_recursive(
            $ro->body,
            function (&$element) {
                if ($element instanceof RequestInterface) {
                    /** @var $element callable */
                    $element = $element();
                }
            }
        );
    }

    /**
     * Return hal
     *
     * @param ResourceObject $ro
     * @param mixed          $data
     *
     * @return Hal
     * @throws \BEAR\Package\Provide\ResourceView\Exception\HrefNotFound
     */
    private function getHal(ResourceObject $ro, $data)
    {
        $hal = new Hal($ro->uri, $data);
        foreach ($ro->links as $rel => $link) {
            $title = (isset($link[Link::TITLE])) ? $link[Link::TITLE] : null;
            $attr = (isset($link[Link::TEMPLATED]) && $link[Link::TEMPLATED] === true) ? [Link::TEMPLATED => true] : [];
            if (isset($link[Link::HREF])) {
                $hal->addLink($rel, $link[Link::HREF], $title, $attr);
            } else {
                throw new Exception\HrefNotFound($rel);
            }
        }

        return $hal;
    }
}
