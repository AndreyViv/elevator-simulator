<?php

include_once "src/PassengerElevator.php";
include_once "src/helpers.php";


$cargoDataBaseMock = [
    [
        "id" => 1,
        "type" => "passenger",
        "name" => "Jhon",
        "weight" => 90.00,
        "location" => "1 floor",
        "destination" => "3 floor",
        "direction" => "up"
    ],
    [
        "id" => 2,
        "type" => "passenger",
        "name" => "Ivan",
        "weight" => 80.00,
        "location" => "2 floor",
        "destination" => "5 floor",
        "direction" => "up"
    ],
    [
        "id" => 3,
        "type" => "box",
        "name" => "Jhon`s box",
        "weight" => 10.00,
        "location" => "1 floor",
        "destination" => "5 floor",
        "direction" => "up"
    ],
    [
        "id" => 4,
        "type" => "passenger",
        "name" => "Anton",
        "weight" => 60.00,
        "location" => "3 floor",
        "destination" => "5 floor",
        "direction" => "up"
    ]
];

$floors = [1, 2, 3, 4, 5];
$passengerElevator = new PassengerElevator("№1", [1, 2, 3, 4, 5]);

foreach ($cargoDataBaseMock as $cargo) {
    $passengerElevator->setDestination($cargo['location']);
}

foreach ($floors as $floorNum) {
    $cargoIds = [];

    if (in_array($floorNum, $passengerElevator->getAvailableDestinations())) {
        $passengerElevator->stop();
        $cargoIds = $passengerElevator->checkFloorCargo($cargoDataBaseMock);

        foreach ($cargoIds["forunload"] as $id) {
            $cargo = findCargoById($id, $cargoDataBaseMock);

            if ($passengerElevator->unloadCargo($cargo)) {
                $cargo["destination"] = null;
                $cargo["location"] = $floorNum . " floor";
            }
        }

        foreach ($cargoIds["forload"] as $id) {
            $cargo = findCargoById($id, $cargoDataBaseMock);

            if ($passengerElevator->loadCargo($cargo)) {
                $cargo["location"] = "elevator";
                $passengerElevator->setDestination($cargo["destination"]);
            }
        }
    }

    $passengerElevator->move("up");
}


