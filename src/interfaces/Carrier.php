<?php

include_once 'Movable.php';


interface Carrier extends Movable
{
    public function getType(): string;
    public function getCapacity(): float;
    public function getCarrierSpaceSize(): array;
    public function getAvailableDestinations(): array;
    public function getAvailableCargoTypes(): array;
    public function getCargoList(): array;
    public function getTotalCargoWeight(): float;
    public function loadCargo(array $cargo): bool;
    public function unloadCargo(array $cargo): bool;
}