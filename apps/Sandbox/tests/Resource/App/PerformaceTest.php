<?php
namespace Sandbox\tests\Resource\App;

use Sandbox\Module\TestModule;
use Ray\Di\Injector;

class PerformanceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Resource client
     *
     * @var \BEAR\Resource\Resource
     */
    private $resource;

    protected function setUp()
    {
        parent::setUp();
        if (! $this->resource) {
            $this->resource = Injector::create([new TestModule])->getInstance('\BEAR\Resource\Resource');
        }
    }

    /**
     * page://self/blog/posts
     *
     * @test
     */
    public function resource()
    {
        // resource request
        $resource = $this->resource->get->uri('app://self/performance')->eager->request();
        $this->assertSame(200, $resource->code);

        return $resource;
    }

    /**
     * What does page have ?
     *
     * @depends resource
     */
    public function graph($resource)
    {
    }

    /**
     * Renderable ?
     *
     * @depends resource
     * @test
     */
    public function type($resource)
    {
        $this->assertInternalType('string', $resource->body);
    }

    /**
     * Renderable ?
     *
     * @depends resource
     */
    public function render($resource)
    {
    }

}
