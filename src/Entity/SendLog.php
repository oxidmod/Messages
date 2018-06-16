<?php

namespace Oxidmod\Messages\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Oxidmod\Messages\Repository\SendLogRepository")
 * @ORM\Table(name="send_log")
 */
class SendLog
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="log_id", type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Oxidmod\Messages\Entity\User")
     * @ORM\JoinColumn(name="usr_id", referencedColumnName="usr_id", nullable=false)
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Oxidmod\Messages\Entity\Number")
     * @ORM\JoinColumn(name="num_id", referencedColumnName="num_id", nullable=false)
     *
     * @var Number
     */
    private $number;

    /**
     * @ORM\Column(name="log_message", type="string", length=255)
     *
     * @var string
     */
    private $message;

    /**
     * @ORM\Column(name="log_success", type="boolean")
     *
     * @var bool
     */
    private $isSuccess;

    /**
     * @ORM\Column(name="log_created", type="datetime_immutable")
     *
     * @var \DateTimeImmutable
     */
    private $createdAt;

    /**
     * @param User   $user
     * @param Number $number
     * @param string $message
     *
     * @return SendLog
     */
    public static function logSuccess(User $user, Number $number, string $message): self
    {
        return new self($user, $number, $message, true);
    }

    /**
     * @param User   $user
     * @param Number $number
     * @param string $message
     *
     * @return SendLog
     */
    public static function logFail(User $user, Number $number, string $message): self
    {
        return new self($user, $number, $message, false);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Number
     */
    public function getNumber(): Number
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param User   $user
     * @param Number $number
     * @param string $message
     * @param bool   $isSuccess
     */
    private function __construct(User $user, Number $number, string $message, bool $isSuccess)
    {
        $this->user = $user;
        $this->number = $number;
        $this->message = $message;
        $this->isSuccess = $isSuccess;
        $this->createdAt = new \DateTimeImmutable();
    }
}
