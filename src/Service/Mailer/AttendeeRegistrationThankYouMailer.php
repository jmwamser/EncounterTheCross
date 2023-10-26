<?php

namespace App\Service\Mailer;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface as Mailer;
use Symfony\Component\Mime\Address;

final class AttendeeRegistrationThankYouMailer extends AbstractMailer
{
    /**
     * @inheritDoc
     */
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
            ->subject('Welcome to the Space Bar!')
            ->htmlTemplate('email/registration.thankyou.html.twig')
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