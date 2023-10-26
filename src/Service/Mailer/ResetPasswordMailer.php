<?php

namespace App\Service\Mailer;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

class ResetPasswordMailer extends AbstractMailer
{
    public function send(string|array $toEmails = null,array $context = [])
    {
        if (null == $toEmails) {
            $this->handlePreventEmailSend(
                message: 'There was no ToEmails configured, skipping sending email.',
                context: $context,
            );
        }

        $toEmails = $this->createToAddresses($toEmails);

        $email = (new TemplatedEmail())
//            ->to($toEmails)
            ->subject('Your password reset request')
            ->htmlTemplate('email/password.reset.html.twig')
            ->context($context)
        ;

        is_array($toEmails) ? $email->to(...$toEmails) : $email->to($toEmails);

        $this->getMailer()->send($email);
    }

    protected function handlePreventEmailSend(?string $message = null, array $context = [], ?string $class = null)
    {
        parent::handlePreventEmailSend($message, $context, $class ?? __CLASS__);
    }
}