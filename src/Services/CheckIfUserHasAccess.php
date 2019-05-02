<?php


namespace App\Services;


use App\Entity\SlackUser;
use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Repository\SlackUserRepository;
use App\Repository\UsuarioRepository;

class CheckIfUserHasAccess
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
     * checkIfUserHasAccess constructor.
     * @param UsuarioRepository $usuarioRepository
     * @param SlackUserRepository $slackUserRepository
     */
    public function __construct(UsuarioRepository $usuarioRepository, SlackUserRepository $slackUserRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
        $this->slackUserRepository = $slackUserRepository;
    }

    /**
     * @param SlackUser $slackUser
     */
    public function checkAndSetEntityHasAccess(SlackUser $slackUser)
    {
        $user = $this->usuarioRepository->findBy(["userId" => $slackUser->getId()]);
        if (!empty($user)) {
            $slackUser->setHasAccess(true);
            $this->slackUserRepository->save($slackUser);
        } else {
            $slackUser->setHasAccess(false);
            $this->slackUserRepository->save($slackUser);
        }
    }

    /**
     * @param SlackUser $slackUser
     * @return Usuario
     */
    public function addAccessToSlackUser(SlackUser $slackUser)
    {
        $usuario = new Usuario();

        $login = (strtolower(str_replace(" ", ".", $slackUser->getUsername())));
        $password = ($slackUser->getDataDeNascimento()->format("dmY"));

        $usuario
            ->setLogin($login)
            ->setSenha($password)
            ->setUserId($slackUser);

        $usuario->setName($slackUser->getUsername());

        $usuario->setPermissoes(array("ROLE_USER"));

        //Persiste o usuario novo
        $this->usuarioRepository->persist($usuario);

        $returnUser = $this->usuarioRepository->findBy(["userId" => $slackUser]);

        //Salva o usuario no slackUser
        $slackUser->setUserAccess($returnUser[0]);

        $this->slackUserRepository->save($slackUser);

        return $usuario;
    }
}