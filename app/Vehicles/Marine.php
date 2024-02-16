<?php

namespace App\Vehicles;

class Marine implements Vehicle
{
    use CommonVehicleBehaviour, KnotsTraveler;

    protected $type = "Marine";
}