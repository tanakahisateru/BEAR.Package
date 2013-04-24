<?php

namespace Sandbox\Resource\Page\Blog;

use BEAR\Resource\AbstractObject as Page;
use BEAR\Sunday\Inject\ResourceInject;
use BEAR\Sunday\Annotation;
use BEAR\Sunday\Annotation\Cache;

/**
 * Blog index page
 */
class Posts extends Page
{
    use ResourceInject;

    /**
     * @var array
     */
    public $body = [
        'posts' => ''
    ];

    /**
     * @Cache
     * @internal Cache "request", not the result of request. never changed.
     */
    public function onGet()
    {
        $this['posts'] = $this->resource
            ->get
            ->uri('app://self/blog/posts')
            ->request();

        return $this;
    }

    /**
     * @param int $id
     */
    public function onDelete($id)
    {
        // delete
        $this->resource
            ->delete
            ->uri('app://self/blog/posts')
            ->withQuery(['id' => $id])
            ->eager
            ->request();

        // redirect
        $this->headers['location'] = '/blog/posts';

        return $this;
    }
}
