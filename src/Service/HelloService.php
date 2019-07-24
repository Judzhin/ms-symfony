<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace App\Service;

/**
 * Class HelloService
 * @package App\Service
 */
class HelloService
{
    /**
     * @return string
     */
    public function say(): string
    {
        return "Hello " . self::class . "\n";
    }
}