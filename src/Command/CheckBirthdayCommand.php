<?php

namespace App\Command;

use App\Repository\SlackUserRepository;
use App\Services\SlackService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CheckBirthdayCommand extends Command
{
    protected static $defaultName = 'app:check:birthday';
    /**
     * @var SlackUserRepository
     */
    private $slackUserRepository;
    /**
     * @var SlackService
     */
    private $slackService;

    /**
     * CheckBirthdayCommand constructor.
     * @param string|null $name
     * @param SlackUserRepository $slackUserRepository
     * @param SlackService $slackService
     */
    public function __construct(SlackUserRepository $slackUserRepository, SlackService $slackService, string $name = null)
    {
        parent::__construct($name);
        $this->slackUserRepository = $slackUserRepository;
        $this->slackService = $slackService;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $daysToBirthday = [];

        $slackUsers = $this->slackUserRepository->findAll();

        $now = new \DateTimeImmutable('NOW');
        $now->setTimezone(new \DateTimeZone("America/Sao_Paulo"));
        $currentYear = $now->format("Y");

        foreach ($slackUsers as $slackUser){

            $month = $slackUser->getDataDeNascimento()->format("m");
            $day = $slackUser->getDataDeNascimento()->format("d");
            $nextBirthday = new \DateTime("{$currentYear}-{$month}-{$day}");

            $tenDays = $now->modify("+10 days");
            $fiveDays = $now->modify("+5 days");
            $threeDays = $now->modify("+3 days");
            $oneDay = $now->modify("+1 day");

            if($tenDays->format("d/m/Y") == $nextBirthday->format("d/m/Y")){
                $daysToBirthday[] = array("ten" => $slackUser);
            }elseif ($fiveDays->format("d/m/Y") == $nextBirthday->format("d/m/Y")){
                $daysToBirthday[] = array("five" => $slackUser);
            }elseif ($oneDay->format("d/m/Y") == $nextBirthday->format("d/m/Y")){
                $daysToBirthday[] = array("one" => $slackUser);
            }elseif ($now->format("d/m/Y") == $nextBirthday->format("d/m/Y")){
                $daysToBirthday[] = array("birthday" => $slackUser);
            }elseif ($threeDays->format("d/m/Y") == $nextBirthday->format("d/m/Y")){
                $daysToBirthday[] = array("three" => $slackUser);
            }
        }

        $this->slackService->sendBirthdayNotification($daysToBirthday);

        $output->writeln(["Funcionou"]);
    }
}
