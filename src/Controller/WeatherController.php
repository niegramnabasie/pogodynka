<?php

namespace App\Controller;

use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Location;
use App\Repository\WeatherRepository;

class WeatherController extends AbstractController
{
    public function cityAction(Location $city, WeatherRepository $weatherRepository): Response
    {
        $measurements = $weatherRepository->findByLocation($city);
        return $this->render('weather/city.html.twig', [
            'location' => $city,
            'measurements' => $measurements,
        ]);
    }
}
