<?php

namespace App\Tests\Unit\Entity;

use App\Entity\MangaRecord;
use App\Entity\Record;
use App\Entity\User;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class RecordTest extends TestCase
{
    private Record $record;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->record = new Record();
    }

    public function testGetUser(): void
    {
        $user = new User();
        $response = $this->record->setUser($user);

        self::assertInstanceOf(Record::class, $response);
        self::assertEquals($user, $this->record->getUser());
    }

    public function testGetMangaRecords(): void
    {
        $mangaRecord1 = new MangaRecord();
        $mangaRecord2 = new MangaRecord();
        $mangaRecord3 = new MangaRecord();

        $this->record->addMangaRecord($mangaRecord1);
        $this->record->addMangaRecord($mangaRecord2);
        $this->record->addMangaRecord($mangaRecord3);

        self::assertCount(3, $this->record->getMangaRecords());
        self::assertTrue($this->record->getMangaRecords()->contains($mangaRecord1));
        self::assertTrue($this->record->getMangaRecords()->contains($mangaRecord2));
        self::assertTrue($this->record->getMangaRecords()->contains($mangaRecord3));

        $response = $this->record->removeMangaRecord($mangaRecord3);

        self::assertInstanceOf(Record::class, $response);
        self::assertCount(2, $this->record->getMangaRecords());
        self::assertTrue($this->record->getMangaRecords()->contains($mangaRecord1));
        self::assertTrue($this->record->getMangaRecords()->contains($mangaRecord2));
        self::assertFalse($this->record->getMangaRecords()->contains($mangaRecord3));
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTime();
        $response = $this->record->setUpdatedAt($updatedAt);

        self::assertInstanceOf(Record::class, $response);
        self::assertEquals($updatedAt, $this->record->getUpdatedAt());
    }
}
