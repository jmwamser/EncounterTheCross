<?php

namespace App\Exception\Core;

use App\Exception\ExceptionInterface;

/**
 * @author Jordan Wamser <jwamser@vortexglobal.com>
 */
class RuntimeException extends \RuntimeException implements ExceptionInterface
{
}
