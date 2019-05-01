<?php


namespace App\Controller;

use App\Entity\SlackUser;
use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Repository\UsuarioRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * UserAccess constructor.
     * @param UsuarioRepository $usuarioRepository
     */
    public function __construct(UsuarioRepository $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
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

        return new Response("ok", 200);
    }
}