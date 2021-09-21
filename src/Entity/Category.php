<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity
 */
class Category
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
     * @ORM\Column(name="title", type="string", length=254, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="createdat", type="datetime", length=254, nullable=false)
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedat(): ?\DateTime
    {
        return $this->createdat;
    }

    public function setCreatedat(\DateTime $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }


}
