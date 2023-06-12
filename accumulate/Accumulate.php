<?php

declare(strict_types=1);

function accumulate(array $input, callable $accumulator): array
{    
    return array_map($accumulator, $input);
}