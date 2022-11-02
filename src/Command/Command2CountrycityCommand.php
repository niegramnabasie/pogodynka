<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'command2:countrycity',
    description: 'Add a short description for your command',
)]
class Command2CountrycityCommand extends Command
{
    private WeatherUtil $weatherUtil;

    public function __construct(WeatherUtil $weatherUtil, LocationRepository $locationRepository, string $name = null)
    {
        $this->weatherUtil = $weatherUtil;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('countryName', InputArgument::REQUIRED, 'Name of country')
            ->addArgument('cityName', InputArgument::REQUIRED, 'Name of city')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $cityName = $input->getArgument('cityName');
        $countryName = $input->getArgument('countryName');

        $measurements  = $this->weatherUtil->getWeatherForCountryAndCity($countryName, $cityName);

        $result = [
            'city' => $cityName,
            'coutry' => $countryName,
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