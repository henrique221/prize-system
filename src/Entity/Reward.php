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
     *      @ORM\JoinColumn(name="slackUser", referencedColumnName="id", nullable=true, onDelete="CASCADE")
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

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $idWhoRewarded;

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

    /**
     * @return mixed
     */
    public function getIdWhoRewarded()
    {
        return $this->idWhoRewarded;
    }

    /**
     * @param mixed $idWhoRewarded
     */
    public function setIdWhoRewarded($idWhoRewarded): void
    {
        $this->idWhoRewarded = $idWhoRewarded;
    }

    public function getRewardsIndex(){
        $rewardIndex = [];
        foreach ($this->getRewards() as $r) {
            switch ($r) {
                case 'dare':
                    $rewardIndex[] = 1;
                    break;
                case 'create':
                    $rewardIndex[] = 2;
                    break;
                case 'do it':
                    $rewardIndex[] = 3;
                    break;
                case 'connect':
                    $rewardIndex[] = 4;
                    break;
                case 'deliver':
                    $rewardIndex[] = 5;
                    break;
            }
        }
        return $rewardIndex;
    }
}
