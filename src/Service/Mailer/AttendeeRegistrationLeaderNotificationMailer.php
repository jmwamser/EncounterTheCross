<?php

namespace App\Service\Mailer;

use App\Repository\LeaderRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface as Mailer;

final class AttendeeRegistrationLeaderNotificationMailer extends AbstractMailer
{
    public function __construct(
        Mailer $mailer,
        LoggerInterface $logger,
        private LeaderRepository $leaderRepository,
    ){
        parent::__construct($mailer, $logger);
    }


    /**
     * @inheritDoc
     */
    public function send(string|array|null $toEmails = [],array $context = [])
    {

        $toEmails = $this->createToAddresses(array_merge(
            $this->leaderRepository->findAllLeadersWithNotificationOnAndActive(),
            $toEmails
        ));

        $email = (new TemplatedEmail())
//            ->to($toEmails)
            ->subject('Welcome to the Space Bar!')
            ->htmlTemplate('email/registration.notification.html.twig')
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