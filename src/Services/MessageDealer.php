<?php


namespace App\Services;


class MessageDealer
{
    /**
     * @var CurlRequestDispatcher
     */
    private $requestDispatcher;

    /**
     * MessageReply constructor.
     * @param CurlRequestDispatcher $requestDispatcher
     */
    public function __construct(CurlRequestDispatcher $requestDispatcher)
    {
        $this->requestDispatcher = $requestDispatcher;
    }

    public function replyMessages($channel, $text, $user)
    {
        if ($user != "UHDPTCVHA") {
            switch ($text) {
                case "oi":
                    $textToUser = rawurlencode("Oi, como posso ajudar ?");
                    $this->sendMessageToSlackUser($channel, $textToUser);
                    break;
                case "birthday":
                case "aniversário":
                    $textToUser = rawurlencode("Me diga o nome de alguem que você quer saber o aniversário");
                    $this->sendMessageToSlackUser($channel, $textToUser);
                    break;
                default:
                    $textToUser = rawurlencode("Desculpe, não entendi");
                    $this->sendMessageToSlackUser($channel, $textToUser);
            }
        }
    }

    /**
     * @param $channel
     * @param string $textToUser
     */
    private function sendMessageToSlackUser($channel, string $textToUser): void
    {
        $sendMessageUrlToUser = "https://slack.com/api/chat.postMessage?token=xoxb-260471979411-591809437588-ODmeN9mFCJV5cHN2byap3evc&channel={$channel}&text={$textToUser}&pretty=1";
        $this->requestDispatcher->post($sendMessageUrlToUser);
    }
}