<?php

namespace App\Command;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Repository\RoomRepository;
use App\Entity\Room;

class ListRoomCommand extends Command
{
    protected static $defaultName = 'app:list-room';
    protected static $defaultDescription = 'Add a short description for your command';
    /**
     * @var RoomRepository
     */
    private $roomRepository;
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->roomRepository= $container->get('doctrine')->getManager()->getRepository(Room::class);
    }
    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        $rooms = $this->roomRepository->findAll();
        if(!$rooms) {
            $output->writeln('<comment>no rooms found<comment>');
            exit(1);
        }
        
        foreach($rooms as $room)
        {
            $output->writeln($room);
            
            
            
        }
        
        
        
        return 0;
    }
}
