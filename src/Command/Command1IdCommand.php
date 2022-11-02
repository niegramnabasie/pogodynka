<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Repository\WeatherRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'command1:id',
    description: 'Add a short description for your command',
)]
class Command1IdCommand extends Command
{
    private WeatherUtil $weatherUtil;
    private LocationRepository $locationRepository;

    public function __construct(WeatherUtil $weatherUtil, LocationRepository $locationRepository, string $name = null)
    {
        $this->weatherUtil = $weatherUtil;
        $this->locationRepository = $locationRepository;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('cityId', InputArgument::REQUIRED, 'Id of city')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $cityId = $input->getArgument('cityId');

        $city = $this->locationRepository->find($cityId);
        $measurements  = $this->weatherUtil->getWeatherForLocation($city);

        $result = [
            'city' => $city->getCity(),
            'coutry' => $city->getCoutry(),
            'measurements' => [],
        ];

        foreach ($measurements as $measurement) {
            $result['measurements'][] = [
                'date' => $measurement->getDate()->format('Y-m-d'),
                '$degrees_day' => $measurement->getDegreesDay(),
                '$degrees_night' => $measurement->getDegreesNight(),
                '$humidity' => $measurement->getHumidity(),
            ];
        }

        $output->writeln(json_encode($result, JSON_PRETTY_PRINT));

        return Command::SUCCESS;
    }
}
