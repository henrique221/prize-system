<?php


namespace App\Services;

use App\Entity\TrelloUser;
use App\Repository\TrelloUserRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

class TrelloService
{
    /**
     * @var CurlRequestDispatcher
     */
    private $requestDispatcher;
    /**
     * @var TrelloUserRepository
     */
    private $trelloUserRepository;
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    public function __construct(CurlRequestDispatcher $requestDispatcher, TrelloUserRepository $trelloUserRepository, ManagerRegistry $managerRegistry)
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
        $trelloUsers = $this->getAllUsers()->members;

        foreach ($trelloUsers as $trelloUser) {
            $userFromDatabase = $this->trelloUserRepository->findBy(["TrelloId" => $trelloUser->id]);
            if(!$userFromDatabase){
                $trelloUserObj = new TrelloUser();

                $trelloUserObj
                    ->setTrelloId($trelloUser->id)
                    ->setUsername($trelloUser->name);

                $em = $this->managerRegistry->getManager();
                $em->persist($trelloUserObj);
                $em->flush();
            }

        }
        return "ok";
    }
}