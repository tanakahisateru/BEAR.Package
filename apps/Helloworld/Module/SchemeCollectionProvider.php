<?php

namespace Helloworld\Module;

use Ray\Di\ProviderInterface as Provide;
use BEAR\Resource\Adapter\App as AppAdapter;
use BEAR\Resource\SchemeCollection;
use BEAR\Sunday\Inject\AppNameInject;
use BEAR\Sunday\Inject\InjectorInject;

/**
 * Scheme collection provider
 */
class SchemeCollectionProvider implements Provide
{
    use AppNameInject;
    use InjectorInject;

    /**
     * Return resource adapter set.
     *
     * @return array
     */
    public function get()
    {
        $schemeCollection = new SchemeCollection;
        $pageAdapter = new AppAdapter($this->injector, $this->appName, 'Resource\Page');
        $appAdapter = new AppAdapter($this->injector, $this->appName, 'Resource\App');
        $schemeCollection->scheme('page')->host('self')->toAdapter($pageAdapter);
        $schemeCollection->scheme('app')->host('self')->toAdapter($appAdapter);
        return $schemeCollection;
    }
}
