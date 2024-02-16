<?php

namespace App\Game;

class Race
{
    /**
     * @var Player
     */
    protected $player1;
    /**
     * @var Player
     */
    protected $player2;

    /**
     * @var int
     */
    protected $distanceInKM;

    /**
     * @param Player $player1
     * @param Player $player2
     */
    public function __construct($player1, $player2, $distanceInKM)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->distanceInKM = $distanceInKM;
    }

    public function calculateResult()
    {
        $p1Record = $this->player1->getVehicle()->calculateTravelTime($this->distanceInKM);
        $p2Record = $this->player2->getVehicle()->calculateTravelTime($this->distanceInKM);

        if ($p1Record > $p2Record) {
            return new Result($this->player2, $this->player1, $p2Record, $p1Record);
        }
        else{
            return new Result($this->player1, $this->player2, $p1Record, $p2Record);
        }

    }

}