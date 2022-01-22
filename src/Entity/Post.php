<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 * @ApiResource(
 *     itemOperations = {
 *           "get"
 *     },
 *     collectionOperations = {
 *          "create_post" = {
 *              "normalization_context" = {"groups" = {"read:created_post"}},
 *              "method" = "post",
 *              "controller" = App\Controller\Api\Post\PostController::class,
 *              "path" = "/posts/create_post"
 *          }
 *     }
 * )
 *
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:created_post"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"read:created_post"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:created_post"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:created_post"})
     */
    private $content;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read:created_post"})
     */
    private $user_id;

    public function __construct()
    {
        $this->created_at = \DateTimeImmutable::createFromMutable(new \DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}
