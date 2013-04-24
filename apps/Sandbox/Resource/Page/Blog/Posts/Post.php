<?php

namespace Sandbox\Resource\Page\Blog\Posts;

use BEAR\Resource\AbstractObject as Page;
use BEAR\Sunday\Inject\ResourceInject;
use BEAR\Sunday\Annotation\Cache;
use Ray\Di\Di\Inject;

/**
 * BLog post page
 */
class Post extends Page
{
    use ResourceInject;

    /**
     * @var array
     */
    public $body = [
        'post' => [
            'title' => '',
            'body' => ''
        ],
    ];

    /**
     * @param int $id
     *
     * @Cache(5)
     */
    public function onGet($id)
    {
        $this['post'] = $this
            ->resource
            ->get
            ->uri('app://self/blog/posts')
            ->withQuery(
                ['id' => $id]
            )->eager
            ->request()
            ->body;
        return $this;
    }
}
