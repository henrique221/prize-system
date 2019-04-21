<?php


namespace App\Services;

use App\Entity\SlackUser;
use App\Repository\SlackUserRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
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
                if($slackUser->id == $userId) {
                    $trelloUserObj
                        ->setSlackId($slackUser->id)
                        ->setUsername($slackUser->name);

                    $realName = !empty($slackUser->real_name) ? $slackUser->real_name : "no full name";
                    $email = !empty($slackUser->profile->email) ? $slackUser->profile->email : "no email";

                    $trelloUserObj->setRealName($realName);
                    $trelloUserObj->setEmail($email);
                    $trelloUserObj->setDataDeNascimento(null);
                    $trelloUserObj->setPremios(null);

                    $em = $this->managerRegistry->getManager();
                    $em->persist($trelloUserObj);
                    $em->flush();
                }
            }
            return new Response("ok", 200);
        }else{
            return new Response("user already exists", 409);
        }
    }
}