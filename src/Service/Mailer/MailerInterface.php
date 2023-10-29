<?php

namespace App\Service\Mailer;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;

interface MailerInterface
{
    /**
     * @param string|array<Address>|array{array{email:string, name:string}}|Address[] $toEmails
     * @return void
     *
     * @throws TransportExceptionInterface
     */
    public function send(string|array $toEmails): void;
}