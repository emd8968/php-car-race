<?php

namespace App\Game;

use App\Vehicles\Vehicle;

class Result
{
    protected $first;

    protected $second;

    /**
     * @param Player $firstPlayer
     * @param Player $secondPlayer
     * @param $firstRecord
     * @param $secondRecord
     */
    public function __construct($firstPlayer, $secondPlayer, $firstRecord, $secondRecord)
    {

        $this->first = [
            'player' => $firstPlayer,
            'record' => $firstRecord
        ];
        $this->second = [
            'player' => $secondPlayer,
            'record' => $secondRecord
        ];
    }

    /**
     * returns first place player, return array format is:
     * [
     *   'player' => Player Object
     *   'record' => record in hours
     * ]
     * @return array
     */
    public function getFirst()
    {
        return $this->first;
    }

    /**
     * returns second place player, return array format is:
     * [
     *   'player' => Player Object
     *   'record' => record in hours
     * ]
     * @return array
     */
    public function getSecond()
    {
        return $this->second;
    }


}