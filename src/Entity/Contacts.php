<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="contacts")
 * @ORM\Entity
 */
class Contacts
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
     * @ORM\Column(name="name", type="string", length=254, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=254, nullable=false)
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=254, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=254, nullable=false)
     */
    private $message;

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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getTel(): string
    {
        return $this->tel;
    }

    /**
     * @param string $tel
     */
    public function setTel(string $tel): void
    {
        $this->tel = $tel;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedat(): ?\DateTime
    {
        return $this->createdat;
    }

    /**
     * @param \DateTime|null $createdat
     */
    public function setCreatedat(?\DateTime $createdat): void
    {
        $this->createdat = $createdat;
    }

}
