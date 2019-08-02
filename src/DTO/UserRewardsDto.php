<?php


namespace App\DTO;


use App\Entity\Reward;
use App\Entity\SlackUser;
use App\Repository\RewardRepository;
use JsonSerializable;

class UserRewardsDto implements JsonSerializable
{
    /**
     * @var SlackUser
     */
    private $slackUser;
    private $userId;
    private $username;
    private $rewards;
    private $birthdate;
    private $email;
    private $id;
    private $rewardsIndex;
    private $hasAccess;

    public function __construct(SlackUser $slackUser, $id, $username, array $rewards, $birthdate, $email)
    {
        $this->slackUser = $slackUser;
        $this->rewards = $rewards;
        $this->birthdate = $birthdate;
        $this->email = $email;
        $this->id = $id;
        $this->username = $username;
        $this->hasAccess = $slackUser->getHasAccess();
    }


    public function jsonSerialize()
    {
        return [
            "userId" => $this->slackUser->getId(),
            "username" => $this->slackUser->getUsername(),
            "email" => $this->slackUser->getEmail(),
            "birthdate" => $this->slackUser->getDataDeNascimento(),
            "rewards" => $this->getRewards(),
            "rewardsIndex" => $this->getRewardsIndex(),
            "hasAccess" => $this->getHasAccess()
        ];
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getRewards()
    {
        return $this->rewards;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @param array $rewards
     */
    public function setRewards(array $rewards): void
    {
        $this->rewards = $rewards;
    }

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param mixed $birthdate
     */
    public function setBirthdate($birthdate): void
    {
        $this->birthdate = $birthdate;
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
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getRewardsJoined()
    {
        $rewardsArray = [];
        $rewards = $this->getRewards();
        if(isset($rewards["rewards"])) {
            foreach ($rewards["rewards"] as $reward) {
                foreach ($reward as $item){
                    $rewardsArray[] = $item;
                }
            }
        }
        return $rewardsArray;
    }

    /**
     * @return mixed
     */
    public function getHasAccess()
    {
        return $this->hasAccess;
    }

    /**
     * @param mixed $hasAccess
     */
    public function setHasAccess($hasAccess): void
    {
        $this->hasAccess = $hasAccess;
    }

    /**
     * @return SlackUser
     */
    public function getSlackUser(): SlackUser
    {
        return $this->slackUser;
    }

    /**
     * @param SlackUser $slackUser
     */
    public function setSlackUser(SlackUser $slackUser): void
    {
        $this->slackUser = $slackUser;
    }
}