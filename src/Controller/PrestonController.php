<?php

namespace App\Controller;

use App\Entity\SlackUser;
use App\Entity\Usuario;
use App\Form\SlackUserType;
use App\Form\UsuarioType;
use App\Repository\SlackUserRepository;
use App\Repository\UsuarioRepository;
use App\Services\SlackService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PrestonController
 * @package App\Controller
 * @Route("/preston")
 */
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
     * @Route("/", name="preston", methods={"GET"})
     * @param Request $request
     */
    public function index(Request $request)
    {
        $userDatabase = $this->slackUserRepository->findAll();

        return $this->render('preston/list.html.twig', [
            'user' => $this->getUser(),
            'userDatabase' => $userDatabase
        ]);
    }

    /**
     * @Route("/reward/{id}", name="add_reward", methods={"GET", "POST"})
     * @param SlackUser $slackUser
     * @param Request $request
     * @return Response
     */
    public function addReward(Request $request, SlackUser $slackUser){
        $rewards = [
            1 => "faca",
            2 => "crie",
            3 => "ouse",
            4 => "conecte"
        ];

        $tags = explode(",", $request->request->get("tags"));
        $rewardsFilterSelected = [];

        foreach ($tags as $tag){
            $rewardsFilterSelected[] = $rewards[$tag];
        }

        $slackUser->setPremios($rewardsFilterSelected);
        $this->slackUserRepository->appendReward($slackUser);
        return $this->redirectToRoute("preston");
    }

    /**
     * @Route("/update", name="update_trello_database", methods={"GET", "POST"})
     * @param Request $request
     */
    public function updateDatabase(SlackService $slackService)
    {
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
    public function createAccessUser(Request $request)
    {
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
    public function checkSlackUserInDatabase(Request $request, SlackService $slackService)
    {
        $userId = $request->request->get("userId");
        $status = $slackService->updateTrelloDatabase($userId);
        return new JsonResponse($userId, $status->getStatusCode());
    }

    /**
     * @Route("/{id}/edit", name="edit_user", methods={"GET", "POST"})
     * @param SlackUser $slackUser
     * @param Request $request
     * @return Response
     */
    public function editUser(Request $request, SlackUser $slackUser)
    {

        $form = $this->createForm(SlackUserType::class, $slackUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->slackUserRepository->save($slackUser);

            $this->addFlash('notice', "User edited sucessfully");
            return $this->redirectToRoute('edit_user', array('id' => $slackUser->getId()));
        }

        return $this->render("preston/editUser.html.twig", array(
            'form' => $form->createView(),
            'slackUser' => $slackUser
        ));
    }

    /**
     * @Route("/{id}/rewards", name="amount_rewards")
     * @param SlackUser $slackUser
     * @return Response
     */
    public function getAmountRewards(SlackUser $slackUser){
        return new Response(count($slackUser->getPremios()));
    }
}
