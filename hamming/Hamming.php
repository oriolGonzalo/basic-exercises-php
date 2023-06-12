<?php

declare(strict_types=1);

function distance(string $strandA, string $strandB): int
{
    if (strlen($strandA) != strlen($strandB)) {
        throw new InvalidArgumentException('DNA strands must be of equal length.');
    } 
    $splitedStrandA = str_split($strandA);
    $splitedStrandB = str_split($strandB);
    $distance = 0;

    foreach ($splitedStrandA as $index => $currentCharInStrandA) {
        $currentCharInStrandB = $splitedStrandB[$index];
        
        if ($currentCharInStrandA != $currentCharInStrandB) $distance++;
    }
    return $distance;
}