<?php

namespace App\Tests\Unit;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserFaceEmbeddingTest extends TestCase
{
    public function testSetFaceEmbeddingNullClearsData(): void
    {
        $u = new User();
        $u->setFaceEmbedding(null);

        $this->assertNull($u->getFaceEmbedding());
        $this->assertNull($u->getFaceUpdatedAt());
    }

    public function testSetFaceEmbeddingTooSmallIsRejected(): void
    {
        $u = new User();
        $u->setFaceEmbedding([1, 2, 3]); // trop petit (<64)

        $this->assertNull($u->getFaceEmbedding());
        $this->assertNull($u->getFaceUpdatedAt());
    }
}