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
     * @ORM\Column(type="integer", unique=true, nullable=false)
     */
    private $TrelloId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $Id): self
    {
        $this->Id = $Id;

        return $this;
    }

    public function getTrelloId(): ?int
    {
        return $this->TrelloId;
    }

    public function setTrelloId(int $TrelloId): self
    {
        $this->TrelloId = $TrelloId;

        return $this;
    }
}
