<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *     fields={"email"},
 *     message="Email déjà utilisé"
 * )
 * @ApiResource(
 *     collectionOperations={
 *         "get": {
 *             "normalization_context": {"groups": {"user_read", "id"}}
 *         },
 *         "post"
 *     },
 *     itemOperations={
 *         "get": {
 *             "normalization_context": {"groups": {"user_details_read", "id", "timestamp"}}
 *         },
 *         "put",
 *         "patch",
 *         "delete"
 *     }
 * )
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *         "email": "ipartial"
 *     }
 * )
 * @ApiFilter(
 *     OrderFilter::class,
 *     properties={
 *         "id": "ASC",
 *         "email": {
 *             "default_direction": "ASC",
 *             "nulls_comparison": OrderFilter::NULLS_LARGEST
 *         }
 *     }
 * )
 */
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    use RessourceId;
    use Timestampable;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\NotBlank(message="Email obligatoire")
     * @Assert\Email(message="Format invalide")
     * @Assert\Length(
     *     max=255,
     *     maxMessage="Email trop long, il doit être au plus {{ limit }} caractères"
     * )
     * @Groups({"user_read", "user_details_read"})
     */
    private string $email;

    /**
     * @ORM\Column(type="json")
     *
     * @var array<string>
     */
    private array $roles = [];

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Mot de passe obligatoire")
     * @Assert\Length(
     *     max=255,
     *     maxMessage="Mot de passe trop long, il doit être au plus {{ limit }} caractères"
     * )
     *
     * @var string The hashed password
     */
    private string $password;

    /**
     * @ORM\OneToOne(targetEntity=Record::class, mappedBy="user", cascade={"persist", "remove"})
     * @Groups({"user_read", "user_details_read"})
     *
     * @var ?Record
     */
    private ?Record $record;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return array<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array<string> $roles
     *
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getRecord(): ?Record
    {
        return $this->record;
    }

    public function setRecord(Record $record): self
    {
        $this->record = $record;

        // set (or unset) the owning side of the relation if necessary
        if ($record->getUser() !== $this) {
            $record->setUser($this);
        }

        return $this;
    }
}
