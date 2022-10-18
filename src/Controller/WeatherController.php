<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Location;
use App\Repository\WeatherRepository;

class WeatherController extends AbstractController
{
    public function cityAction(Location $city, WeatherRepository $weatherRepository): Response
    {
        $weather = $weatherRepository->findByLocation($city);
        return $this->render('weather/city.html.twig', [
            'location' => $city,
            'measurements' => $weather,
        ]);
    }
}
