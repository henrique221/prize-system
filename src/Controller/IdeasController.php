<?php


namespace App\Controller;


use App\Services\SlackService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IdeasController
 * @package App\Controller
 * @Route("preston/idea/", name="ideas_")
 */
class IdeasController extends AbstractController
{
    /**
     * @var SlackService
     */
    private $slackService;

    /**
     * IdeasController constructor.
     * @param SlackService $slackService
     */
    public function __construct(SlackService $slackService)
    {
        $this->slackService = $slackService;
    }

    /**
     * @Route("new", name="new", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function newIdea(Request $request)
    {
        if($request->getMethod() == "POST"){
            $sendMessageToManager = $this->slackService->sendMessageToManager($request->request->get('ideaText'), $this->getUser());
            if($sendMessageToManager == "sent"){
                $this->addFlash("notice", "idea sent");
                $this->redirectToRoute("ideas_new");
            }else{
                $this->addFlash("error", "idea couldn`t be sent");
                $this->redirectToRoute("ideas_new");
            }
        }
        return $this->render("ideas/new.html.twig", array(
            "user" => $this->getUser()
        ));
    }
}