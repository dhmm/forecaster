<?php

namespace App\Tests;

use App\Entity\Forecast;
use PHPUnit\Framework\TestCase;

class ForecastTest extends TestCase
{
    public function dataAdd(): array
    {
        $data = [
            [10, 50],
            [0, 32],
            [-20, -4],
            [1, 34],
            [-1, 30],
            [50, 122],
            [-50, -58],
        ];
        return $data;
    }
    /**
     * @dataProvider dataAdd
     */
    public function testtemperatureToFarenheit(int $celsius , int $farenheit): void
    {
        $forecast = new Forecast();

        $forecast->setTemperatureCelsius($celsius);
        $result = $forecast->getTemperatureFarenheit();
        $this->assertEquals($farenheit, $result , "$celsius Celcius must be $farenheit Farenheits");

    
        $forecast->setFlTemperatureCelsius($celsius);
        $result = $forecast->getFlTemperatureFahrenheit();
        $this->assertEquals($farenheit, $result , "$celsius Feeling Celcius must be $farenheit Feeling Farenheits");

        
    }
}
