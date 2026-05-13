<?php

namespace App\Service;

use App\Entity\ResetPasswordToken;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ResetPasswordService
{
    private string $appUrl;

    public function __construct(
        private EntityManagerInterface $em,
        private MailerInterface $mailer,
        string $appUrl
    ) {
        $this->appUrl = rtrim($appUrl, '/');
    }

    public function createToken(User $user, int $ttlMinutes = 30): ResetPasswordToken
    {
        $oldTokens = $this->em->getRepository(ResetPasswordToken::class)
            ->findBy(['user' => $user, 'usedAt' => null]);

        foreach ($oldTokens as $t) {
            $t->setUsedAt(new \DateTimeImmutable());
        }

        $token = new ResetPasswordToken();
        $token->setUser($user);
        $token->setToken(bin2hex(random_bytes(32)));
        $token->setExpiresAt((new \DateTimeImmutable())->modify("+{$ttlMinutes} minutes"));

        $this->em->persist($token);
        $this->em->flush();

        return $token;
    }

    public function sendResetEmail(User $user, ResetPasswordToken $token): void
    {
        $resetLink = $this->appUrl . '/reset-password/' . $token->getToken();

        $email = (new Email())
            ->from('no-reply@wastewise.tn')
            ->to($user->getEmail())
            ->subject('Réinitialisation de votre mot de passe')
            ->html("
                <p>Bonjour,</p>
                <p>Pour réinitialiser votre mot de passe, cliquez ici :</p>
                <p><a href=\"{$resetLink}\">Réinitialiser mon mot de passe</a></p>
                <p>Ce lien expire bientôt.</p>
            ");

        $this->mailer->send($email);
    }
}