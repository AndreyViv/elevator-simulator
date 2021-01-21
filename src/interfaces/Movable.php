<?php




interface Movable
{
    public function setDestination(string $requiredDestination);
    public function getDestinations(): array;
    public function getLocation(): string;
    public function move(string $direction);
    public function stop();
}