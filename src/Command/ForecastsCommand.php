<?php

namespace App\Command;

use App\Repository\ForecastRepository;
use App\Repository\LocationRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:forecasts',
    description: 'Add a short description for your command',
)]
class ForecastsCommand extends Command
{
    public function __construct(
        private LocationRepository $locationRepository,
        private ForecastRepository $forecastRepository
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('cityName', InputArgument::REQUIRED, 'City name')
            ->addArgument('countryCode', InputArgument::REQUIRED, 'Country code')
            
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $cityName = $input->getArgument('cityName');
        $countryCode = $input->getArgument('countryCode');

        if($cityName && $countryCode) {
            $io->title("Forecasts for $cityName, $countryCode");
            
            $location = $this->locationRepository->findOneBy([
                'countryCode'=>trim($countryCode),
                'name' => trim($cityName)
            ]);

            if(!$location)
            {
                throw new \Exception("Location not found");
            }

            $forecasts = $this->forecastRepository->findBy(['location' => $location->getId()]);
            if($forecasts) 
            {
                $titles = [
                    'Date', 'Temperature', 'Feels like', 'Pressure', 'Humidity', 'Wind Speed', 'Wind Degree', 'Cloudiness', 'Icon' 
                ];
                $data = [];
                foreach($forecasts as $forecast)
                {
                    $data [] = 
                    [ 
                        $forecast->getDate()->format('d-m-Y'), 
                        $forecast->getTemperatureCelsius(), 
                        $forecast->getflTemperatureCelsius(), 
                        $forecast->getPressure(), 
                        $forecast->getHumidity(), 
                        $forecast->getWindSpeed(), 
                        $forecast->getWindDeg(), 
                        $forecast->getCloudiness(), 
                        $forecast->getIcon()  
                    ];
                }
                $io->horizontalTable(
                    $titles,
                    $data
                    );
            }
            else
            {
                $io->warning("$cityName , $countryCode haven't got forecasts");
            }
        }
        

        return Command::SUCCESS;
    }
}
