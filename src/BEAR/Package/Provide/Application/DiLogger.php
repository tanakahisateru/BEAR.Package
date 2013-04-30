<?php
/**
 * This file is part of the BEAR.Package package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Package\Provide\Application;

use Ray\Aop\Bind;
use Ray\Di\LoggerInterface;

/**
 * Di logger
 */
class DiLogger implements LoggerInterface
{
    /**
     * @var string
     */
    private $logMessages = [];

    /**
     * log injection information
     *
     * @param string        $class
     * @param array         $params
     * @param array         $setter
     * @param object        $object
     * @param \Ray\Aop\Bind $bind
     */
    public function log($class, array $params, array $setter, $object, Bind $bind)
    {
        $toStr = function ($params) {
            foreach ($params as &$param) {
                if (is_object($param)) {
                    $param = get_class($param) . '#' . spl_object_hash($param);
                } elseif (is_callable($param)) {
                    $param = "(callable) {$param}";
                } elseif (is_scalar($param)) {
                    $param = '(' . gettype($param) . ') ' . (string)$param;
                } elseif (is_array($param)) {
                    $param = $str = str_replace(["\n", " "], '', print_r($param, true));
                }
            }
            return implode(', ', $params);
        };
        $constructor = $toStr($params);
        $constructor = $constructor ? $constructor : '';
        $setter = $setter ? "setter[" . implode(', ', array_keys($setter)) . ']' : '';
        $logMessage = "[DI] {$class} construct[$constructor] {$setter}";
        $this->logMessages[] = $logMessage;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode(PHP_EOL, $this->logMessages);
    }
}
