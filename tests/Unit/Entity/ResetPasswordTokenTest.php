<?php

namespace App\Tests\Unit\Entity;

use App\Entity\ResetPasswordToken;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class ResetPasswordTokenTest extends TestCase
{
    public function testTokenIsExpired(): void
    {
        $token = new ResetPasswordToken();

        $token->setExpiresAt(new \DateTimeImmutable("-10 minutes"));

        $this->assertTrue($token->isExpired());
    }

    public function testTokenNotExpired(): void
    {
        $token = new ResetPasswordToken();

        $token->setExpiresAt(new \DateTimeImmutable("+10 minutes"));

        $this->assertFalse($token->isExpired());
    }

    public function testTokenUsed(): void
    {
        $token = new ResetPasswordToken();

        $this->assertFalse($token->isUsed());

        $token->setUsedAt(new \DateTimeImmutable());

        $this->assertTrue($token->isUsed());
    }

    public function testSetUser(): void
    {
        $user = new User();
        $user->setEmail("test@test.com");

        $token = new ResetPasswordToken();
        $token->setUser($user);

        $this->assertEquals($user, $token->getUser());
    }
}