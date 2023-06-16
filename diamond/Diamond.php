<?php

declare(strict_types=1);

function diamond(string $letter): array
{
    $diamond = [];
    $numOfRows = ord($letter) - 64;
    $string = "";

    for ($j = 0; $j < $numOfRows; $j++) { 
        if ($j === 0) {
            array_push($diamond, str_pad(chr(65 + $j), $numOfRows, ".", STR_PAD_BOTH));
            echo str_pad(chr(65 + $j), $numOfRows, ".", STR_PAD_BOTH) . "\n";
        } else {
            echo str_pad(chr(65 + $j), $numOfRows, ".") .  
            str_pad(chr(65 + $j), $numOfRows, ".", STR_PAD_LEFT) .
            "\n";
        }
    }
    echo $string;
    return $diamond;
}

diamond("C");