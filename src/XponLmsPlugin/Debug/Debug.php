<?php /** @noinspection PhpUnused */


namespace XponLmsPlugin\Debug;


use Closure;
use ErrorException;

/**
 * Class Debug
 * @package XponLmsPlugin\Lib
 */
class Debug
{
    public static function setErrorHandler()
    {
        set_error_handler(self::returnErrorHandlerFunction());
    }

    /**
     * @return Closure
     */
    public static function returnErrorHandlerFunction()
    {
        return function ($severity, $message, $file, $line) {
            if (error_reporting() & $severity) {
                throw new ErrorException($message, 0, $severity, $file, $line);
            }
        };
    }

}
