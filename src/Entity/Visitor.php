<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Viewers
 *
 * @ORM\Table(name="visitor")
 * @ORM\Entity(repositoryClass="App\Repository\VisitorRepository")
 */
class Visitor
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="viewerkey", type="string", length=254, nullable=false)
     */
    private $viewerkey;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=254, nullable=true)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=254, nullable=true)
     */
    private $country;


    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdat", type="datetime", nullable=true)
     */
    private $createdat;


    public function __construct()
    {
        $this->createdat = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getViewerkey(): ?string
    {
        return $this->viewerkey;
    }

    public function setViewerkey(string $viewerkey): self
    {
        $this->viewerkey = $viewerkey;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(?\DateTimeInterface $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp(string $ip): void
    {
        $this->ip = $ip;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

}
