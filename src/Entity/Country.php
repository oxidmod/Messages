<?php

namespace Oxidmod\Messages\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Oxidmod\Messages\Repository\CountryRepository")
 * @ORM\Table(name="countries")
 */
class Country
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="cnt_id", type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(name="cnt_code", type="string", length=3)
     *
     * @var string
     */
    private $code;

    /**
     * @ORM\Column(name="cnt_title", type="string", length=255)
     *
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(name="cnt_created", type="datetime_immutable")
     *
     * @var \DateTimeImmutable
     */
    private $createdAt;

    /**
     * @param string $code
     * @param string $title
     */
    public function __construct(string $code, string $title)
    {
        $this->code = $code;
        $this->title = $title;
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
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
