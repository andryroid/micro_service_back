<?php

namespace App\Controller\Api\Post;

use ApiPlatform\Core\Util\RequestAttributesExtractor;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    public function __invoke($data, Request $request)
    {
        $attribute = RequestAttributesExtractor::extractAttributes($request);
        $action = $attribute['collection_operation_name'] ?? $attribute['item_operation_name'] ?? null;
        if (!is_null($action)) {
            if ($action === "create_post") {
                return $this->createPost($data,$request);
            }
        }
    }

    public function createPost($data, Request $request)
    {
        /** @var Post $post */
        $post = $data;
        $post->setUserId($this->getUser()->getId());
        return $post;
    }
}
