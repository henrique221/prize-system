<?php

namespace App\Controller;

use App\DTO\UserRewardsDto;
use App\Entity\Reward;
use App\Entity\SlackUser;
use App\Entity\Usuario;
use App\Form\SlackUserType;
use App\Form\UsuarioType;
use App\Repository\RewardRepository;
use App\Repository\SlackUserRepository;
use App\Repository\UsuarioRepository;
use App\Services\SlackService;
use App\Services\UserRewardsService;
use App\Services\CheckIfUserHasAccess;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
    /**
     * @var UserRewardsService
     */
    private $userRewardsService;
    /**
     * @var SlackService
     */
    private $slackService;

    public function __construct(UsuarioRepository $usuarioRepository, SlackUserRepository $slackUserRepository, RewardRepository $rewardRepository, UserRewardsService $userRewardsService, SlackService $slackService)
    {
        $this->usuarioRepository = $usuarioRepository;
        $this->slackUserRepository = $slackUserRepository;
        $this->rewardRepository = $rewardRepository;
        $this->userRewardsService = $userRewardsService;
        $this->slackService = $slackService;
    }

    /**
     * @Route("/", name="prestonIndex")
     * @return RedirectResponse
     */
    public function index(){
        return $this->redirectToRoute("preston");
    }

    /**
     * @Route("/list", name="preston", methods={"GET"})
     * @return Response
     */
    public function preston()
    {
        $slackUsers = $this->slackUserRepository->findAll();

        $usersAndRewards = [];
        foreach ($slackUsers as $slackUser) {
            $usersAndRewards[] = $this->userRewardsService->generateSlackUserRewardDto($slackUser);
        }

        $reward = $this->rewardRepository->findAll();

        return $this->render('preston/list.html.twig', [
            'user' => $this->getUser(),
            'userAndRewards' => $usersAndRewards,
            'reward' => $reward
        ]);
    }

    /**
     * @Route("/reward/{id}", name="add_reward", methods={"GET", "POST"})
     * @param Request $request
     * @param SlackUser $slackUser
     * @return Response
     * @throws Exception
     */
    public function addReward(Request $request, SlackUser $slackUser)
    {

        $reward = new Reward();
        $rewards = [
            1 => "dare",
            2 => "create",
            3 => "do it",
            4 => "conect",
            5 => "deliver"
        ];

        $tags = explode(",", $request->request->get("tags"));
        $rewardsFilterSelected = [];

        foreach ($tags as $tag) {
            $rewardsFilterSelected[] = $rewards[$tag];
        }

        dump($rewardsFilterSelected);

        $now = new \DateTime();
        $now->setTimezone(new \DateTimeZone('Brazil/East'));

        $description = $request->request->get("description");

        $reward->setSlackUser($slackUser);
        $reward->setRewards($rewardsFilterSelected);
        $reward->setDescription($description);
        $reward->setDate($now);
        $reward->setIdWhoRewarded($this->getUser()->getId());


        $this->rewardRepository->appendReward($reward);

        $this->slackService->sendMessageToUser($slackUser, $rewardsFilterSelected, $description, $this->getUser());

        $this->addFlash('notice', "User rewarded ");

        return $this->redirectToRoute("preston");
    }

    /**
     * @Route("/update", name="update_trello_database", methods={"GET", "POST"})
     * @param SlackService $slackService
     * @return Response
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
     * @return RedirectResponse|Response
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
     * @param SlackService $slackService
     * @param CheckIfUserHasAccess $checkIfUserHasAccess
     * @return Response
     */
    public function checkSlackUserInDatabaseAndAddToDatabase(Request $request, SlackService $slackService, CheckIfUserHasAccess $checkIfUserHasAccess)
    {
        $userId = $request->request->get("userId");

        $status = $slackService->updateSlackDatabase($userId);

        return new JsonResponse($userId, $status->getStatusCode());
    }

    /**
     * @Route("/edit/user/{id}", name="edit_user", methods={"GET", "POST"})
     * @param SlackUser $slackUser
     * @param Request $request
     * @return Response
     */
    public function editUser(Request $request, SlackUser $slackUser, CheckIfUserHasAccess $checkIfUserHasAccess)
    {

        $checkIfUserHasAccess->checkAndSetEntityHasAccess($slackUser);

        $form = $this->createForm(SlackUserType::class, $slackUser);
        $form->handleRequest($request);

        if(!empty($slackUser->getUserAccess())){
            $usuario = $slackUser->getUserAccess();
            $userSaveForm = $this->createForm(UsuarioType::class, $usuario);
        }


        if ($form->isSubmitted() && $form->isValid()) {
            $this->slackUserRepository->save($slackUser);

            $this->addFlash('notice', "User edited sucessfully");
            return $this->redirectToRoute('edit_user', array('id' => $slackUser->getId()));
        }

        if(isset($userSaveForm)) {
            return $this->render("preston/editUser.html.twig", array(
                'form' => $form->createView(),
                'slackUser' => $slackUser,
                'userSaveForm' => $userSaveForm->createView()
            ));
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
    public function getAmountRewards(SlackUser $slackUser)
    {
        return new Response(count($slackUser->getPremios()));
    }

    /**
     * @Route("/{id}/remove", name="remove_user")
     * @param SlackUser $slackUser
     * @return RedirectResponse
     */

    public function removeSlackUser(SlackUser $slackUser)
    {
        $this->slackUserRepository->remove($slackUser);
        $this->addFlash('notice', "User deleted");
        return $this->redirectToRoute("preston");
    }

    /**
     * @Route("/{id}/rewards/show", name="show_user_rewards")
     * @param SlackUser $slackUser
     * @return Response
     */
    public function showRewardsSlackUser(SlackUser $slackUser)
    {

        $usersAndRewards = $this->userRewardsService->generateSlackUserRewardDto($slackUser);

        return $this->render("preston/userRewards.html.twig", [
            'userAndRewards' => $usersAndRewards
        ]);
    }
}
