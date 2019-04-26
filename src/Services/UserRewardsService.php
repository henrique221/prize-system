<?php


namespace App\Services;


use App\DTO\UserRewardsDto;
use App\Entity\SlackUser;
use App\Repository\RewardRepository;

class UserRewardsService
{
    /**
     * @var RewardRepository
     */
    private $rewardRepository;

    public function __construct(RewardRepository $rewardRepository)
    {
        $this->rewardRepository = $rewardRepository;
    }

    public function generateSlackUserRewardDto(SlackUser $slackUser){
        $rewardsRepository = $this->rewardRepository->findBy(["slackUser" => $slackUser->getId()]);
        return new UserRewardsDto($slackUser, $slackUser->getId(), $slackUser->getUsername(), $this->getAllUserRewards($slackUser), $slackUser->getDataDeNascimento(), $slackUser->getEmail());
    }

    public function getAllUserRewards(SlackUser $slackUser){
        $rewardsRepository = $this->rewardRepository->findBy(["slackUser" => $slackUser->getId()]);
        $allRewards = [];
        $dates = [];
        $rewards = [];
        $description = [];

        foreach ($rewardsRepository as $reward){
                $dates[] = $reward->getDate();
                $rewards[] = $reward->getRewards();
                $description[] = $reward->getDescription();

                $allRewards["dates"] = $dates;
                $allRewards["rewards"] = $rewards;
                $allRewards["description"] = $description;
            }

        return $allRewards;
    }
}