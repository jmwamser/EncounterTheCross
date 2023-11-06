<?php

namespace App\Service\Mailer;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;

class ResetPasswordContextAwareMailer extends AbstractContextAwareMailer
{
    protected function configureEmail(TemplatedEmail|Email $email): TemplatedEmail|Email
    {
        $email
            ->subject('Your password reset request')
            ->htmlTemplate('email/password.reset.html.twig')
        ;

        return $email;
    }
}
