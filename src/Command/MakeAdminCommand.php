<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:user:make-admin',
    description: 'Passe un utilisateur en ADMIN (type=ADMIN + ROLE_ADMIN)'
)]
class MakeAdminCommand extends Command
{
    public function __construct(
        private UserRepository $repo,
        private EntityManagerInterface $em
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('email', InputArgument::REQUIRED, 'Email de l’utilisateur');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = (string) $input->getArgument('email');
        $user = $this->repo->findOneBy(['email' => $email]);

        if (!$user) {
            $output->writeln("<error>Utilisateur introuvable: $email</error>");
            return Command::FAILURE;
        }

        // ✅ IMPORTANT: ton getRoles() dépend de $type
        $user->setType(User::TYPE_ADMIN);

        // ✅ On garde aussi la colonne roles propre (optionnel mais ok)
        $roles = $user->getRoles(); // contient déjà ROLE_ADMIN via type
        if (!in_array('ROLE_ADMIN', $roles, true)) $roles[] = 'ROLE_ADMIN';
        if (!in_array('ROLE_USER', $roles, true)) $roles[] = 'ROLE_USER';
        $user->setRoles(array_values(array_unique($roles)));

        $this->em->flush();

        $output->writeln("<info>OK: $email est maintenant ADMIN</info>");
        return Command::SUCCESS;
    }
}
