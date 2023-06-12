<?php

declare(strict_types=1);

function toRna(string $dna): string
{
    $transcriptionTable = [
        "G" => "C",
        "C" => "G",
        "T" => "A",
        "A" => "U"
    ];
    $resultingRnaSequence = "";

    foreach (str_split($dna) as $nucleotide) 
    {
        $resultingRnaSequence = $resultingRnaSequence . $transcriptionTable[$nucleotide];
    }
    return $resultingRnaSequence;
}
