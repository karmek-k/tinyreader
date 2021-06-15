<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'tr:user:create',
    description: 'Adds a new user.',
)]
class TrUserCreateCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $hasher,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption(
                'admin',
                'a',
                InputOption::VALUE_NONE,
                'Makes the added user an admin',
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $user = new User();

        if ((bool) $input->getOption('admin')) {
            $io->warning('Creating an admin user');
            $user->setRoles(['ROLE_ADMIN']);
        }

        $username = $io->ask('Username');
        $password = $io->askHidden('Password (not visible on the screen)');

        $user
            ->setUsername($username)
            ->setPassword($this->hasher->hashPassword($user, $password));

        $this->em->persist($user);
        $this->em->flush();

        $io->success('User successfully created');

        return Command::SUCCESS;
    }
}
