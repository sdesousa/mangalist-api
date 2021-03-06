<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRoleRepository")
 * @UniqueEntity(
 *     fields={"role"},
 *     message="Rôle déjà présent"
 * )
 * @ApiResource(
 *     collectionOperations={
 *         "get": {
 *             "normalization_context": {"groups": {"author_role_read", "id"}},
 *             "skip_null_values": false
 *         },
 *         "post"
 *     },
 *     itemOperations={
 *         "get": {
 *             "normalization_context": {"groups": {"author_role_details_read", "id", "timestamp"}},
 *             "skip_null_values": false
 *         },
 *         "put",
 *         "patch",
 *         "delete"
 *     }
 * )
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *         "role": "ipartial"
 *     }
 * )
 * @ApiFilter(
 *     OrderFilter::class,
 *     properties={
 *         "id": "ASC",
 *         "role": {
 *             "default_direction": "ASC",
 *             "nulls_comparison": OrderFilter::NULLS_LARGEST
 *         }
 *     }
 * )
 */
class AuthorRole
{
    use RessourceId;
    use Timestampable;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({
     *     "author_role_read",
     *     "author_role_details_read",
     *     "record_details_read",
     *     "manga_record_details_read",
     *     "manga_author_details_read",
     *     "manga_details_read",
     *     "editor_details_read",
     *     "author_details_read"
     * })
     * @Assert\NotBlank(message="Role obligatoire")
     * @Assert\Length(
     *     max=255,
     *     maxMessage="Role trop long, il doit être au plus {{ limit }} caractères"
     * )
     */
    private string $role;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MangaAuthor", mappedBy="authorRole")
     * @Groups({"author_role_read", "author_role_details_read"})
     *
     * @var Collection<int, MangaAuthor>
     */
    private Collection $mangaAuthors;

    public function __construct()
    {
        $this->mangaAuthors = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, MangaAuthor>
     */
    public function getMangaAuthors(): Collection
    {
        return $this->mangaAuthors;
    }

    public function addMangaAuthor(MangaAuthor $mangaAuthor): self
    {
        if (!$this->mangaAuthors->contains($mangaAuthor)) {
            $this->mangaAuthors[] = $mangaAuthor;
            $mangaAuthor->setAuthorRole($this);
        }

        return $this;
    }

    public function removeMangaAuthor(MangaAuthor $mangaAuthor): self
    {
        if ($this->mangaAuthors->contains($mangaAuthor)) {
            $this->mangaAuthors->removeElement($mangaAuthor);
            // set the owning side to null (unless already changed)
            if ($mangaAuthor->getAuthorRole() === $this) {
                $mangaAuthor->setAuthorRole(null);
            }
        }

        return $this;
    }
}
