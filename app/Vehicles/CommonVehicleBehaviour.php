<?php

namespace App\Vehicles;

trait CommonVehicleBehaviour
{
    protected $name;
    protected $speed;

    public function __construct($name = "undefined", $speed = 0)
    {
        $this->setName($name);
        $this->setSpeed((float)$speed);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        return $this->name = $name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getSpeed()
    {
        return $this->speed;
    }

    public function setSpeed($speed)
    {
        return $this->speed = (float)$speed;
    }

}