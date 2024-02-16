<?php

namespace App\Vehicles;

interface Vehicle
{
    public function calculateTravelTime($distanceInKm);
    public function getName();
    public function getType();
    public function getSpeed();
    public function getSpeedUnit();

}