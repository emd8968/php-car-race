<?php

namespace App\Game;

use App\Vehicles\Vehicle;

class Player
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var Vehicle
     */
    protected $vehicle;

    /**
     * @param string $name
     * @param Vehicle $vehicle
     */
    public function __construct($name, $vehicle)
    {
        $this->name = $name;
        $this->vehicle = $vehicle;
    }

    /**
     * @return Vehicle
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


}