<?php

namespace App;

use App\Game\Player;
use App\Game\Race;
use App\Vehicles\Vehicle;
use App\Vehicles\VehiclesFactory;
use cli\Colors;
use cli\Shell;
use function cli\line;
use function cli\menu;

class Application
{
    /**
     * @var Vehicle[]
     */
    protected $vehicles = [];

    /**
     * @var array
     */
    protected $vehiclesMenuItems = [];

    public function start($liveRace = false)
    {
        line('%C========== Welcome To Vehicle Racing Game ==========%n');
        line('');
        line('%CThere will be two players with their respective vehicles%n');
        line('');

        $raceLength = 0;

        $this->initializeVehicles();

        while (true) {
            echo Colors::colorize('%CEnter Race Track Length In Kilometers:%n', true);
            $raceLength = (int)readline("");
            if ($raceLength > 0) {
                break;
            } else {
                line('%RTrack length have to be a number greater than zero%n');
            }
        }

        $player1 = $this->getPlayerInfoFromUser(1);

        $player2 = $this->getPlayerInfoFromUser(2);

        $race = new Race($player1, $player2, $raceLength);

        $result = $race->calculateResult();

        if ($liveRace) {
            $this->showLiveRace($result);
        }
        $this->showBasicTextResults($result);
    }

    protected function initializeVehicles()
    {
        $vehicles = VehiclesFactory::makeVehiclesFromJsonFile($GLOBALS['APPLICATION_ROOT'] . '/vehicles.json');

        $vehiclesMenu = [];
        foreach ($vehicles as $vehicle) {
            $vehiclesMenu[] = $vehicle->getName();
        }

        $this->vehicles = $vehicles;
        $this->vehiclesMenuItems = $vehiclesMenu;
    }

    protected function getPlayerInfoFromUser($number)
    {
        while (true) {
            echo Colors::colorize("%CEnter Player$number Name:%n", true);
            $playerName = readline("");
            if (!empty($playerName)) {
                break;
            } else {
                line('%RPlayer name have to be entered%n');
            }
        }

        $choice = menu($this->vehiclesMenuItems, null, 'Choose a vehicle');
        line();
        $playerVehicle = $this->vehicles[$choice];

        return new Player($playerName, $playerVehicle, $number);
    }

    protected function getSpeedRatio($result)
    {
        return $result->getFirst()['record'] / $result->getSecond()['record'];
    }

    protected function showLiveRace($result)
    {
        $columns = Shell::columns();

        $speedRatio = $this->getSpeedRatio($result);

        $screenTrackLen = $columns - 5;

        $firstPositionIndicator = "P" . $result->getFirst()['player']->getNumber();
        $secondPositionIndicator = "P" . $result->getSecond()['player']->getNumber();

        echo Colors::colorize("%YRace:||" . str_repeat("-", $screenTrackLen - 2));


        for ($i = 1; $i <= 10; $i++) {

            sleep(1);

            if ($i === 10) {
                $checkPointLen = $screenTrackLen;
            } else {
                $checkPointLen = floor($screenTrackLen / 10) * $i;
            }

            if ($speedRatio === 1.0) {
                $trackOutput = str_repeat("-", $checkPointLen - 2) . "||";
            } else {
                $secondPlace = floor($speedRatio * $checkPointLen) - 2;
                $secondPlace = $secondPlace < 0 ? 0 : $secondPlace;
                $secondPlace = $secondPlace + 4 > $checkPointLen ? $checkPointLen - 4 : $secondPlace;
                $trackOutput = str_repeat("-", $secondPlace) . $secondPositionIndicator;
                $trackOutput .= str_repeat("-", $checkPointLen - strlen($trackOutput) - 2) . $firstPositionIndicator;
            }
            echo "\033[" . ($columns) . "D";
            echo Colors::colorize("%YRace:" . $trackOutput . str_repeat(" ", $screenTrackLen - strlen($trackOutput)) . "%n");
        }

        line('');
        line('');
    }

    protected function showBasicTextResults($result)
    {
        $speedRatio = $this->getSpeedRatio($result);

        if ($speedRatio === 1.0) {
            line('%GPlayer' . $result->getFirst()['player']->getNumber() . '(' . $result->getFirst()['player']->getName() . ') finished the line by ' . $result->getFirst()['player']->getVehicle()->getName() . '(' . $result->getFirst()['player']->getVehicle()->getType() . ') with record of ' . $result->getFirst()['record'] . ' hours %n');
            line('');
            line('%GPlayer' . $result->getSecond()['player']->getNumber() . '(' . $result->getSecond()['player']->getName() . ') finished the line by ' . $result->getSecond()['player']->getVehicle()->getName() . '(' . $result->getSecond()['player']->getVehicle()->getType() . ') with record of ' . $result->getSecond()['record'] . ' hours %n');
        } else {
            line('%GCongratulations! Player' . $result->getFirst()['player']->getNumber() . '(' . $result->getFirst()['player']->getName() . ') won the race by ' . $result->getFirst()['player']->getVehicle()->getName() . '(' . $result->getFirst()['player']->getVehicle()->getType() . ') with record of ' . $result->getFirst()['record'] . ' hours %n');
            line('');
            line('%RPlayer' . $result->getSecond()['player']->getNumber() . '(' . $result->getSecond()['player']->getName() . ') finished the line by ' . $result->getSecond()['player']->getVehicle()->getName() . '(' . $result->getSecond()['player']->getVehicle()->getType() . ') with record of ' . $result->getSecond()['record'] . ' hours %n');
        }
        line('');
    }
}