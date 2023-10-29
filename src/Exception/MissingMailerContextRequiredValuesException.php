<?php

namespace App\Exception;


use App\Exception\Core\LogicException;

class MissingMailerContextRequiredValuesException extends LogicException
{
    public function __construct(string $key, bool $missing = true, ?\Throwable $previous = null)
    {
        // the MailerContext is MISSING the key BLAAA
        // the MailerContext has an INVALID value on key BLAA
        parent::__construct(sprintf(
            $missing ? 'Can\'t send the email! The MailerContext is %s the key %s' : 'the MailerContext has an %s value on key %s',
            $missing ? 'MISSING' : 'INVALID',
            strtoupper($key)
        ), 0, $previous);
    }

}