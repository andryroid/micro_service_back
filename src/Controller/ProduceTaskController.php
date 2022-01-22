<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MessageService;

class ProduceTaskController extends AbstractController
{
    /**
     * @Route("/produce/task", name="produce_task")
     */
    public function index(MessageService $service): Response
    {
        $service->createMessage(2);
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ProduceTaskController.php',
        ]);
    }
}
