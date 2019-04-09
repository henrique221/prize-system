<?php

namespace App\Controller;

use App\Services\TrelloService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PrestonController extends AbstractController
{
    /**
     * @Route("/preston", name="preston")
     */
    public function index(TrelloService $trelloService)
    {
        $users = $trelloService->getAllUsers();

        return $this->render('preston/list.html.twig', [
            'user' => $this->getUser(),
            'users' =>  $users->members
        ]);
    }

    /**
     * @Route("/update", name="update_trello_database")
     */
    public function updateDatabase(TrelloService $trelloService){
        return $trelloService->updateTrelloDatabase();
    }
}
