<?php

namespace App\Tests\Unit;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserEmailTest extends TestCase
{
    public function testEmailIsTrimmedAndLowercased(): void
    {
        $u = new User();
        $u->setEmail('  TEST@EXAMPLE.COM  ');
        $this->assertSame('test@example.com', $u->getEmail());
    }
}