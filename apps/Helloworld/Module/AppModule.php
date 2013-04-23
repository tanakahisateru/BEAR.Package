<?php
/**
 * @package    Sandbox
 * @subpackage Module
 */
namespace Helloworld\Module;

use Ray\Di\AbstractModule;
use BEAR\Package;
use BEAR\Package\Module;
use BEAR\Package\Provide as ProvideModule;
use BEAR\Sunday\Module as SundayModule;
use Ray\Di\Module\InjectorModule;
use BEAR\Package\Module\Package\PackageModule;

/**
 * Production module
 *
 * @package    Sandbox
 * @subpackage Module
 */
class AppModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        // di - application
        $this->bind('BEAR\Sunday\Extension\Application\AppInterface')->to('Helloworld\App');

        $this->install(new SundayModule\Framework\FrameworkModule);
        $this->install(new SundayModule\Constant\NamedModule(require __DIR__ . '/config.php'));
        $this->install(new InjectorModule($this));

    }
}
