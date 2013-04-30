<?php
/**
 * Global namespace debug function for short cut typing
 */
use BEAR\Package\Dev\Debug\Debug;
use BEAR\Package\Dev\Debug\Exception\Debug as DebugException;

/**
 * Throw exception
 *
 * @param null $var
 * @param int  $level
 *
 * @throws BEAR\Package\Dev\Debug\Exception\Debug
 */
function e($var = null, $level = 2)
{
    if (!is_null($var)) {
        Debug::printR(debug_backtrace(), $var, $level);
    }
    throw new DebugException;
}
