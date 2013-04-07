<?php
/**
 * This file is part of the BEAR.Package package
 *
 * @package BEAR.Package
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Package\Provide\ApplicationLogger\ResourceLog;

use BEAR\Package\Provide\ApplicationLogger\ResourceLog\Writer\Collection;
use BEAR\Package\Provide\ApplicationLogger\ResourceLog\Writer\Fire;
use BEAR\Package\Provide\ApplicationLogger\ResourceLog\Writer\Zf2Log;
use BEAR\Package\Provide\ApplicationLogger\ResourceLog\Writer\Zf2LogProvider;
use BEAR\Sunday\Inject\LogDirInject;
use Ray\Di\ProviderInterface;
use Zend\Log\Logger;

/**
 * Writer provider
 *
 * @package    BEAR.Package
 * @subpackage Module
 */
class WritersProvider implements ProviderInterface
{

    use LogDirInject;

    /**
     * @return Writer\Collection|object
     */
    public function get()
    {
        $writers = new Collection(
            [
                new Fire,
                new Zf2Log(new Zf2LogProvider($this->logDir))
            ]
        );

        return $writers;
    }
}
