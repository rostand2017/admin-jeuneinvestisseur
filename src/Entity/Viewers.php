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


}
