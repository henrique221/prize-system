<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RewardRepository")
 */
class Reward
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SlackUser")
     * @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="slackUser", referencedColumnName="id", nullable=true)
     * })
     */
    private $slackUser;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="array")
     */
    private $rewards = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlackUser()
    {
        return $this->slackUser;
    }

    public function setSlackUser(SlackUser $slackUser)
    {
        $this->slackUser = $slackUser;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRewards(): ?array
    {
        return $this->rewards;
    }

    public function setRewards(array $rewards): self
    {
        $this->rewards = $rewards;

        return $this;
    }
}
