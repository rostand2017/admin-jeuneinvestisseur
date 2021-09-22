<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Viewers
 *
 * @ORM\Table(name="viewers", indexes={@ORM\Index(name="fk_association1", columns={"news"})})
 * @ORM\Entity
 */
class Viewers
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
     * @var integer
     *
     * @ORM\Column(name="duration", type="integer", nullable=true)
     */
    private $duration;

    /**
     * @var integer
     *
     * @ORM\Column(name="readpercentage", type="integer", nullable=true)
     */
    private $readPercentage;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdat", type="datetime", nullable=true)
     */
    private $createdat;

    /**
     * @var News
     *
     * @ORM\ManyToOne(targetEntity="News")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="news", referencedColumnName="id")
     * })
     */
    private $news;

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

    public function getNews(): ?News
    {
        return $this->news;
    }

    public function setNews(?News $news): self
    {
        $this->news = $news;

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

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @return int
     */
    public function getReadPercentage(): int
    {
        return $this->readPercentage;
    }

    /**
     * @param int $readPercentage
     */
    public function setReadPercentage(int $readPercentage): void
    {
        $this->readPercentage = $readPercentage;
    }

}
