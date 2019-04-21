<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Repository\SlackUserRepository;
use App\Repository\UsuarioRepository;
use App\Services\SlackService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrestonController extends AbstractController
{
    /**
     * @var UsuarioRepository
     */
    private $usuarioRepository;
    /**
     * @var SlackUserRepository
     */
    private $slackUserRepository;

    public function __construct(UsuarioRepository $usuarioRepository, SlackUserRepository $slackUserRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
        $this->slackUserRepository = $slackUserRepository;
    }

    /**
     * @Route("/preston", name="preston")
     */
    public function index(SlackService $slackService)
    {
        $users = $slackService->getAllUsers();

        $userDatabase = [];
        foreach ($users->members as $userForId){
            $userDatabase[] = $this->slackUserRepository->findOneBy(["SlackId" => $userForId->id]);
        }

        return $this->render('preston/list.html.twig', [
            'user' => $this->getUser(),
            'users' =>  $users->members,
            'userDatabase' => $userDatabase
        ]);
    }

    /**
     * @Route("/update", name="update_trello_database", methods={"GET", "POST"})
     * @param Request $request
     */
    public function updateDatabase(SlackService $slackService){
        $users = $slackService->getAllUsers();
        return $this->render('preston/updateDatabase.html.twig', [
            'users' => $users->members
        ]);
    }

    /**
     * @Route("/create/access", name="create_access", methods={"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createAccessUser(Request $request){
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->usuarioRepository->persist($usuario);
            return $this->redirectToRoute('preston');
        }
        return $this->render("preston/accessForm.html.twig", ['form' => $form->createView()]);
    }

    /**
     * @Route("check/user", name="check_user_in_database", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function checkSlackUserInDatabase(Request $request, SlackService $slackService){
        $userId = $request->request->get("userId");
        $slackService->updateTrelloDatabase($userId);
        return new JsonResponse($userId);
    }
}
