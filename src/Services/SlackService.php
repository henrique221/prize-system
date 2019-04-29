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

    public function updateTrelloDatabase($userId)
    {
        $slackUsers = $this->getAllUsers()->members;

        $userFromDatabase = $this->slackUserRepository->findBy(["SlackId" => $userId]);

        if (!$userFromDatabase) {
            $trelloUserObj = new SlackUser();
            foreach ($slackUsers as $slackUser) {
                if ($slackUser->id == $userId) {

                    $trelloUserObj
                        ->setSlackId($slackUser->id)
                        ->setUsername($this->formatUserNameToName($slackUser->name));

                    $realName = !empty($slackUser->real_name) ? $slackUser->real_name : "no full name";
                    $email = !empty($slackUser->profile->email) ? $slackUser->profile->email : "no email";

                    $trelloUserObj->setRealName($realName);
                    $trelloUserObj->setEmail($email);
                    $trelloUserObj->setDataDeNascimento(null);

                    $em = $this->managerRegistry->getManager();
                    $em->persist($trelloUserObj);
                    $em->flush();
                }
            }
            return new Response("ok", 200);
        } else {
            return new Response("user already exists", 409);
        }
    }

    public function sendMessageToUser(SlackUser $slackUser, $rewardsFilterSelected, $description, $user)
    {
        $slackId = $slackUser->getSlackId();
        $rewards = implode(", ", $rewardsFilterSelected);
        $text = rawurlencode("*CONGRATULATIONS!*\nYou have just been rewarded by {$user->getName()}\n\n_Rewarding message :_ \n```{$description}```\nRewards you have received :\n_{$rewards}_");

        $urlOpenChat = "https://slack.com/api/im.open?token=xoxb-260471979411-591809437588-ODmeN9mFCJV5cHN2byap3evc&user={$slackId}&pretty=1";
        $openChatRequest = $this->requestDispatcher->post($urlOpenChat);
        $channelId = $openChatRequest->channel->id;
        $sendMessageUrl = "https://slack.com/api/chat.postMessage?token=xoxb-260471979411-591809437588-ODmeN9mFCJV5cHN2byap3evc&channel={$channelId}&text={$text}&pretty=1";
        $this->requestDispatcher->post($sendMessageUrl);
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