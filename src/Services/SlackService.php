<?php


namespace App\Services;

use App\Entity\SlackUser;
use App\Repository\SlackUserRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SlackService
{
    /**
     * @var CurlRequestDispatcher
     */
    private $requestDispatcher;
    /**
     * @var SlackUserRepository
     */
    private $slackUserRepository;
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    public function __construct(CurlRequestDispatcher $requestDispatcher, SlackUserRepository $slackUserRepository, ManagerRegistry $managerRegistry)
    {
        $this->requestDispatcher = $requestDispatcher;
        $this->slackUserRepository = $slackUserRepository;
        $this->managerRegistry = $managerRegistry;
    }

    #TODO Refatorar
    public function getAllUsers()
    {
        $trelloUrl = "https://slack.com/api/users.list?token=xoxb-260471979411-591809437588-ODmeN9mFCJV5cHN2byap3evc&pretty=1";
        $request = $this->requestDispatcher->get($trelloUrl);
        return $request;
    }

    public function updateSlackDatabase($userId)
    {
        $slackUsers = $this->getAllUsers()->members;

        $userFromDatabase = $this->slackUserRepository->findBy(["SlackId" => $userId]);

        if (!$userFromDatabase) {
            $slackUserObj = new SlackUser();
            foreach ($slackUsers as $slackUser) {
                if ($slackUser->id == $userId) {

                    $slackUserObj
                        ->setSlackId($slackUser->id)
                        ->setUsername($this->formatUserNameToName($slackUser->name));

                    $realName = !empty($slackUser->real_name) ? $slackUser->real_name : "no full name";
                    $email = !empty($slackUser->profile->email) ? $slackUser->profile->email : "no email";

                    $slackUserObj->setRealName($realName);
                    $slackUserObj->setEmail($email);
                    $slackUserObj->setDataDeNascimento(null);

                    $em = $this->managerRegistry->getManager();
                    $em->persist($slackUserObj);
                    $em->flush();
                }
            }
            return new Response("user added", 200);
        } else {
            return new Response("user already exists", 409);
        }
    }

    public function sendMessageToUser(SlackUser $slackUser, $rewardsFilterSelected, $description, $user)
    {
        $slackId = $slackUser->getSlackId();

        $rewards = explode(",", implode(",", $rewardsFilterSelected));

        $rewardsWithTrophyArray = [];

        for($i = 0; $i <= sizeof($rewards)-1; $i++) {
            switch ($rewards[$i]){
                case 'deliver':
                    $rewardsWithTrophyArray[] = ":deliver: ".$rewards[$i];
                    break;
                case 'dare':
                    $rewardsWithTrophyArray[] = ":dare: ".$rewards[$i];
                    break;
                case 'do it':
                    $rewardsWithTrophyArray[] = ":doit: ".$rewards[$i];
                    break;
                case 'connect':
                    $rewardsWithTrophyArray[] = ":connect: ".$rewards[$i];
                    break;
                case 'create':
                    $rewardsWithTrophyArray[] = ":create: ".$rewards[$i];
                    break;
            }
        }

        $rewardsWithTrophy = implode(" ", $rewardsWithTrophyArray);
        $textToUser = rawurlencode("\n*CONGRATULATIONS ".strtoupper($slackUser->getUsername())."!* :wink: <@{$slackUser->getSlackId()}> \nYou have just been rewarded by {$user->getName()}\n\n_Rewarding message :_ \n```{$description}```\nRewards you have received :\n_{$rewardsWithTrophy}_\n");
        $textToGeneral = "\n*CONGRATULATIONS ".strtoupper($slackUser->getUsername())."!* :wink: <@{$slackUser->getSlackId()}> \nYou have just been rewarded by {$user->getName()}\n\n_Rewarding message :_ \n```{$description}```\nRewards you have received :\n_{$rewardsWithTrophy}_\n";

        $urlOpenChat = "https://slack.com/api/im.open?token=xoxb-260471979411-591809437588-ODmeN9mFCJV5cHN2byap3evc&user={$slackId}&pretty=1";
        $openChatRequest = $this->requestDispatcher->post($urlOpenChat);
        $channelId = $openChatRequest->channel->id;

        $sendMessageUrlToUser = "https://slack.com/api/chat.postMessage?token=xoxb-260471979411-591809437588-ODmeN9mFCJV5cHN2byap3evc&channel={$channelId}&text={$textToUser}&pretty=1";
        $sendMessageUrlToGeneral = "https://hooks.slack.com/services/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";
//        $sendMessageUrlToTest = "https://hooks.slack.com/services/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";

        $this->requestDispatcher->post($sendMessageUrlToUser);
//        $this->requestDispatcher->post($sendMessageUrlToTest, ["blocks" => [["type" => "divider"], ["type"=> "section", "text" => ["type"=> "mrkdwn", "text" => "{$textToGeneral}"], "accessory" => ["type" => "image", "image_url" => "https://i2.wp.com/www.wakeed.org/wp-content/uploads/2016/07/award-icon-06.png", "alt_text" => "reward"]] ,["type" => "divider"]]]);
        $this->requestDispatcher->post($sendMessageUrlToGeneral, ["blocks" => [["type" => "divider"], ["type"=> "section", "text" => ["type"=> "mrkdwn", "text" => "{$textToGeneral}"], "accessory" => ["type" => "image", "image_url" => "https://i2.wp.com/www.wakeed.org/wp-content/uploads/2016/07/award-icon-06.png", "alt_text" => "reward"]] ,["type" => "divider"]]]);
    }

    private function formatUserNameToName($username)
    {
        $sentences = preg_split('/([.?!]+)/', $username, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        $sentences = str_replace(".", "", $sentences);
        $new_string = '';
        foreach ($sentences as $key => $sentence) {
            $new_string .= ($key & 1) == 0 ?
                ucfirst(strtolower(trim($sentence))) :
                $sentence . ' ';
        }
        return trim($new_string);
    }
}