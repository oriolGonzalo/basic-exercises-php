<?php

/*
 * By adding type hints and enabling strict type checking, code can become
 * easier to read, self-documenting and reduce the number of potential bugs.
 * By default, type declarations are non-strict, which means they will attempt
 * to change the original type to match the type specified by the
 * type-declaration.
 *
 * In other words, if you pass a string to a function requiring a float,
 * it will attempt to convert the string value to a float.
 *
 * To enable strict mode, a single declare directive must be placed at the top
 * of the file.
 * This means that the strictness of typing is configured on a per-file basis.
 * This directive not only affects the type declarations of parameters, but also
 * a function's return type.
 *
 * For more info review the Concept on strict type checking in the PHP track
 * <link>.
 *
 * To disable strict typing, comment out the directive below.
 */

declare(strict_types=1);

class Tournament
{
    private const AVAILABLE_CHARS_FOR_TEAM_NAME = 31; // Available chars for each team name in the results table.
    private $resultsTable ;
    private $statistics;
    private $standings;

    public function __construct()
    {                                                                
        $this->resultsTable = 'Team                           | MP |  W |  D |  L |  P';
        $this->statistics = [];
        $this->standings = [];
    }
    public function addTeamsIfNeeded(string $firstTeam, string $secondTeam, Tournament $tournament): void
    {
        $teamsToAdd = [$firstTeam, $secondTeam];
        $defaultTeamStatistics = [
            'MP' => 0,
            'W' => 0,
            'D' => 0,
            'L' => 0,
            'P' => 0
        ];

        foreach($teamsToAdd as $index => $teamToAdd)
        {            
            $teamIsAlreadyAdded = array_key_exists("$teamToAdd", $tournament->statistics);

            if ($teamIsAlreadyAdded)  continue; 

            $tournament->statistics["$teamToAdd"] = $defaultTeamStatistics;
            array_push($tournament->standings, $teamToAdd);
        }
    }
    public function updateStatistics(string $firstTeam, string $secondTeam, string $firstTeamResult, Tournament $tournament):void
    {
        switch ($firstTeamResult) 
        {
            case 'win':
                $tournament->statistics[$firstTeam]['MP'] += 1;
                $tournament->statistics[$firstTeam]['W']  += 1;
                $tournament->statistics[$firstTeam]['P']  += 3;
        
                $tournament->statistics[$secondTeam]['MP'] += 1;
                $tournament->statistics[$secondTeam]['L']  += 1;                
                break;
            case 'loss':
                $tournament->statistics[$secondTeam]['MP'] += 1;
                $tournament->statistics[$secondTeam]['W']  += 1;
                $tournament->statistics[$secondTeam]['P']  += 3;
        
                $tournament->statistics[$firstTeam]['MP'] += 1;
                $tournament->statistics[$firstTeam]['L']  += 1;                
                break;
            case 'draw':
                $tournament->statistics[$firstTeam]['MP'] += 1;
                $tournament->statistics[$firstTeam]['D'] += 1;
                $tournament->statistics[$firstTeam]['P'] += 1;

                $tournament->statistics[$secondTeam]['MP'] += 1;
                $tournament->statistics[$secondTeam]['D'] += 1;
                $tournament->statistics[$secondTeam]['P'] += 1;
                break;
        }
    }
    public function setInAlphabeticalOrder(&$standings, $j)
    {
        $k = 0;
        $foundDifference = False;
        $previousTeamAlphabeticalScore = 0;
        $currentTeamAlphabeticalScore = 0;

        while (($k < strlen($standings[$j - 1])) && ($k < strlen($standings[$j])) && ($foundDifference == false)) 
        {
            $previousTeamAlphabeticalScore += ord($standings[$j - 1][$k]);
            $currentTeamAlphabeticalScore += ord($standings[$j][$k]);

            if ($standings[$j - 1][$k] != $standings[$j][$k]) $foundDifference = true;

            $k++;
        }    
        if ($previousTeamAlphabeticalScore > $currentTeamAlphabeticalScore)
        {
            [$standings[$j - 1], $standings[$j]] = [$standings[$j], $standings[$j - 1]];
        }
    }
    public function sortStandings(Array &$standings, Array $statistics, Tournament $tournament): void
    {
        for ($i = 1; $i < sizeof($standings); $i++)
        {
            $j = $i;

            while ($j > 0 && ($statistics[$standings[$j - 1]]['P'] <= $statistics[$standings[$j]]['P']))
            {
                if ($statistics[$standings[$j - 1]]['P'] === $statistics[$standings[$j]]['P'])
                {
                    $tournament->setInAlphabeticalOrder($standings, $j);
                } else
                {
                    [$standings[$j - 1], $standings[$j]] = [$standings[$j], $standings[$j - 1]];
                }
                $j--;
            }
        }
    }
    public function setResultsTable (string &$resultsTable, Array $standings,Array $statistics)
    {
        foreach($standings as $team)
        {
            $numberOfCharsInTeamName = mb_strlen($team); // Number of chars that the current team name takes up.
            $numberOfWhiteSpaceCharsToInsert = Tournament::AVAILABLE_CHARS_FOR_TEAM_NAME - $numberOfCharsInTeamName; // Number of total whitespace characters to be added.

            $resultsTable = $resultsTable . 
            "\n" .
            $team .
            str_repeat(' ', $numberOfWhiteSpaceCharsToInsert) . 
            '|  ' . $statistics[$team]['MP'] . ' ' .
            '|  ' . $statistics[$team]['W'] . ' ' .
            '|  ' . $statistics[$team]['D'] . ' ' .
            '|  ' . $statistics[$team]['L'] . ' ' .
            '|  ' . $statistics[$team]['P'];
        }
    }
    public function tally(string $scores): string
    {
        $tournament = new Tournament();

        if (isset($scores) && $scores !== '') 
        {
            $matches = explode(PHP_EOL, $scores);
    
            foreach ($matches as $match) 
            {
                list($firstTeam, $secondTeam, $firstTeamResult) = explode(';', $match);
                $tournament->addTeamsIfNeeded($firstTeam, $secondTeam, $tournament);
                $tournament->updateStatistics($firstTeam, $secondTeam, $firstTeamResult, $tournament);
                $tournament->sortStandings($tournament->standings, $tournament->statistics, $tournament);
            }
            $tournament->setResultsTable($tournament->resultsTable, $tournament->standings, $tournament->statistics);
        }
        return $tournament->resultsTable;
    }
}