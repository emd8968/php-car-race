<?php

namespace App\Vehicles;

trait KnotsTraveler
{
    public function calculateTravelTime($distanceInKm)
    {
        return $distanceInKm / ($this->getSpeed() * 1.852);
    }

    public function getSpeedUnit()
    {
        return "Knots";
    }

}