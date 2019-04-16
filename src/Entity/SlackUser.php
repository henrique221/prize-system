<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="SlackUserRepository")
 */
class SlackUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true, nullable=false)
     */
    private $SlackId;

    /**
     * @ORM\Column(type="string", nullable=false, unique=false)
     */
    private $username;

    /**
     * @ORM\Column(type="array", nullable=true, unique=false)
     */
    private $premios;

    /**
     * @ORM\Column(type="date", nullable=true, unique=false)
     */
    private $dataDeNascimento;

    /**
     * @ORM\Column(type="string", nullable=true, unique=false)
     */

    private $real_name;


    /**
     * @ORM\Column(type="string", nullable=true, unique=false)
     */

    private $email;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $Id): self
    {
        $this->Id = $Id;

        return $this;
    }

    public function getSlackId(): ?string
    {
        return $this->SlackId;
    }

    public function setSlackId(string $SlackId): self
    {
        $this->SlackId = $SlackId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataDeNascimento()
    {
        return $this->dataDeNascimento;
    }

    /**
     * @param mixed $dataDeNascimento
     */
    public function setDataDeNascimento($dataDeNascimento): void
    {
        $this->dataDeNascimento = $dataDeNascimento;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPremios()
    {
        return $this->premios;
    }

    /**
     * @param mixed $premios
     */
    public function setPremios($premios): void
    {
        $this->premios = $premios;
    }

    /**
     * @return mixed
     */
    public function getRealName()
    {
        return $this->real_name;
    }

    /**
     * @param mixed $real_name
     */
    public function setRealName($real_name)
    {
        $this->real_name = $real_name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
}
