<?php
/**
 * This file is part of the BEAR.Package package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Package\Dev\Application\Exception;

use RuntimeException;

/**
 * New URI file already exists
 */
class InvalidUri extends RuntimeException implements ExceptionInterface
{
}
