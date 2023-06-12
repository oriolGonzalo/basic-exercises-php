<?php

declare(strict_types=1);

function reverseString(string $text): string
{
    $textLen = mb_strlen($text, "UTF-8");
    $reversedTextArray = $arrayName = array('');

    $arraySize = $textLen;
    $reversedTextArray = array_fill(0, $arraySize, 'c');

    foreach (mb_str_split($text) as $index => $char) {
        $reversedTextArray[$textLen - ($index + 1)] = $char;
    }

    $reversedText = implode('', $reversedTextArray);
    fwrite(STDIN, "$reversedText\n");

    return $reversedText;
}