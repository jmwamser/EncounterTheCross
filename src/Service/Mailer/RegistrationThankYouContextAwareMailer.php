<?php

namespace App\Service\Mailer;

use App\Entity\EventParticipant;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;

final class RegistrationThankYouContextAwareMailer extends AbstractContextAwareMailer
{
    /**
     * This array will contain the KEY names that the context will require and the VALUE will be the object type that the context should have.
     */
    private const CONTEXT_REQUIREMENTS = [
        self::CONTEXT_REGISTRATION_OBJECT => EventParticipant::class,
    ];

    public const CONTEXT_REGISTRATION_OBJECT = 'registration';

    public function configureEmail(TemplatedEmail|Email $email): TemplatedEmail
    {
        assert($email instanceof TemplatedEmail);
        $email
            ->subject('Encounter Registration Confirmation')
            ->htmlTemplate('email/registration/thankyou.html.twig')
        ;

        if (array_key_exists(self::CONTEXT_REGISTRATION_OBJECT, $email->getContext())) {
            $registration = $email->getContext()[self::CONTEXT_REGISTRATION_OBJECT];
            assert($registration instanceof EventParticipant);
            $event = $registration->getEvent();

            // Create a more detailed subject line
            $email->subject(sprintf(
                'Encounter %s Registration Confirmation',
                ucfirst($registration->isServer() ? EventParticipant::TYPE_SERVER : EventParticipant::TYPE_ATTENDEE),
            ));
        }

        return $email;
    }
}
