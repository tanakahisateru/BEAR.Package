<?php
/**
 * This file is part of the BEAR.Package package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Package\Provide\ConsoleOutput;

use Ray\Di\AbstractModule;

/**
 * Output console module
 */
class ConsoleOutputModule extends AbstractModule
{
    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('BEAR\Sunday\Extension\ConsoleOutput\ConsoleOutputInterface')->to(__NAMESPACE__ . '\ConsoleOutput');
    }
}
