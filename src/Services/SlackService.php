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
    private $trelloUserRepository;
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    public function __construct(CurlRequestDispatcher $requestDispatcher, SlackUserRepository $trelloUserRepository, ManagerRegistry $managerRegistry)
    {
        $this->requestDispatcher = $requestDispatcher;
        $this->trelloUserRepository = $trelloUserRepository;
        $this->managerRegistry = $managerRegistry;
    }

    #TODO Refatorar
    public function getAllUsers(){
        $trelloUrl = "https://slack.com/api/users.list?token=xoxb-260471979411-591809437588-ODmeN9mFCJV5cHN2byap3evc&pretty=1";
        $request = $this->requestDispatcher->get($trelloUrl);
        return $request;
    }

    public function updateTrelloDatabase(){
        $slackUsers = $this->getAllUsers()->members;

        foreach ($slackUsers as $slackUser) {
            $userFromDatabase = $this->trelloUserRepository->findBy(["SlackId" => $slackUser->id]);
            if(!$userFromDatabase){
                $trelloUserObj = new SlackUser();

                $trelloUserObj
                    ->setSlackId($slackUser->id)
                    ->setUsername($slackUser->name);

                $realName = !empty($slackUser->real_name) ? $slackUser->real_name : "sem nome completo";
                $email = !empty($slackUser->profile->email) ? $slackUser->profile->email : "sem email";

                $trelloUserObj->setRealName($realName);
                $trelloUserObj->setEmail($email);
                $trelloUserObj->setDataDeNascimento(null);
                $trelloUserObj->setPremios("sem premios");

                $em = $this->managerRegistry->getManager();
                $em->persist($trelloUserObj);
                $em->flush();
            }
        }
        return new Response("200", 200);
    }
}