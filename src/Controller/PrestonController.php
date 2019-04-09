<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Repository\UsuarioRepository;
use App\Services\TrelloService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrestonController extends AbstractController
{
    /**
     * @var UsuarioRepository
     */
    private $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

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
        $updateStatus = $trelloService->updateTrelloDatabase();
        if($updateStatus == "ok"){
            return $this->redirectToRoute('preston', ['atualizado' => 'Atualizado']);
        }else{
            return $this->redirectToRoute('preston', ['atualizado' => 'Nao pode ser atualizado']);
        }
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
}
