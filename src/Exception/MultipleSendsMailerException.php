<?php

namespace App\Exception;

use App\Exception\Core\RuntimeException;
use JetBrains\PhpStorm\Pure;

class MultipleSendsMailerException extends RuntimeException
{
    #[Pure]
    public function __construct(string $class, \Throwable $previous = null)
    {
        parent::__construct(
            sprintf(
                'Class %s is not configured to send its email more than once. Either allow it to send more than one time or prevent from sending a second time.',
                $class
            ), 0, $previous);
    }
}
