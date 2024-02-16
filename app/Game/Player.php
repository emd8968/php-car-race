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
     * @var int
     */
    protected $playerNumber;
    /**
     * @var Vehicle
     */
    protected $vehicle;

    /**
     * @param string $name
     * @param Vehicle $vehicle
     */
    public function __construct($name, $vehicle, $playerNumber)
    {
        $this->name = $name;
        $this->playerNumber = $playerNumber;
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

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->playerNumber;
    }


}