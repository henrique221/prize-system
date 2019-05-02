<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SlackUserRepository")
 */
class SlackUser implements JsonSerializable
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

    /**
     * @ORM\Column(type="date", nullable=true, unique=false)
     */
    private $startDate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hasAccess;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Usuario", mappedBy="id")
     * @ORM\JoinColumns({@ORM\JoinColumn(name="userAccess", referencedColumnName="id", onDelete="CASCADE")})
     */
    private $userAccess;


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

    public function jsonSerialize()
    {
        return [
            "id" => $this->id
        ];
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @param $hasAccess
     */
    public function setHasAccess($hasAccess)
    {
        $this->hasAccess = $hasAccess;
    }

    /**
     * @return mixed
     */
    public function getHasAccess()
    {
        return $this->hasAccess;
    }

    /**
     * @return mixed
     */
    public function getUserAccess()
    {
        return $this->userAccess;
    }

    /**
     * @param mixed $userAccess
     */
    public function setUserAccess($userAccess): void
    {
        $this->userAccess = $userAccess;
    }
}
