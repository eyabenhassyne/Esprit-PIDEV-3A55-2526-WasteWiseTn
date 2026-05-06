<?php

namespace App\Tests\Unit\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testEmailNormalization(): void
    {
        $user = new User();

        $user->setEmail(" TEST@MAIL.COM ");

        $this->assertEquals("test@mail.com", $user->getEmail());
    }

    public function testDefaultRoleCitizen(): void
    {
        $user = new User();
        $user->setEmail("test@test.com");

        $roles = $user->getRoles();

        $this->assertContains("ROLE_USER", $roles);
        $this->assertContains("ROLE_CITIZEN", $roles);
    }

    public function testSetTypeAdmin(): void
    {
        $user = new User();
        $user->setType(User::TYPE_ADMIN);

        $roles = $user->getRoles();

        $this->assertContains("ROLE_ADMIN", $roles);
    }

    public function testActivation(): void
    {
        $user = new User();

        $this->assertTrue($user->isActive());

        $user->setIsActive(false);

        $this->assertFalse($user->isActive());
    }

    public function testFaceEmbeddingValid(): void
    {
        $user = new User();

        $embedding = array_fill(0, 64, 0.5);

        $user->setFaceEmbedding($embedding);

        $this->assertTrue($user->hasFaceEmbedding());
    }
}