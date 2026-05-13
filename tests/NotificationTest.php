<?php

namespace App\Tests;

use App\Entity\Notification;
use PHPUnit\Framework\TestCase;

class NotificationTest extends TestCase
{
    // Test 1: Thabbet fil attributes el kol (Title, Message, isRead)
    public function testNotificationAttributes(): void
    {
        $notification = new Notification();
        $date = new \DateTimeImmutable();

        $notification->setTitle("Nouvelle Participation")
                     ->setMessage("Un citoyen s'est inscrit à votre événement.")
                     ->setCreatedAt($date)
                     ->setIsRead(false);

        $this->assertEquals("Nouvelle Participation", $notification->getTitle());
        $this->assertEquals("Un citoyen s'est inscrit à votre événement.", $notification->getMessage());
        $this->assertEquals($date, $notification->getCreatedAt());
        $this->assertFalse($notification->isRead());
    }

    // Test 2: Thabbet fil initial state (Null values)
    public function testInitialState(): void
    {
        $notification = new Notification();
        
        $this->assertNull($notification->getTitle());
        $this->assertNull($notification->getMessage());
        $this->assertNull($notification->isRead());
    }
}