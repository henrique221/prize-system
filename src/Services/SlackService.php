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

    public function getUser($userId)
    {
        $url = "https://slack.com/api/users.profile.get?token=xoxp-260471979411-489549804816-597878161238-be9bc3c8425e2fc76e15893d9ea98e5e&user={$userId}&pretty=1";
        $request = $this->requestDispatcher->get($url);
        return $request;
    }

    public function updateSlackDatabase($userId)
    {
        $userFromDatabase = $this->slackUserRepository->findBy(["SlackId" => $userId]);

        if (!$userFromDatabase) {
            $slackUserObj = new SlackUser();
            $user = $this->getUser($userId);

            if($user->ok == true){

                $slackUserObj
                    ->setSlackId($userId)
                    ->setUsername($this->formatNameToUsername($user->profile->real_name));

                $realName = !empty($user->profile->real_name) ? $user->profile->real_name : "no full name";
                $email = !empty($user->profile->email) ? $user->profile->email : "no email";

                $slackUserObj->setUsername($realName);
                $slackUserObj->setEmail($email);
                $slackUserObj->setDataDeNascimento(null);

                $this->slackUserRepository->persist($slackUserObj);

                return $slackUserObj;
            }

        } else {
            return "user already exists";
        }
    }

    public function sendMessageToUser(SlackUser $slackUser, $rewardsFilterSelected, $description, $user)
    {
        $slackId = $slackUser->getSlackId();

        $rewards = explode(",", implode(",", $rewardsFilterSelected));

        $rewardsWithTrophyArray = [];

        for ($i = 0; $i <= sizeof($rewards) - 1; $i++) {
            switch ($rewards[$i]) {
                case 'deliver':
                    $rewardsWithTrophyArray[] = ":deliver: " . $rewards[$i];
                    break;
                case 'dare':
                    $rewardsWithTrophyArray[] = ":dare: " . $rewards[$i];
                    break;
                case 'do it':
                    $rewardsWithTrophyArray[] = ":doit: " . $rewards[$i];
                    break;
                case 'connect':
                    $rewardsWithTrophyArray[] = ":connect: " . $rewards[$i];
                    break;
                case 'create':
                    $rewardsWithTrophyArray[] = ":create: " . $rewards[$i];
                    break;
            }
        }

        $rewardsWithTrophy = implode(" ", $rewardsWithTrophyArray);
        $textToUser = rawurlencode("\n*CONGRATULATIONS " . strtoupper($slackUser->getUsername()) . "!* :wink: <@{$slackUser->getSlackId()}> \nYou have just been rewarded by {$user->getName()}\n\n_Rewarding message :_ \n```{$description}```\nRewards you have received :\n_{$rewardsWithTrophy}_\n");
        $textToGeneral = "\n*CONGRATULATIONS " . strtoupper($slackUser->getUsername()) . "!* :wink: <@{$slackUser->getSlackId()}> \nYou have just been rewarded by {$user->getName()}\n\n_Rewarding message :_ \n```{$description}```\nRewards you have received :\n_{$rewardsWithTrophy}_\n";

        $urlOpenChat = "https://slack.com/api/im.open?token=xoxb-260471979411-591809437588-ODmeN9mFCJV5cHN2byap3evc&user={$slackId}&pretty=1";
        $openChatRequest = $this->requestDispatcher->post($urlOpenChat);
        $channelId = $openChatRequest->channel->id;

        $sendMessageUrlToUser = "https://slack.com/api/chat.postMessage?token=xoxb-260471979411-591809437588-ODmeN9mFCJV5cHN2byap3evc&channel={$channelId}&text={$textToUser}&pretty=1";
        $sendMessageUrlToGeneral = "https://hooks.slack.com/services/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";
//        $sendMessageUrlToTest = "https://hooks.slack.com/services/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";

        $this->requestDispatcher->post($sendMessageUrlToUser);
//        $this->requestDispatcher->post($sendMessageUrlToTest, ["blocks" => [["type" => "divider"], ["type"=> "section", "text" => ["type"=> "mrkdwn", "text" => "{$textToGeneral}"], "accessory" => ["type" => "image", "image_url" => "https://i2.wp.com/www.wakeed.org/wp-content/uploads/2016/07/award-icon-06.png", "alt_text" => "reward"]] ,["type" => "divider"]]]);
        $this->requestDispatcher->post($sendMessageUrlToGeneral, ["blocks" => [["type" => "divider"], ["type" => "section", "text" => ["type" => "mrkdwn", "text" => "{$textToGeneral}"], "accessory" => ["type" => "image", "image_url" => "https://i2.wp.com/www.wakeed.org/wp-content/uploads/2016/07/award-icon-06.png", "alt_text" => "reward"]], ["type" => "divider"]]]);
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

    private function formatNameToUsername($name)
    {
        $sentences = preg_split('/([.?!]+)/', $name, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        $sentences = str_replace(" ", ".", $sentences);
        $new_string = '';
        foreach ($sentences as $key => $sentence) {
            $new_string = strtolower(trim($sentence));
        }
        return trim($new_string);
    }

    public function sendBirthdayNotification($birthdays)
    {
        for ($i = 0; $i <= sizeof($birthdays) - 1; $i++) {
            switch ($birthdays) {
                case array_key_exists("five", $birthdays[$i]):
                    $this->notifiesBirthdayWIthRemainingDays($birthdays[$i]['five']->getUsername(), 5, $birthdays[$i]['five']->getSlackId());
                    break;

                case array_key_exists("ten", $birthdays[$i]):
                    $this->notifiesBirthdayWIthRemainingDays($birthdays[$i]['ten']->getUsername(), 10, $birthdays[$i]['ten']->getSlackId());
                    break;

                case array_key_exists("three", $birthdays[$i]):
                    $this->notifiesBirthdayWIthRemainingDays($birthdays[$i]['three']->getUsername(), 3, $birthdays[$i]['three']->getSlackId());
                    break;

                case array_key_exists("two", $birthdays[$i]):
                    $this->notifiesBirthdayWIthRemainingDays($birthdays[$i]['two']->getUsername(), 2, $birthdays[$i]['two']->getSlackId());
                    break;

                case array_key_exists("birthday", $birthdays[$i]):
                    $this->notifiesBirthdayWIthRemainingDays($birthdays[$i]['birthday']->getUsername(), 0, $birthdays[$i]['birthday']->getSlackId());
                    break;
            }
        }
    }

    /**
     * @param $user
     * @param $remainingDays
     * @param $slackId
     */
    public function notifiesBirthdayWIthRemainingDays($user, $remainingDays, $slackId)
    {
        $users = $this->slackUserRepository->findAll();

        $defaultText = rawurlencode("Faltam `{$remainingDays}` dias para o aniversário de *{$user}* :fireworks:");

        if ($remainingDays == 0) {
            $textToGeneral = "<!channel>\nToday is *{$user}'s* birthday :balloon: :fireworks: :star2: \n<http://4you2team.slack.com/team/{$slackId}|Wish happy birthday>";
            $sendMessageToGeneral = "https://hooks.slack.com/services/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";
//            $sendMessageToGeneral = "https://hooks.slack.com/services/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";
            $this->requestDispatcher->post($sendMessageToGeneral, ["blocks" => [["type" => "divider"], ["type" => "section", "text" => ["type" => "mrkdwn", "text" => "{$textToGeneral}"], "accessory" => ["type" => "image", "image_url" => "https://techcrunch.com/wp-content/uploads/2011/06/tctv-birthday.jpg?w=500", "alt_text" => "birthday"]], ["type" => "divider"]]]);
        }

        /** @var SlackUser $user */
        foreach ($users as $userSlack) {
            if ($remainingDays == 0) {
                $defaultText = rawurlencode("Hoje é aniversário de *{$user}* :balloon: :fireworks: :star2: \n<http://4you2team.slack.com/team/{$slackId}|Deseje um feliz aniversário>");
            }

            if ($userSlack->getSlackId() == $slackId and $remainingDays == 0) {
                $defaultText = rawurlencode("Happy birthday *{$user}* :balloon: :fireworks: :star2:");
            }

            $this->createChatAndSendMessageToUser($userSlack->getSlackId(), $defaultText);
        }
    }

    public function createChatAndSendMessageToUser($id, $text)
    {
        $userChatOpen = "https://slack.com/api/im.open?token=xoxb-260471979411-591809437588-ODmeN9mFCJV5cHN2byap3evc&user={$id}&pretty=1";
        $openChatRequestUser = $this->requestDispatcher->post($userChatOpen);

        $channelUser = $openChatRequestUser->channel->id;
        $sendMessageUrlToUser = "https://slack.com/api/chat.postMessage?token=xoxb-260471979411-591809437588-ODmeN9mFCJV5cHN2byap3evc&channel={$channelUser}&text={$text}&pretty=1";

        $this->requestDispatcher->post($sendMessageUrlToUser);
    }

    public function sendMessageToManager($message, $user)
    {
        try {
            $url = "https://hooks.slack.com/services/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";
            $this->requestDispatcher->post($url, ["text" => "{$message} \n```{$user->getName()}```"]);
            return "sent";
        }catch (\Exception $exception){
            return $exception;
        }
    }
}