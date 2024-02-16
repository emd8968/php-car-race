<?php

namespace App\Vehicles;

class Aerial implements Vehicle
{
    use CommonVehicleBehaviour, KnotsTraveler;

    protected $type = "Aerial";
}