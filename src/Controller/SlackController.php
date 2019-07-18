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
        try {
            $channelId = ((array) json_decode($request->getContent()))["event"]["channel"];
            $text = ((array) json_decode($request->getContent()))["event"]["text"];
            $textToUser = $text;
            $sendMessageUrlToUser = "https://slack.com/api/chat.postMessage?token=xoxb-260471979411-591809437588-ODmeN9mFCJV5cHN2byap3evc&channel={$channelId}&text={$textToUser}&pretty=1";
            $text = json_decode($request->getContent(), true)["event"]["text"];
            if(!is_null($text)) {
                $this->requestDispatcher->post($sendMessageUrlToUser);
            }
            return new Response("ok", Response::HTTP_OK);
        }catch (\Exception $exception){
            return new Response($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}