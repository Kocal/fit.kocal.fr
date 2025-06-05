<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use App\ValueObject\UserId;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'user_id')]
    private UserId $id;

    /**
     * @var non-empty-string
     */
    #[ORM\Column(length: 180)]
    private string $email;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private string $password;

    public function __construct()
    {
        $this->id = UserId::generate();
    }

    /**
     * Creates a new user instance with the given email, password, and roles.
     *
     * @param non-empty-string $email
     * @param non-empty-string $password
     * @param list<string> $roles
     */
    public static function create(string $email, string $password, array $roles = []): User
    {
        $user = new self();

        $user->email = $email;
        $user->password = $password;
        $user->roles = $roles;

        return $user;
    }

    /**
     * Creates a new user instance with the given email and password, assigning the 'ROLE_ADMIN' role.
     *
     * @param non-empty-string $email
     * @param non-empty-string $password
     */
    public static function createAdmin(string $email, string $password): User
    {
        return static::create($email, $password, ['ROLE_ADMIN']);
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param non-empty-string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
