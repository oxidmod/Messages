<?php

namespace Oxidmod\Messages\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Oxidmod\Messages\Repository\NumberRepository")
 * @ORM\Table(name="numbers")
 */
class Number
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="num_id", type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Oxidmod\Messages\Entity\Country")
     * @ORM\JoinColumn(name="cnt_id", referencedColumnName="cnt_id", nullable=false)
     *
     * @var Country
     */
    private $country;

    /**
     * @ORM\Column(name="num_number", type="string", length=255)
     *
     * @var string
     */
    private $number;

    /**
     * @ORM\Column(name="num_created", type="datetime_immutable")
     *
     * @var \DateTimeImmutable
     */
    private $createdAt;

    /**
     * @param Country $country
     * @param string $number
     */
    public function __construct(Country $country, string $number)
    {
        $this->country = $country;
        $this->number = $number;
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
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
