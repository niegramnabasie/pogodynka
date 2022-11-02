<?php

namespace App\Service;

use App\Entity\Location;
use App\Repository\LocationRepository;
use App\Repository\WeatherRepository;
use Symfony\Component\HttpFoundation\Response;

class WeatherUtil
{
    private WeatherRepository $weatherRepository;
    private LocationRepository $locationRepository;

    public function __construct(WeatherRepository $weatherRepository, LocationRepository $locationRepository)
    {
        $this->weatherRepository = $weatherRepository;
        $this->locationRepository = $locationRepository;
    }

    public function getWeatherForCountryAndCity(string $country,string $city)
    {
        $cityrep = $this->locationRepository->findBy([
            'coutry' => $country,
            'city' => $city,
        ]);
        return $this->getWeatherForLocation($cityrep[0]);

    }

    public function getWeatherForLocation(Location $city)
    {
        $measurements = $this->weatherRepository->findByLocation($city);
        return $measurements;
    }


}