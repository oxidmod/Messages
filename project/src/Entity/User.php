<?php

declare(strict_types=1);

namespace Oxidmod\Messages\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Oxidmod\Messages\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="usr_id", type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(name="usr_name", type="string", length=255)
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(name="usr_active", type="boolean")
     *
     * @var bool
     */
    private $isActive = true;

    /**
     * @ORM\Column(name="usr_created", type="datetime_immutable")
     *
     * @var \DateTimeImmutable
     */
    private $createdAt;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->createdAt = new \DateTimeImmutable();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
