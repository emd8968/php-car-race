<?php

namespace App\Vehicles;

class VehiclesFactory
{

    /**
     * @param $filePath
     * @return Vehicle[]
     */
    public static function makeVehiclesFromJsonFile($filePath)
    {
        $vehiclesJson = json_decode(file_get_contents($filePath), true);
        $vehicles = [];
        foreach ($vehiclesJson as $item) {

            //skipping invalid items
            if (!isset($item['unit']) || !isset($item['name']) || !isset($item['maxSpeed'])) {
                continue;
            }

            switch (strtolower($item['unit'])) {
                case "km/h":
                    $vehicles[] = new Land($item['name'], $item['maxSpeed']);
                    break;
                case "knots":
                    $vehicles[] = new Marine($item['name'], $item['maxSpeed']);
                    break;
                case "kts":
                    $vehicles[] = new Aerial($item['name'], $item['maxSpeed']);
                    break;
            }
        }
        return $vehicles;
    }
}