<?php

namespace App\Controller;

use App\Exception\LocationNotFoundException;
use App\Service\ForecastService;
use App\Service\LocationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;

#[Route('api/v1/weather')]
class WeatherApiController extends AbstractController
{
    #[Route('/location')]
    public function location(LocationService $locationService): JsonResponse
    {
        $locations = $locationService->getAll();
        return $this->json([
            'locations' => $locations
        ]);
    }
    #[Route('/forecasts/{cityName}/{countryCode}')]
    public function forecasts(LocationService $locationService, ForecastService $forecastService,string  $cityName,string $countryCode): JsonResponse
    {
        $location = $locationService->getLocationByCityAndCountryCode($cityName,$countryCode);
        if($location)
        {
            $forecasts =  $forecastService->getForecastsByLocationId($location->getId());

            $context = (new ObjectNormalizerContextBuilder())
           ->withGroups('api')
           ->toArray();
//
//        return $this->json($forecasts, context: $context);

            return $this->json(
                $forecasts,
                context: $context
            );
        }
        else
        {
            throw new LocationNotFoundException();
        }
    }
}
