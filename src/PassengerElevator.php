<?php

include_once "Elevator.php";


class PassengerElevator extends Elevator
{
    protected $type = "Passenger Elevator";
    protected $availableCargoTypes = ["passenger"];
    protected $capacity = 1000;
    protected $carrierHeight = 220;
    protected $carrierWidth = 150;
    protected $carrierDepth = 200;

    public function __construct(string $name, array $availableFloors)
    {
        $this->name = $name;
        $this->availableFloors = $availableFloors;
        sort($this->availableFloors);
    }

    function checkFloorCargo(array $cargoData): array
    {
        $cargoIDs = [
            "forload" => [],
            "forunload" => []
        ];

        foreach ($cargoData as $cargo)
        {
            if (in_array($cargo["type"], $this->availableCargoTypes)
                && ($cargo["direction"] == $this->currentDirection || $this->currentDirection == null)
                && $cargo["location"] == $this->currentFloor . " floor")
            {
                $cargoIDs["forload"][] = $cargo["id"];
            }
        }

        foreach ($this->currentCargo as $cargo)
        {
            if ($cargo["destination"] == $this->currentFloor . " floor")
            {
                $cargoIDs["forunload"][] = $cargo["id"];
            }
        }

        return $cargoIDs;
    }
}