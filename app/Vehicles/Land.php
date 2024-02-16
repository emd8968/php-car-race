<?php

namespace App\Vehicles;

class Land implements Vehicle
{
    use CommonVehicleBehaviour, KmphTraveler;

    protected $type = "Land";

}