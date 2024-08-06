<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Location;
use App\Repository\LocationRepository;

class LocationService
{
    public function __construct(private LocationRepository $locationRepository)
    {
        
    }
    public function getAll(): array | null
    {
        return $this->locationRepository->findAll();
    }
    public function getLocationByCityAndCountryCode(
        string $cityName, 
        string $countryCode
        ) : Location | null
    {
        $location = $this->locationRepository->findOneBy([
            'name' => $cityName,
            'countryCode' => $countryCode
        ]);

        return $location;
    }
}