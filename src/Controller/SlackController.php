<?php


namespace App\Controller;

use App\Services\CurlRequestDispatcher;
use App\Services\MessageDealer;
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
     * @var MessageDealer
     */
    private $messageDeal;

    /**
     * SlackController constructor.
     * @param CurlRequestDispatcher $requestDispatcher
     * @param MessageDealer $messageDeal
     */
    public function __construct(CurlRequestDispatcher $requestDispatcher, MessageDealer $messageDeal)
    {
        $this->requestDispatcher = $requestDispatcher;
        $this->messageDeal = $messageDeal;
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
        try {
            $user = json_decode($request->getContent(), true)["event"]["user"];
            if(!is_null($user)) {
                $channelId = json_decode($request->getContent(), true)["event"]["channel"];
                $text = json_decode($request->getContent(), true)["event"]["text"];

                $sendMessage = $this->messageDeal->replyMessages($channelId, $text, $user);

                if($sendMessage == "birthday"){
                    $sendMessage = $this->messageDeal->replyMessages($channelId, $text, $user, true);
                }

                return new Response("ok", Response::HTTP_OK);
            }
        }catch (\Exception $exception){
            return new Response($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}