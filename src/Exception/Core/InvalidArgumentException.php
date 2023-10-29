<?php

namespace App\Exception\Core;

use App\Exception\ExceptionInterface;

/**
 * @author Jordan Wamser <jwamser@vortexglobal.com>
 */
class InvalidArgumentException extends \InvalidArgumentException implements ExceptionInterface
{
}