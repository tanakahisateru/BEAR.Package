<?php
/**
 * This file is part of the BEAR.Package package
 *
 * @package BEAR.Package
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Package\Dev\Debug\ExceptionHandle;

use Exception;

/**
 * Interface for exception handler
 *
 * @package    BEAR.Package
 * @subpackage Dev
 */
interface ExceptionHandlerInterface
{
    /**
     * Handle exception
     *
     * @param Exception $e
     */
    public function handle(Exception $e);
}
