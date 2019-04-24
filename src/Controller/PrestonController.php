<?php

namespace App\Controller;

use App\Entity\Reward;
use App\Entity\SlackUser;
use App\Entity\Usuario;
use App\Form\SlackUserType;
use App\Form\UsuarioType;
use App\Repository\RewardRepository;
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
    /**
     * @var RewardRepository
     */
    private $rewardRepository;

    public function __construct(UsuarioRepository $usuarioRepository, SlackUserRepository $slackUserRepository, RewardRepository $rewardRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
        $this->slackUserRepository = $slackUserRepository;
        $this->rewardRepository = $rewardRepository;
    }

    /**
     * @Route("/", name="preston", methods={"GET"})
     * @param Request $request
     */
    public function index(Request $request)
    {
        $userDatabase = $this->slackUserRepository->findAll();
        $reward = $this->rewardRepository->findAll();

        return $this->render('preston/list.html.twig', [
            'user' => $this->getUser(),
            'userDatabase' => $userDatabase,
            'reward' => $reward
        ]);
    }

    /**
     * @Route("/reward/{id}", name="add_reward", methods={"GET", "POST"})
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function addReward(Request $request, $id){

        $slackUser = $this->slackUserRepository->find($id);
        $reward = new Reward();
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

        $now = new \DateTime();
        $now->setTimezone(new \DateTimeZone('Brazil/East'));


        $reward->setSlackUser($slackUser);
        $reward->setRewards($rewardsFilterSelected);
        $reward->setDescription($request->request->get("description"));
        $reward->setDate($now);


        $this->rewardRepository->appendReward($reward);

        $this->addFlash('notice', "User rewarded ");

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

    /**
     * @Route("/{id}/remove", name="remove_user")
     * @param SlackUser $slackUser
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */

    public function removeSlackUser(SlackUser $slackUser){
        $this->slackUserRepository->remove($slackUser);
        $this->addFlash('notice', "User deleted");
        return $this->redirectToRoute("preston");
    }
}
