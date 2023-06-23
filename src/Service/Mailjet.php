<?php

namespace App\Service;

use Mailjet\Client;
use App\Entity\User;
use Mailjet\Resources;


class Mailjet
{
    private $mailjetKey;
    private $mailjetKeySecret;

    public function __construct($mailjetKey, $mailjetKeySecret)
    {
        $this->mailjetKey = $mailjetKey;
        $this->mailjetKeySecret = $mailjetKeySecret;
    }


    public function generateSingleBody(User $user, string $message): array
    {
        return [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "maximeflament91@gmail.com",
                        'Name' => "inscription"
                    ],
                    'To' => [
                        [
                            'Email' => $user->getEmail(),
                            'Name' => $user->getFirstname()
                        ]
                    ],
                    'TemplateID' => 4904021,
                    'TemplateLanguage' => true,
                    'Subject' => "inscription",
                    'Variables' => [
                        'body' => $message
                    ]
                ]
            ]
        ];
    }



    public function send(array $body): void
    {
        $mj = new Client($this->mailjetKey, $this->mailjetKeySecret, true, ['version' => 'v3.1']);
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }


    public function sendEmail(User $user, string $myMessage): void
    {
        $this->send($this->generateSingleBody($user, $myMessage));
    }
}