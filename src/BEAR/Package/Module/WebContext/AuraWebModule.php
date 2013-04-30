<?php
/**
 * This file is part of the BEAR.Package package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Package\Module\WebContext;

use Ray\Di\AbstractModule;
use Ray\Di\Scope;

/**
 * Aura.Web Context module
 */
class AuraWebModule extends AbstractModule
{
    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->bind('Ray\Di\ProviderInterface')
            ->annotatedWith('webContext')
            ->to('BEAR\Sunday\Module\Provider\WebContextProvider')
            ->in(Scope::SINGLETON);
    }
}
