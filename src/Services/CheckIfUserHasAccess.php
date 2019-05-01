<?php


namespace App\Services;


use App\Entity\SlackUser;
use App\Repository\UsuarioRepository;

class CheckIfUserHasAccess
{
    /**
     * @var UsuarioRepository
     */
    private $usuarioRepository;

    /**
     * checkIfUserHasAccess constructor.
     * @param UsuarioRepository $usuarioRepository
     */
    public function __construct(UsuarioRepository $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    /**
     * @param SlackUser $slackUser
     */
    public function checkAndSetEntityHasAccess(SlackUser $slackUser)
    {
        $user = $this->usuarioRepository->findBy(["userId" => $slackUser->getId()]);
        if(!empty($user)){
            $slackUser->setHasAccess(true);
        }else {
            $slackUser->setHasAccess(false);
        }
    }
}