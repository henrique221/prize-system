<?php


namespace App\Controller;

use App\Entity\SlackUser;
use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Repository\SlackUserRepository;
use App\Repository\UsuarioRepository;
use App\Services\CheckIfUserHasAccess;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserAccess
 * @Route("/preston/user/access")
 * @package App\Controller
 */
class UserAccess extends AbstractController
{
    /**
     * @var UsuarioRepository
     */
    private $usuarioRepository;
    /**
     * @var CheckIfUserHasAccess
     */
    private $checkIfUserHasAccess;
    /**
     * @var SlackUserRepository
     */
    private $slackUserRepository;

    /**
     * UserAccess constructor.
     * @param UsuarioRepository $usuarioRepository
     * @param CheckIfUserHasAccess $checkIfUserHasAccess
     * @param SlackUserRepository $slackUserRepository
     */
    public function __construct(UsuarioRepository $usuarioRepository, CheckIfUserHasAccess $checkIfUserHasAccess, SlackUserRepository $slackUserRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
        $this->checkIfUserHasAccess = $checkIfUserHasAccess;
        $this->slackUserRepository = $slackUserRepository;
    }

    /**
     * @Route("/save/{id}", name="save_user_access", methods={"POST"})
     * @param Request $request
     * @param SlackUser $slackUser
     * @return Response
     */
    public function saveUserAccess(Request $request, SlackUser $slackUser)
    {
        /** @var Usuario $user */
        $user = $slackUser->getUserAccess();


        $userForm = $this->createForm(UsuarioType::class, $user);
        $userForm->handleRequest($request);


        $this->usuarioRepository->save($user);

        $this->addFlash("notice", "Access saved successfully");

        return $this->redirectToRoute("edit_user", ["id" => $slackUser->getId()]);
    }

    /**
     * @Route("/add/user/{id}", name="add_user_access")
     * @param SlackUser $slackUser
     * @return RedirectResponse
     */
    public function addUserAccess(SlackUser $slackUser)
    {
        if(empty($slackUser->getDataDeNascimento())){
            $this->addFlash("error", "User needs to have a birthdate");
        }else {
            $this->checkIfUserHasAccess->checkAndSetEntityHasAccess($slackUser);
            $check = $slackUser->getHasAccess();
            if ($check == false) {
                $this->checkIfUserHasAccess->addAccessToSlackUser($slackUser);
            }
        }
        return $this->redirectToRoute("edit_user", ["id" => $slackUser->getId()]);
    }
}