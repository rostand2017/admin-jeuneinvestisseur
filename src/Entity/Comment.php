<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comment", indexes={@ORM\Index(name="fk_association3", columns={"user"}), @ORM\Index(name="fk_association2", columns={"news"}), @ORM\Index(name="fk_association5", columns={"comment"})})
 * @ORM\Entity
 */
class Comment
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
     * @ORM\Column(name="content", type="string", length=254, nullable=false)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=254, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=254, nullable=false)
     */
    private $email;

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

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var Comment
     *
     * @ORM\ManyToOne(targetEntity="Comment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="comment", referencedColumnName="id")
     * })
     */
    private $comment;

    public function __construct()
    {
        $this->createdat = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getComment(): ?self
    {
        return $this->comment;
    }

    public function setComment(?self $comment): self
    {
        $this->comment = $comment;

        return $this;
    }


}
