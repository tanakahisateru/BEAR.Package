<?php
namespace Sandbox\Resource\Page\Hello;

use BEAR\Resource\AbstractObject as Page;

/**
 * Hello World page
 */
class World extends Page
{
    public $body = [
        'greeting' => ''
    ];

    /**
     * @param string $name
     */
    public function onGet($name = "BEAR")
    {
        $this['greeting'] = "Hello " . $name;
        return $this;
    }
}
