<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\ForecastRepository;

class ForecastService
{
    public function __construct(private ForecastRepository $forecastRepository) {

    }
    public function getAll(): array | null
    {
        return $this->forecastRepository->findAll();
    }
    public function getForecastsByLocationId(string $locationId) : array | null
    {
        $forecasts = $this->forecastRepository->findBy([
            'location' => $locationId
        ]);
        return $forecasts;
    }
}