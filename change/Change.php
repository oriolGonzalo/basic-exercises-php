<?php

declare(strict_types=1);

function findFewestCoins(array $coins, int $amount): array
{
    $change = [];
    $minNumOfCoinsNeeded = -1;
    $minFoundInLastIteration = true;

    while ($minFoundInLastIteration)
    {
        $currentChange = findCoins($coins, $amount);
        $currentNumOfCoinsNeeded = sizeof($currentChange);

        if ($currentNumOfCoinsNeeded < $minNumOfCoinsNeeded || $minNumOfCoinsNeeded === -1)
        {
            $minNumOfCoinsNeeded = $currentNumOfCoinsNeeded;
            $change = $currentChange;
        } else $minFoundInLastIteration = false;
    }
    //var_dump($change);
    return $change;
}

/*
function findCoins(array &$coins, int $amount): array
{
    $change = [];
    $accumulatedAmount = 0;
    $reachedAmount = false;
    $i = sizeof($coins) - 1;

    while ($i >= 0 && !$reachedAmount)
    {
        $accumulatedAmount += $coins[$i];
        array_push($change, $coins[$i]);

        if ($accumulatedAmount === $amount) 
        {
            $reachedAmount = true;
        } else if ($accumulatedAmount > $amount)
        {
            $accumulatedAmount -= $coins[$i];
            array_pop($change);
            $i--;
        }
    }
    array_pop($coins);
    return array_reverse($change);
}
*/

function findCoins(array &$coins, int $amount): array
{
    $change = [];
    $accumulatedAmount = 0;
    $reachedAmount = false;
    $i = sizeof($coins) - 1;

    while ($i >= 0 && !$reachedAmount)
    {       
        if ($amount === $accumulatedAmount)
        {
            $reachedAmount = true;
        } else if ($amount - $accumulatedAmount > $coins[$i])
        {
            $accumulatedAmount += $coins[$i];
            array_push($change, $coins[$i]);
        } else if (isset($coins[$i - 1]))
        {
            $i--;
        } else if (isset($coins[$i + 1]))
        {
            $accumulatedAmount -= $coins[$i + 1];
            unset($change[array_search($coins[$i + 1], $change)]);
            var_dump($change);
            var_dump($change[array_search($coins[$i + 1], $change)]);
        }  
    }
    array_pop($coins);
    return array_reverse($change);
}
findFewestCoins([4, 5], 27);