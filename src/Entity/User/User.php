<?php


namespace App\Entity\User;


use Symfony\Component\Security\Core\User\UserInterface;


class User implements UserInterface
{
    /**
     * @var string
     */
    private $username;
    /**
     * @var array
     */
    private $roles;
    /**
     * @var int
     */
    private $id;

    /**
     * User constructor.
     * @param string $username
     * @param array $roles
     * @param int $id
     */
    public function __construct(
        string $username,
        array $roles,
        int $id
    )
    {
        $this->username = $username;
        $this->roles = $roles;
        $this->id = $id;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier()
    {
        return $this->username;
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }

    /**
     * @return string
     *
     * @deprecated since Symfony 5.3, use getUserIdentifier() instead
     */
    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

    public function getId() : int
    {
        return $this->id;
    }
}