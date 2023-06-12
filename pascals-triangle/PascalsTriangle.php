<?php

declare(strict_types=1);

function getDigitToAdd(array &$triangleArray, int $i, int $j)
{
    if (isset($triangleArray[$i - 1][$j]) && isset($triangleArray[$i - 1][$j - 1]))
    {
        return $triangleArray[$i - 1][$j] + $triangleArray[$i - 1][$j - 1];
    }
    return 1;
}

function pascalsTriangleRows($rowCount)
{
    if (is_null($rowCount) || $rowCount < 0) return -1;

    $triangleArray = [];

    for ($i = 0; $i < $rowCount; $i++)
    {
        $rowArray = [];

        for ($j = 0; $j <= $i; $j++) # Append right digits to row string and array
        {
            $digitToAdd = getDigitToAdd($triangleArray, $i, $j);
            array_push($rowArray, $digitToAdd);
        }
        array_push($triangleArray, $rowArray);
    }
    return $triangleArray;
}