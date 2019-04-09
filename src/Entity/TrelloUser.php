<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrelloUserRepository")
 */
class TrelloUser
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
    private $TrelloId;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $Id): self
    {
        $this->Id = $Id;

        return $this;
    }

    public function getTrelloId(): ?string
    {
        return $this->TrelloId;
    }

    public function setTrelloId(string $TrelloId): self
    {
        $this->TrelloId = $TrelloId;

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
}
