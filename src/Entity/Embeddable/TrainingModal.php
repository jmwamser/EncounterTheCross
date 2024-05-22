<?php

namespace App\Entity\Embeddable;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Embeddable;
use Exception;
use Symfony\Component\Validator\Constraints as Assert;

#[Embeddable]
class TrainingModal
{
    public const DEFAULT_VIEW_TIMEZONE = 'America/Chicago';
    public const DEFAULT_SERVER_TIMEZONE = 'UTC';

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public ?string $locationName = '';

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public ?string $locationAddress = '';

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public ?string $locationCity = '';

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public ?string $locationState = '';

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public ?string $locationZip = '';

    #[Assert\GreaterThanOrEqual('today')]
    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $startTime = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $timezone = self::DEFAULT_VIEW_TIMEZONE;

    public function __construct()
    {
    }

    /**
     * @throws Exception
     */
    public function getStartTime(): ?DateTime
    {
        if (null !== $this->getTimezone()) {
            $this->startTime?->setTimezone(new DateTimeZone($this->getTimezone()));
        }

        return $this->startTime;
    }

    /**
     * @throws Exception
     */
    public function setStartTime(?DateTime $startTime): void
    {
        $this->startTime = $startTime;
    }

    public function getTimezone($localized = true)
    {
        return $this->timezone ?? ($localized ? self::DEFAULT_VIEW_TIMEZONE : self::DEFAULT_SERVER_TIMEZONE);
    }

    public function setTimezone(?string $timezone): void
    {
        if (null === $timezone) {
            $timezone = self::DEFAULT_VIEW_TIMEZONE;
        }

        $this->timezone = $timezone;
    }
}
