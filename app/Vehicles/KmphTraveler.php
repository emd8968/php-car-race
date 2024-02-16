<?php

namespace App\Vehicles;

trait KmphTraveler
{
    public function calculateTravelTime($distanceInKm)
    {
        return $distanceInKm / $this->getSpeed();
    }

    public function getSpeedUnit()
    {
        return "KM/H";
    }

}