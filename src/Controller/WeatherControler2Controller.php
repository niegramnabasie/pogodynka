<?php

namespace App\Controller;

use App\Entity\Weather;
use App\Form\WeatherType;
use App\Repository\WeatherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/weather/controler2')]
class WeatherControler2Controller extends AbstractController
{
    #[Route('/', name: 'app_weather_controler2_index', methods: ['GET'])]
    public function index(WeatherRepository $weatherRepository): Response
    {
        return $this->render('weather_controler2/index.html.twig', [
            'weather' => $weatherRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_weather_controler2_new', methods: ['GET', 'POST'])]
    public function new(Request $request, WeatherRepository $weatherRepository): Response
    {
        $weather = new Weather();
        $form = $this->createForm(WeatherType::class, $weather, [
            'validation_groups' => ['new']
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $weatherRepository->save($weather, true);

            return $this->redirectToRoute('app_weather_controler2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('weather_controler2/new.html.twig', [
            'weather' => $weather,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_weather_controler2_show', methods: ['GET'])]
    public function show(Weather $weather): Response
    {
        return $this->render('weather_controler2/show.html.twig', [
            'weather' => $weather,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_weather_controler2_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Weather $weather, WeatherRepository $weatherRepository): Response
    {
        $form = $this->createForm(WeatherType::class, $weather, [
            'validation_groups' => ['edit']
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $weatherRepository->save($weather, true);

            return $this->redirectToRoute('app_weather_controler2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('weather_controler2/edit.html.twig', [
            'weather' => $weather,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_weather_controler2_delete', methods: ['POST'])]
    public function delete(Request $request, Weather $weather, WeatherRepository $weatherRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$weather->getId(), $request->request->get('_token'))) {
            $weatherRepository->remove($weather, true);
        }

        return $this->redirectToRoute('app_weather_controler2_index', [], Response::HTTP_SEE_OTHER);
    }
}
