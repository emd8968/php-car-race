<?php
require __DIR__ . '/vendor/autoload.php';

\cli\line('%C========== Welcome To Vehicle Racing Game ==========%n');
\cli\line('');
\cli\line('%CThere will be two players with their respective vehicles%n');
\cli\line('');

$playerName = "";
$playerVehicle = null;

$vehicles = App\Vehicles\VehiclesFactory::makeVehiclesFromJsonFile(__DIR__ . '/vehicles.json');

$vehiclesMenu = [];
foreach ($vehicles as $vehicle) {
    $vehiclesMenu[] = $vehicle->getName();
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

$player1 = new \App\Game\Player($playerName, $playerVehicle);

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

$player2 = new \App\Game\Player($playerName, $playerVehicle);

$race = new \App\Game\Race($player1, $player2, 1000);


var_dump($race->calculateResult());