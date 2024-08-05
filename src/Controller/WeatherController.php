<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('weather')]
class WeatherController extends AbstractController
{
    #[Route('/{countryCode}/{cityName}')]
    public function forecast(string $countryCode, string $cityName): Response
    {
        return $this->render('weather/forecast.html.twig',[
            'countryCode' => $countryCode,
            'cityName' => $cityName
        ]);
    }
}
