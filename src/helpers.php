<?php


function findCargoById($id, $database): array
{
    $result = [];

    foreach ($database as $cargo) {
        if ($cargo["id"] == $id) {
            $result = $cargo;
        }
    }

    return $result;
}