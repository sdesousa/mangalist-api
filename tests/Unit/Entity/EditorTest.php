<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Editor;
use App\Entity\EditorCollection;
use App\Entity\Manga;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class EditorTest extends TestCase
{
    private Editor $editor;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->editor = new Editor();
    }

    public function testGetName(): void
    {
        $value = 'Tonkam';
        $response = $this->editor->setName($value);

        self::assertInstanceOf(Editor::class, $response);
        self::assertEquals($value, $this->editor->getName());
    }

    public function testGetManga(): void
    {
        $manga1 = new Manga();
        $manga2 = new Manga();
        $manga3 = new Manga();

        $this->editor->addManga($manga1);
        $this->editor->addManga($manga2);
        $this->editor->addManga($manga3);

        self::assertCount(3, $this->editor->getMangas());
        self::assertTrue($this->editor->getMangas()->contains($manga1));
        self::assertTrue($this->editor->getMangas()->contains($manga2));
        self::assertTrue($this->editor->getMangas()->contains($manga3));

        $response = $this->editor->removeManga($manga3);

        self::assertInstanceOf(Editor::class, $response);
        self::assertCount(2, $this->editor->getMangas());
        self::assertTrue($this->editor->getMangas()->contains($manga1));
        self::assertTrue($this->editor->getMangas()->contains($manga2));
        self::assertFalse($this->editor->getMangas()->contains($manga3));
    }

    public function testGetEditorCollections(): void
    {
        $editorCollection1 = new EditorCollection();
        $editorCollection2 = new EditorCollection();
        $editorCollection3 = new EditorCollection();

        $this->editor->addEditorCollection($editorCollection1);
        $this->editor->addEditorCollection($editorCollection2);
        $this->editor->addEditorCollection($editorCollection3);

        self::assertCount(3, $this->editor->getEditorCollections());
        self::assertTrue($this->editor->getEditorCollections()->contains($editorCollection1));
        self::assertTrue($this->editor->getEditorCollections()->contains($editorCollection2));
        self::assertTrue($this->editor->getEditorCollections()->contains($editorCollection3));

        $response = $this->editor->removeEditorCollection($editorCollection3);

        self::assertInstanceOf(Editor::class, $response);
        self::assertCount(2, $this->editor->getEditorCollections());
        self::assertTrue($this->editor->getEditorCollections()->contains($editorCollection1));
        self::assertTrue($this->editor->getEditorCollections()->contains($editorCollection2));
        self::assertFalse($this->editor->getEditorCollections()->contains($editorCollection3));
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTime();
        $response = $this->editor->setUpdatedAt($updatedAt);

        self::assertInstanceOf(Editor::class, $response);
        self::assertEquals($updatedAt, $this->editor->getUpdatedAt());
    }
}
