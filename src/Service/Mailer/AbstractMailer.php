<?php

namespace App\Service\Mailer;

use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface as Mailer;
use Symfony\Component\Mime\Address;

abstract class AbstractMailer implements MailerInterface
{
    public function __construct(
        private Mailer $mailer,
        protected LoggerInterface $logger,
    ){
    }

    /**
     * @inheritDoc
     */
    abstract public function send(string|array|null $toEmails = null,array $context = []);

    protected function createToAddresses(string|array $toEmails): array|Address
    {
        if (is_string($toEmails)) {
            return new Address($toEmails);
        }

        if (is_array($toEmails)) {
            dump($toEmails);
            $toEmails = array_map(function(array|Address $toEmail) {
                return $toEmail instanceof Address
                    ? $toEmail
                    : new Address($toEmail['Email'],$toEmail['Name']);
            },$toEmails);
        }

        return $toEmails;
    }

    protected function getMailer(): Mailer
    {
        return $this->mailer;
    }

    protected function handlePreventEmailSend(?string $message = null, array $context = [], ?string $class = null)
    {
        $classContext = [];
        if ($class) {
            $classContext = ['class' => $class];
        }
        $this->logger->warning($message ?? 'Had an issue generating the email, was unable to send.',array_merge($context,$classContext));
    }
}