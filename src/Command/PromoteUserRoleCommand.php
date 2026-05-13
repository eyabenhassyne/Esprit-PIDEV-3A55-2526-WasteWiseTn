<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:promote-user',
    description: 'Promote an existing user to VALORIZER, PARTNER or ADMIN'
)]
class PromoteUserRoleCommand extends Command
{
    public function __construct(private EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Email de l’utilisateur')
            ->addArgument('type', InputArgument::REQUIRED, 'CITIZEN | VALORIZER | PARTNER | ADMIN');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $input->getArgument('email');
        $type  = strtoupper($input->getArgument('type'));

        $user = $this->em->getRepository(User::class)->findOneBy(['email' => $email]);

        if (!$user) {
            $io->error("Utilisateur introuvable : $email");
            return Command::FAILURE;
        }

        $allowedTypes = [
            User::TYPE_CITIZEN,
            User::TYPE_VALORIZER,
            User::TYPE_PARTNER,
            User::TYPE_ADMIN
        ];

        if (!in_array($type, $allowedTypes, true)) {
            $io->error('Type invalide. Choisis : CITIZEN | VALORIZER | PARTNER | ADMIN');
            return Command::FAILURE;
        }

        // ✅ C’est ici que la magie opère
        $user->setType($type);

        $this->em->flush();

        $io->success("Utilisateur $email promu au type $type");

        return Command::SUCCESS;
    }
}
