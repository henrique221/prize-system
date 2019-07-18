<?php


namespace App\Controller;

use App\Services\CurlRequestDispatcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/preston/slack")
 */
class SlackController
{
    /**
     * @var CurlRequestDispatcher
     */
    private $requestDispatcher;

    /**
     * SlackController constructor.
     * @param CurlRequestDispatcher $requestDispatcher
     */
    public function __construct(CurlRequestDispatcher $requestDispatcher)
    {
        $this->requestDispatcher = $requestDispatcher;
    }

    /**
     * @Route("/notification", name="validade_slack", methods={"POST"})
     * @param Request $request
     * @return mixed
     */
    public function slackNotification(Request $request){
//        Receiving Challenge

//        $challenge = (((array) json_decode($request->getContent()))["challenge"]);
//        return new JsonResponse(["challenge" => $challenge], 200);
        return new JsonResponse((array) $request->getContent(), Response::HTTP_OK);
    }
}