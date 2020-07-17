<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EditorCollectionRepository")
 */
class EditorCollection
{
    use RessourceId;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Titre trop long, il doit être au plus {{ limit }} caractères"
     * )
     */
    private string $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Editor", inversedBy="editorCollections")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Editor $editor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Manga", mappedBy="editorCollection")
     * @var ArrayCollection<int, Manga>
     */
    private ArrayCollection $mangas;

    public function __construct()
    {
        $this->mangas = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEditor(): ?Editor
    {
        return $this->editor;
    }

    public function setEditor(?Editor $editor): self
    {
        $this->editor = $editor;

        return $this;
    }

    /**
     * @return ArrayCollection<int, Manga>
     */
    public function getMangas(): ArrayCollection
    {
        return $this->mangas;
    }

    public function addManga(Manga $manga): self
    {
        if (!$this->mangas->contains($manga)) {
            $this->mangas[] = $manga;
            $manga->setEditorCollection($this);
        }

        return $this;
    }

    public function removeManga(Manga $manga): self
    {
        if ($this->mangas->contains($manga)) {
            $this->mangas->removeElement($manga);
            // set the owning side to null (unless already changed)
            if ($manga->getEditorCollection() === $this) {
                $manga->setEditorCollection(null);
            }
        }

        return $this;
    }
}
