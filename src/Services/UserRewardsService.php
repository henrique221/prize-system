<?php


namespace App\Services;


use App\DTO\UserRewardsDto;
use App\Entity\Reward;
use App\Entity\SlackUser;
use App\Repository\RewardRepository;
use App\Repository\SlackUserRepository;
use App\Repository\UsuarioRepository;

class UserRewardsService
{
    /**
     * @var RewardRepository
     */
    private $rewardRepository;
    /**
     * @var UsuarioRepository
     */
    private $usuarioRepository;

    public function __construct(RewardRepository $rewardRepository, UsuarioRepository $usuarioRepository)
    {
        $this->rewardRepository = $rewardRepository;
        $this->usuarioRepository = $usuarioRepository;
    }

    public function generateSlackUserRewardDto(SlackUser $slackUser)
    {
        $rewardsRepository = $this->rewardRepository->findBy(["slackUser" => $slackUser->getId()]);
        return new UserRewardsDto(
            $slackUser,
            $slackUser->getId(),
            $slackUser->getUsername(),
            $this->getAllUserRewards($slackUser),
            $slackUser->getDataDeNascimento(),
            $slackUser->getEmail()
        );
    }

    public function getAllUserRewards(SlackUser $slackUser)
    {
        $rewardsRepository = $this->rewardRepository->findBy(["slackUser" => $slackUser->getId()]);
        $allRewards = [];
        $dates = [];
        $rewards = [];
        $description = [];
        $whoRewarded = [];

        foreach ($rewardsRepository as $reward) {
            $dates[] = $reward->getDate();
            $rewards[] = $reward->getRewards();
            $description[] = $reward->getDescription();
            if($reward->getIdWhoRewarded()) {
                $whoRewarded[] = $this->usuarioRepository->find($reward->getIdWhoRewarded());
            }

            $allRewards["dates"] = $dates;
            $allRewards["rewards"] = $rewards;
            $allRewards["description"] = $description;
            $allRewards["whoRewarded"] = $whoRewarded;
        }

        return $allRewards;
    }
}