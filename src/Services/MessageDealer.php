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

    public function replyMessages($channel, $text, $user, $canChooseBirthday = false)
    {
        if ($user != "UHDPTCVHA") {
            switch ($text) {
                case "oi":
                case "ola":
                case "olá":
                case "Oi":
                case "Ola":
                case "Olá":
                    $textToUser = rawurlencode("Oi, como posso ajudar ?");
                    $this->sendMessageToSlackUser($channel, $textToUser);
                    break;
                case "birthday":
                case "aniversário":
                case "niver":
                case "aniversario":
                    $textToUser = rawurlencode("Me diga o nome de alguem que você quer saber o aniversário");
                    $this->sendMessageToSlackUser($channel, $textToUser);
                    return "birthdayChoose";
                case "posso escolher":
                    if($canChooseBirthday){
                        $textToUser = rawurlencode("sim");
                        $this->sendMessageToSlackUser($channel, $textToUser);
                    }else{
                        $textToUser = rawurlencode("não");
                        $this->sendMessageToSlackUser($channel, $textToUser);
                    }
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