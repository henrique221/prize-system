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
        $sendMessageUrlToTest = "https://hooks.slack.com/services/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";
        $this->requestDispatcher->post($sendMessageUrlToTest, ["blocks" => [["type" => "divider"], ["type" => "section", "text" => ["type" => "mrkdwn", "text" => "{$request->getContent()}"], "accessory" => ["type" => "image", "image_url" => "https://i2.wp.com/www.wakeed.org/wp-content/uploads/2016/07/award-icon-06.png", "alt_text" => "reward"]], ["type" => "divider"]]]);

        var_dump($request->getContent());
        return new JsonResponse($request->getContent(), Response::HTTP_OK);
    }
}