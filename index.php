<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/wp-cli/php-cli-tools/examples/common.php';

$columns = cli\Shell::columns();

\cli\line('%C========== Welcome To Vehicle Racing Game ==========%n');
\cli\line('');
\cli\line('%CThere will be two players with their respective vehicles%n');
\cli\line('');

$playerName = "";
$raceLength = 0;
$playerVehicle = null;

$vehicles = App\Vehicles\VehiclesFactory::makeVehiclesFromJsonFile(__DIR__ . '/vehicles.json');

$vehiclesMenu = [];
foreach ($vehicles as $vehicle) {
    $vehiclesMenu[] = $vehicle->getName();
}

while (true) {
    echo \cli\Colors::colorize('%CEnter Race Track Length In Kilometers:%n', true);
    $raceLength = (int)readline("");
    if ($raceLength > 0) {
        break;
    } else {
        \cli\line('%RTrack length have to be a number greater than zero%n');
    }
}

while (true) {
    echo \cli\Colors::colorize('%CEnter Player 1 Name:%n', true);
    $playerName = readline("");
    if (!empty($playerName)) {
        break;
    } else {
        \cli\line('%RPlayer name have to be entered%n');
    }
}

$choice = \cli\menu($vehiclesMenu, null, 'Choose a vehicle');
\cli\line();
$playerVehicle = $vehicles[$choice];

$player1 = new \App\Game\Player($playerName, $playerVehicle, 1);

while (true) {
    echo \cli\Colors::colorize('%CEnter Player 2 Name:%n', true);
    $playerName = readline("");
    if (!empty($playerName)) {
        break;
    } else {
        \cli\line('%RPlayer name have to be entered%n');
    }
}

$choice = \cli\menu($vehiclesMenu, null, 'Choose a vehicle');
\cli\line();
$playerVehicle = $vehicles[$choice];

$player2 = new \App\Game\Player($playerName, $playerVehicle, 2);

$race = new \App\Game\Race($player1, $player2, $raceLength);


$result = $race->calculateResult();

$speedRatio = $result->getFirst()['record'] / $result->getSecond()['record'];

$screenTrackLen = $columns - 5;

$firstPositionIndicator = "P" . $result->getFirst()['player']->getNumber();
$secondPositionIndicator = "P" . $result->getSecond()['player']->getNumber();


echo \cli\Colors::colorize("%YRace:||" . str_repeat("-", $screenTrackLen - 2));


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
    echo \cli\Colors::colorize("%YRace:" . $trackOutput . str_repeat(" ", $screenTrackLen - strlen($trackOutput)) . "%n");
}

\cli\line('');
\cli\line('');

if ($speedRatio === 1.0) {
    \cli\line('%GPlayer' . $result->getFirst()['player']->getNumber() . '(' . $result->getFirst()['player']->getName() . ') finished the line by ' . $result->getFirst()['player']->getVehicle()->getName() . '(' . $result->getFirst()['player']->getVehicle()->getType() . ') with record of ' . $result->getFirst()['record'] . ' hours %n');
    \cli\line('');
    \cli\line('%GPlayer' . $result->getSecond()['player']->getNumber() . '(' . $result->getSecond()['player']->getName() . ') finished the line by ' . $result->getSecond()['player']->getVehicle()->getName() . '(' . $result->getSecond()['player']->getVehicle()->getType() . ') with record of ' . $result->getSecond()['record'] . ' hours %n');
} else {
    \cli\line('%GCongratulations! Player' . $result->getFirst()['player']->getNumber() . '(' . $result->getFirst()['player']->getName() . ') won the race by ' . $result->getFirst()['player']->getVehicle()->getName() . '(' . $result->getFirst()['player']->getVehicle()->getType() . ') with record of ' . $result->getFirst()['record'] . ' hours %n');
    \cli\line('');
    \cli\line('%RPlayer' . $result->getSecond()['player']->getNumber() . '(' . $result->getSecond()['player']->getName() . ') finished the line by ' . $result->getSecond()['player']->getVehicle()->getName() . '(' . $result->getSecond()['player']->getVehicle()->getType() . ') with record of ' . $result->getSecond()['record'] . ' hours %n');
}
\cli\line('');

