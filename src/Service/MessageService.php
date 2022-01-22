<?php

namespace App\Service;

use App\Rabbit\MessagingProducer;
use Symfony\Component\HttpFoundation\JsonResponse;

class MessageService
{
    private $messagingProducer;

    public function __construct(MessagingProducer $messagingProducer)
    {
        $this->messagingProducer = $messagingProducer;
    }

    public function createMessage(int $numberOfUsers): JsonResponse
    {
            $message = json_encode([
                'sender' => "sender",
                'receiver' => "email",
                'message' => "text",
            ]);

            $this->messagingProducer->publish($message,"ty");

        return new JsonResponse(['status' => 'Sent!']);
    }
}