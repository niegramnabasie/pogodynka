<?php

namespace App\Controller;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Location;
use App\Repository\WeatherRepository;

class WeatherController extends AbstractController
{
    public function cityAction(Location $city, WeatherUtil $util): Response
    {

        $measurements = $util->getWeatherForLocation($city);
        return $this->render('weather/city.html.twig', [
            'location' => $city,
            'measurements' => $measurements,
        ]);
    }

    public function countryCityAction(string $country,string $city,WeatherUtil $util): Response
    {
        $measurements = $util->getWeatherForCountryAndCity($country, $city);
        return $this->render('weather/countryandcity.html.twig', [
            'country' => $country,
            'nameCity' => $city,
            'measurements' => $measurements,
        ]);
    }
}
