<?php

include_once "interfaces/Carrier.php";


abstract class Elevator implements Carrier
{
    protected $availableFloors = [];
    protected $availableCargoTypes = [];
    protected $currentFloor = 1;
    protected $currentDirection = null;
    protected $currentCargo = [];
    protected $requiredFloors = [];

    protected $type;
    protected $name;
    protected $capacity;
    protected $carrierHeight;
    protected $carrierWidth;
    protected $carrierDepth;

    abstract function checkFloorCargo(array $cargoData): array;

    public function setDestination(string $requiredDestination)
    {
        if (!$floorNum = intval($requiredDestination))
        {
            echo "WARNING: Cant parse floor number from: " . $requiredDestination . "</br>";
            return ;
        }

        if (!in_array($floorNum, $this->availableFloors))
        {
            echo "WARNING: Requested floor not allowed!</br>";
            return ;
        }

        if (!in_array($floorNum, $this->requiredFloors))
        {
            $this->requiredFloors[] = $floorNum;
            sort($this->requiredFloors);

            echo "Floor " . $floorNum . " add to required floors</br>";
            return;
        }
    }

    public function getDestinations(): array
    {
        return $this->requiredFloors;
    }

    public function getLocation(): string
    {
        return $this->currentFloor . " floor";
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCapacity(): float
    {
        return $this->capacity;
    }

    public function getCarrierSpaceSize(): array
    {
        return [$this->carrierHeight, $this->carrierWidth, $this->carrierDepth];
    }

    public function getCargoList(): array
    {
        return $this->currentCargo;
    }

    public function getTotalCargoWeight(): float
    {
        $result = 0.00;

        foreach ($this->currentCargo as $cargo) {
            $result += $cargo["weight"];
        }

        return $result;
    }

    public function getAvailableDestinations(): array
    {
        return $this->availableFloors;
    }

    public function getAvailableCargoTypes(): array
    {
        return $this->availableCargoTypes;
    }

    public function move(string $direction)
    {
        $availableDirections = ["up", "down"];

        if (!in_array($direction, $availableDirections))
        {
            echo 'WARNING: Wrong direction for Elevator object! '
                . 'Requested: "' . $direction . '". Required: "up" or "down"</br>';
            return;
        }

        $this->currentDirection = $direction;

        if ($direction == "up") {
            $nextFloor = $this->currentFloor + 1;
        } else {
            $nextFloor = $this->currentFloor - 1;
        }

        if ($nextFloor >= $this->availableFloors[0] && $nextFloor <= end($this->availableFloors)) {
            echo "Elevator " . $this->name . " started moving "
                . $direction . " from " . $this->currentFloor . " floor</br>";

            $this->currentFloor = $nextFloor;
        }
    }

    public function stop()
    {
        if (!in_array($this->currentFloor, $this->availableFloors))
        {
            echo 'WARNING: Forbidden floor for current Elevator! </br>';
            return;
        }

        if (!in_array($this->currentFloor, $this->requiredFloors))
        {

            return;
        }

        echo "Elevator " . $this->name . " stopped on " . $this->currentFloor . " floor</br>";
    }

    public function loadCargo(array $cargo): bool
    {
        $message = $cargo["name"] . " can`t be loaded to Elevator </br>";
        $result = false;

        if (count($cargo) > 0 && $cargo["weight"] + $this->getTotalCargoWeight() < $this->capacity)
        {
            $this->currentCargo[] = $cargo;

            $message = $cargo["name"] . " loaded to Elevator " . $this->name . "</br>";
            $result = true;
        }

        echo $message;
        return $result;
    }

    public function unloadCargo(array $cargo): bool
    {
        $message = $cargo["name"] . " not located in Elevator </br>";
        $result = false;

        foreach ($this->currentCargo as $key => $localCargo)
        {
            if ($cargo["id"] === $localCargo["id"])
            {
                unset($this->currentCargo[$key]);

                $message = $cargo["name"] . " removed from Elevator </br>";
                $result = true;
                break;
            }
        }

        if ($result)
        {
            foreach ($this->requiredFloors as $key => $val)
            {
                if ($val == $this->currentFloor)
                {
                    unset($this->requiredFloors[$key]);
                    break;
                }
            }
        }

        echo $message;
        return $result;
    }
}